<?php

namespace App\Services\Admin;

use App\Models\FaqsModel;
use App\Libraries\Auth;

class AdminFaqsService
{
    protected $faqsModel;

    public function __construct()
    {
        $this->faqsModel = new FaqsModel();
    }

    public function getAll()
    {
        return $this->faqsModel->orderBy('id', 'DESC')->findAll();
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::id();
        if (!$this->faqsModel->save($data)) {
            return ['success' => false, 'message' => 'Gagal menambah FAQ.', 'errors' => $this->faqsModel->errors()];
        }
        return ['success' => true, 'message' => 'FAQ berhasil ditambahkan.'];
    }

    public function update(int $id, array $data)
    {
        $data['updated_by'] = Auth::id();
        if (!$this->faqsModel->update($id, $data)) {
            return ['success' => false, 'message' => 'Gagal memperbarui FAQ.'];
        }
        return ['success' => true, 'message' => 'FAQ berhasil diperbarui.'];
    }

    public function delete(int $id)
    {
        $this->faqsModel->delete($id);
        return ['success' => true, 'message' => 'FAQ berhasil dihapus.'];
    }
}