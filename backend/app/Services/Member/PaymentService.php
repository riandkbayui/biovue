<?php

namespace App\Services\Member;

use App\Models\TransactionsModel;
use App\Models\PlansModel;
use App\Models\PaymentChannelsModel;
use App\Libraries\Auth;

class PaymentService
{
    protected $transactionsModel;
    protected $plansModel;
    protected $paymentChannelsModel;

    public function __construct()
    {
        $this->transactionsModel    = new TransactionsModel();
        $this->plansModel           = new PlansModel();
        $this->paymentChannelsModel = new PaymentChannelsModel();
    }

    /**
     * Ambil paket yang aktif
     */
    public function getActivePlans()
    {
        return $this->plansModel->where('status', 'active')->findAll();
    }

    /**
     * Ambil saluran pembayaran (Bank) yang tersedia
     */
    public function getPaymentChannels()
    {
        return $this->paymentChannelsModel
            ->select('payment_channels.*, banks.name as bank_name, banks.code as bank_code')
            ->join('banks', 'banks.id = payment_channels.bank_id')
            ->where('payment_channels.status', 'active')
            ->findAll();
    }

    /**
     * Buat Transaksi Baru
     */
    public function createTransaction(int $planId)
    {
        $plan = $this->plansModel->find($planId);
        if (!$plan) return ['success' => false, 'message' => 'Paket tidak ditemukan.'];
        if ($plan->price <= 0) return ['success' => false, 'message' => 'Paket ini gratis.'];

        // Generate Kode Unik (3 digit terakhir)
        $uniqueCode = rand(100, 999);
        $totalAmount = $plan->price + $uniqueCode;

        $data = [
            'user_id'     => Auth::id(),
            'plan_id'     => $planId,
            'amount'      => $totalAmount,
            'unique_code' => $uniqueCode,
            'status'      => 'pending',
            'created_by'  => Auth::id()
        ];

        if (!$this->transactionsModel->insert($data)) {
            return ['success' => false, 'message' => 'Gagal membuat transaksi.'];
        }

        return [
            'success' => true,
            'message' => 'Transaksi berhasil dibuat.',
            'data'    => $this->transactionsModel->find($this->transactionsModel->getInsertID())
        ];
    }

    /**
     * Ambil riwayat transaksi user
     */
    public function getUserTransactions()
    {
        return $this->transactionsModel
            ->select('transactions.*, plans.name as plan_name')
            ->join('plans', 'plans.id = transactions.plan_id')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Ambil detail transaksi (cek kepemilikan)
     */
    public function getTransactionDetail(int $id)
    {
        return $this->transactionsModel
            ->select('transactions.*, plans.name as plan_name, plans.description as plan_description')
            ->join('plans', 'plans.id = transactions.plan_id')
            ->where(['transactions.id' => $id, 'user_id' => Auth::id()])
            ->first();
    }

    /**
     * Upload Bukti Bayar
     */
    public function uploadProof(int $id, string $imageUrl)
    {
        $transaction = $this->transactionsModel->where(['id' => $id, 'user_id' => Auth::id()])->first();
        if (!$transaction) return ['success' => false, 'message' => 'Transaksi tidak ditemukan.'];

        $this->transactionsModel->update($id, [
            'payment_proof' => $imageUrl,
            'updated_by'    => Auth::id()
        ]);
        return ['success' => true, 'message' => 'Bukti pembayaran berhasil diunggah. Menunggu konfirmasi admin.'];
    }
}
