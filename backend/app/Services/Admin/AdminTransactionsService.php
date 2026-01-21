<?php

namespace App\Services\Admin;

use App\Models\TransactionsModel;
use App\Models\SubscriptionsModel;
use App\Libraries\Auth;
use CodeIgniter\I18n\Time;

class AdminTransactionsService
{
    protected $transactionsModel;
    protected $subscriptionsModel;

    public function __construct()
    {
        $this->transactionsModel  = new TransactionsModel();
        $this->subscriptionsModel = new SubscriptionsModel();
    }

    public function getAll()
    {
        return $this->transactionsModel
            ->select('transactions.*, users.name as user_name, users.email as user_email, plans.name as plan_name')
            ->join('users', 'users.id = transactions.user_id')
            ->join('plans', 'plans.id = transactions.plan_id')
            ->orderBy('transactions.created_at', 'DESC')
            ->findAll();
    }

    public function getOne(int $id)
    {
        return $this->transactionsModel
            ->select('transactions.*, users.name as user_name, users.email as user_email, plans.name as plan_name')
            ->join('users', 'users.id = transactions.user_id')
            ->join('plans', 'plans.id = transactions.plan_id')
            ->find($id);
    }

    /**
     * Konfirmasi Pembayaran
     */
    public function confirmPayment(int $id)
    {
        $transaction = $this->transactionsModel->find($id);
        if (!$transaction) return ['success' => false, 'message' => 'Transaksi tidak ditemukan.'];
        if ($transaction->status !== 'pending') return ['success' => false, 'message' => 'Transaksi sudah diproses.'];

        // 1. Update Status Transaksi
        $this->transactionsModel->update($id, [
            'status' => 'paid',
            'updated_by' => Auth::id()
        ]);

        // 2. Buat atau Update Langganan (Subscription)
        // Cek apakah user sudah punya langganan aktif
        $existing = $this->subscriptionsModel->where('user_id', $transaction->user_id)->first();
        
        $startedAt = Time::now();
        $expiredAt = $startedAt->addMonths(1); // Default 1 bulan langganan

        if ($existing) {
            // Jika sudah ada, perpanjang dari tanggal sekarang atau expired_at jika masih jauh? 
            // Sederhananya kita set ulang dari sekarang.
            $this->subscriptionsModel->update($existing->id, [
                'plan_id'        => $transaction->plan_id,
                'transaction_id' => $transaction->id,
                'started_at'     => $startedAt->toDateTimeString(),
                'expired_at'     => $expiredAt->toDateTimeString(),
                'status'         => 'active'
            ]);
        } else {
            $this->subscriptionsModel->insert([
                'user_id'        => $transaction->user_id,
                'plan_id'        => $transaction->plan_id,
                'transaction_id' => $transaction->id,
                'started_at'     => $startedAt->toDateTimeString(),
                'expired_at'     => $expiredAt->toDateTimeString(),
                'status'         => 'active'
            ]);
        }

        return ['success' => true, 'message' => 'Pembayaran berhasil dikonfirmasi. Paket user telah aktif.'];
    }

    /**
     * Tolak Pembayaran
     */
    public function rejectPayment(int $id)
    {
        $this->transactionsModel->update($id, [
            'status' => 'failed',
            'updated_by' => Auth::id()
        ]);
        return ['success' => true, 'message' => 'Transaksi ditolak.'];
    }
}
