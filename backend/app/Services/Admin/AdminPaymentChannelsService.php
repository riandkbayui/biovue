<?php

namespace App\Services\Admin;

use App\Models\PaymentChannelsModel;
use App\Libraries\Auth;

class AdminPaymentChannelsService
{
    protected $paymentChannelsModel;

    public function __construct()
    {
        $this->paymentChannelsModel = new PaymentChannelsModel();
    }

    public function getAll()
    {
        return $this->paymentChannelsModel
            ->select('payment_channels.*, banks.name as bank_name, banks.code as bank_code')
            ->join('banks', 'banks.id = payment_channels.bank_id')
            ->findAll();
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        if (!$this->paymentChannelsModel->save($data)) {
            return ['success' => false, 'message' => 'Gagal menambah rekening.', 'errors' => $this->paymentChannelsModel->errors()];
        }
        return ['success' => true, 'message' => 'Rekening berhasil ditambahkan.'];
    }

    public function update(int $id, array $data)
    {
        $data['updated_by'] = Auth::id();
        if (!$this->paymentChannelsModel->update($id, $data)) {
            return ['success' => false, 'message' => 'Gagal memperbarui rekening.'];
        }
        return ['success' => true, 'message' => 'Rekening berhasil diperbarui.'];
    }

    public function delete(int $id)
    {
        $this->paymentChannelsModel->delete($id);
        return ['success' => true, 'message' => 'Rekening berhasil dihapus.'];
    }
}
