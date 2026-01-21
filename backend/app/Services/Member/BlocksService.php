<?php

namespace App\Services\Member;

use App\Models\BlocksModel;
use App\Models\PagesModel;
use App\Entities\Block;
use App\Libraries\Auth;

class BlocksService
{
    protected $blocksModel;
    protected $pagesModel;

    public function __construct()
    {
        $this->blocksModel = new BlocksModel();
        $this->pagesModel  = new PagesModel();
    }

    /**
     * Memastikan halaman tersebut milik user
     */
    private function verifyOwnership(int $pageId)
    {
        return $this->pagesModel->where(['id' => $pageId, 'user_id' => Auth::id()])->first();
    }

    /**
     * Ambil semua blok di sebuah halaman
     */
    public function getBlocksByPage(int $pageId)
    {
        if (!$this->verifyOwnership($pageId)) {
            return [];
        }

        return $this->blocksModel
            ->where('page_id', $pageId)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    /**
     * Tambah blok baru
     */
    public function addBlock(int $pageId, array $data)
    {
        if (!$this->verifyOwnership($pageId)) {
            return ['success' => false, 'message' => 'Halaman tidak ditemukan.'];
        }

        // Cari sort_order terakhir
        $lastBlock = $this->blocksModel->where('page_id', $pageId)->orderBy('sort_order', 'DESC')->first();
        $nextOrder = $lastBlock ? $lastBlock->sort_order + 1 : 0;

        $block = new Block();
        $block->page_id    = $pageId;
        $block->type       = $data['type'];
        $block->data       = !is_string($data['content']) ? json_encode($data['content']) : $data['content'];
        $block->sort_order = $nextOrder;
        $block->status     = 'active';
        $block->created_by = Auth::id();

        if (!$this->blocksModel->save($block)) {
            return ['success' => false, 'message' => 'Gagal menambah blok.', 'errors' => $this->blocksModel->errors()];
        }

        return ['success' => true, 'message' => 'Blok berhasil ditambahkan.', 'data' => $block];
    }

    /**
     * Update konten blok
     */
    public function updateBlock(int $blockId, array $data)
    {
        $block = $this->blocksModel->find($blockId);
        if (!$block) return ['success' => false, 'message' => 'Blok tidak ditemukan.'];

        // Verifikasi kepemilikan melalui halaman
        if (!$this->verifyOwnership($block->page_id)) {
            return ['success' => false, 'message' => 'Akses ditolak.'];
        }

        if (isset($data['content'])) {
            $block->data = !is_string($data['content']) ? json_encode($data['content']) : $data['content'];
        }
        
        if (isset($data['status'])) {
            $block->status = $data['status'];
        }

        $block->updated_by = Auth::id();

        if (!$this->blocksModel->save($block)) {
            return ['success' => false, 'message' => 'Gagal memperbarui blok.'];
        }

        return ['success' => true, 'message' => 'Blok berhasil diperbarui.', 'data' => $block];
    }

    /**
     * Hapus blok
     */
    public function deleteBlock(int $blockId)
    {
        $block = $this->blocksModel->find($blockId);
        if (!$block) return ['success' => false, 'message' => 'Blok tidak ditemukan.'];

        if (!$this->verifyOwnership($block->page_id)) {
            return ['success' => false, 'message' => 'Akses ditolak.'];
        }

        $this->blocksModel->delete($blockId);
        return ['success' => true, 'message' => 'Blok berhasil dihapus.'];
    }

    /**
     * Urutkan ulang blok
     */
    public function reorderBlocks(int $pageId, array $blockIds)
    {
        if (!$this->verifyOwnership($pageId)) {
            return ['success' => false, 'message' => 'Akses ditolak.'];
        }

        foreach ($blockIds as $index => $id) {
            $this->blocksModel->update($id, ['sort_order' => $index]);
        }

        return ['success' => true, 'message' => 'Urutan berhasil disimpan.'];
    }
}
