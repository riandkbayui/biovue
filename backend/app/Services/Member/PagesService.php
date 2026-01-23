<?php

namespace App\Services\Member;

use App\Models\PlansModel;
use App\Models\PagesModel;
use App\Models\BlocksModel;
use App\Entities\Page;
use App\Libraries\Auth;

class PagesService
{
    protected $pagesModel;
    protected $blocksModel;

    public function __construct()
    {
        $this->pagesModel = new PagesModel();
        $this->blocksModel = new BlocksModel();
    }

    /**
     * Ambil halaman dengan pagination
     */
    public function getPaginated(int $perPage = 10)
    {
        return [
            'data' => $this->pagesModel
                ->where('user_id', Auth::id())
                ->where('deleted_at', null)
                ->orderBy('created_at', 'DESC')
                ->paginate($perPage),
            'pager' => $this->pagesModel->pager->getDetails()
        ];
    }

    /**
     * Ambil satu halaman detail (pastikan milik user)
     */
    public function getOne(int $pageId)
    {
        return $this->pagesModel
            ->where('user_id', Auth::id())
            ->where('id', $pageId)
            ->first();
    }

    /**
     * Buat halaman baru
     */
    public function create(array $data)
    {
        // Generate slug unik jika belum ada atau konflik
        $slug = url_title($data['title'], '-', true);
        
        // Cek duplikasi slug
        if ($this->pagesModel->where('slug', $slug)->first()) {
            $slug .= '-' . time();
        }

        $page = new Page();
        $page->user_id     = Auth::id();
        $page->title       = $data['title'];
        $page->slug        = $slug;
        $page->description = $data['description'] ?? null;
        $page->status      = 'active'; // Default active
        $page->theme       = 'default';
        $page->created_by  = Auth::id();

        if (!$this->pagesModel->save($page)) {
            return [
                'success' => false,
                'message' => 'Gagal membuat halaman.',
                'errors'  => $this->pagesModel->errors()
            ];
        }

        return [
            'success' => true,
            'message' => 'Halaman berhasil dibuat.',
            'data'    => $page
        ];
    }

    /**
     * Update halaman
     */
    public function update(int $pageId, array $data)
    {
        $page = $this->getOne($pageId);

        if (!$page) {
            return [
                'success' => false,
                'message' => 'Halaman tidak ditemukan atau bukan milik Anda.'
            ];
        }

        $page->title       = $data['title'];
        $page->description = $data['description'] ?? $page->description;
        $page->updated_by  = Auth::id();

        // Handle Slug Update & Uniqueness
        if (isset($data['slug']) && $data['slug'] !== $page->slug) {
            $existing = $this->pagesModel->where('slug', $data['slug'])->where('id !=', $pageId)->first();
            if ($existing) {
                return [
                    'success' => false,
                    'message' => 'Slug "' . $data['slug'] . '" sudah digunakan oleh halaman lain.'
                ];
            }
            $page->slug = $data['slug'];
        }
        
        if (!$this->pagesModel->save($page)) {
             return [
                'success' => false,
                'message' => 'Gagal memperbarui halaman.',
                'errors'  => $this->pagesModel->errors()
            ];
        }

        return [
            'success' => true,
            'message' => 'Halaman berhasil diperbarui.',
            'data'    => $page
        ];
    }

    /**
     * Hapus halaman (Soft Delete)
     */
    public function delete(int $pageId)
    {
        $page = $this->getOne($pageId);

        if (!$page) {
            return [
                'success' => false,
                'message' => 'Halaman tidak ditemukan.'
            ];
        }

        $this->pagesModel->delete($pageId);

        return [
            'success' => true,
            'message' => 'Halaman berhasil dihapus.'
        ];
    }

    /**
     * Simpan Bulk (Page + Blocks)
     */
    public function saveAll(int $pageId, array $data)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Update Page Info
        $page = $this->getOne($pageId);
        if (!$page) {
            return ['success' => false, 'message' => 'Halaman tidak ditemukan.'];
        }

        $page->title       = $data['title'] ?? $page->title;
        $page->status      = $data['status'] ?? $page->status;
        $page->description = $data['description'] ?? $page->description;
        $page->seo_image   = $data['seo_image'] ?? $page->seo_image;
        $page->theme       = $data['theme'] ?? $page->theme;
        $page->updated_by  = Auth::id();

        // Handle Slug Update & Uniqueness
        if (isset($data['slug']) && $data['slug'] !== $page->slug) {
            $existing = $this->pagesModel->where('slug', $data['slug'])->where('id !=', $pageId)->first();
            if ($existing) {
                $db->transRollback();
                return [
                    'success' => false,
                    'message' => 'Slug "' . $data['slug'] . '" sudah digunakan oleh halaman lain.'
                ];
            }
            $page->slug = $data['slug'];
        }
        
        if ($page->hasChanged()) {
            $this->pagesModel->save($page);
        }

        // 2. Update Blocks (Sinkronisasi)
        $blocksData = $data['blocks'] ?? [];
        if (is_string($blocksData)) {
            $blocksData = json_decode($blocksData, true);
        }

        if (is_array($blocksData)) {
            $incomingIds = [];
            foreach ($blocksData as $index => $blockData) {
                $blockId = $blockData['id'] ?? null;
                $blockContent = !is_string($blockData['content']) ? json_encode($blockData['content']) : $blockData['content'];
                
                // Cek apakah ID baru (misal: "new_123...") atau ID lama (integer)
                $isNew = !$blockId || (is_string($blockId) && str_contains($blockId, 'new_'));

                if (!$isNew) {
                    // Update Existing
                    $block = $this->blocksModel->find($blockId);
                    if ($block) {
                        $block->sort_order = $index;
                        $block->data       = $blockContent;
                        $block->updated_by = Auth::id();
                        
                        if ($block->hasChanged()) {
                            $this->blocksModel->save($block);
                        }
                        $incomingIds[] = $blockId;
                    }
                } else {
                    // Create New
                    $newBlock = [
                        'page_id'    => $pageId,
                        'type'       => $blockData['type'],
                        'data'       => $blockContent,
                        'sort_order' => $index,
                        'status'     => 'active',
                        'created_by' => Auth::id()
                    ];
                    $this->blocksModel->insert($newBlock);
                    $incomingIds[] = $this->blocksModel->getInsertID();
                }
            }

            // 3. Delete blocks yang tidak ada di list incoming
            $deleteQuery = $this->blocksModel->where('page_id', $pageId);
            if (!empty($incomingIds)) {
                $deleteQuery->whereNotIn('id', $incomingIds);
            }
            $deleteQuery->delete();
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return [
                'success' => false,
                'message' => 'Gagal menyimpan perubahan.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Semua perubahan berhasil disimpan.',
            'data'    => $page
        ];
    }
}
