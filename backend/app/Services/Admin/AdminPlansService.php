<?php

namespace App\Services\Admin;

use App\Models\PlansModel;
use App\Libraries\Auth;

class AdminPlansService
{
    protected $plansModel;

    public function __construct()
    {
        $this->plansModel = new PlansModel();
    }

    public function getAll()
    {
        return $this->plansModel->findAll();
    }

    public function getOne(int $id)
    {
        return $this->plansModel->find($id);
    }

    public function create(array $data)
    {
        // Encode features array to JSON string if needed
        if (isset($data['features']) && is_array($data['features'])) {
            $data['features'] = json_encode($data['features']);
        }

        $data['created_by'] = Auth::id();

        if (!$this->plansModel->save($data)) {
            return ['success' => false, 'message' => 'Gagal membuat paket.', 'errors' => $this->plansModel->errors()];
        }
        return ['success' => true, 'message' => 'Paket berhasil dibuat.'];
    }

    public function update(int $id, array $data)
    {
        // Encode features array to JSON string if needed
        if (isset($data['features']) && is_array($data['features'])) {
            $data['features'] = json_encode($data['features']);
        }

        if (!$this->plansModel->update($id, $data)) {
            return ['success' => false, 'message' => 'Gagal memperbarui paket.'];
        }
        return ['success' => true, 'message' => 'Paket berhasil diperbarui.'];
    }

    public function delete(int $id)
    {
        $this->plansModel->delete($id);
        return ['success' => true, 'message' => 'Paket berhasil dihapus.'];
    }
}
