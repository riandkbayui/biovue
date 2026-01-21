<?php

namespace App\Services\Admin;

use App\Models\BanksModel;
use App\Libraries\Auth;

class AdminBanksService
{
    protected $banksModel;

    public function __construct()
    {
        $this->banksModel = new BanksModel();
    }

    public function getAll()
    {
        return $this->banksModel->findAll();
    }

    public function getOne(int $id)
    {
        return $this->banksModel->find($id);
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        if (!$this->banksModel->save($data)) {
            return ['success' => false, 'message' => 'Gagal menambah bank.', 'errors' => $this->banksModel->errors()];
        }
        return ['success' => true, 'message' => 'Bank berhasil ditambahkan.'];
    }

    public function update(int $id, array $data)
    {
        $data['updated_by'] = Auth::id();
        if (!$this->banksModel->update($id, $data)) {
            return ['success' => false, 'message' => 'Gagal memperbarui bank.'];
        }
        return ['success' => true, 'message' => 'Bank berhasil diperbarui.'];
    }

    public function delete(int $id)
    {
        $this->banksModel->delete($id);
        return ['success' => true, 'message' => 'Bank berhasil dihapus.'];
    }
}
