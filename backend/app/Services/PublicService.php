<?php

namespace App\Services;

use App\Models\PagesModel;
use App\Models\BlocksModel;

class PublicService
{
    protected $pagesModel;
    protected $blocksModel;

    public function __construct()
    {
        $this->pagesModel  = new PagesModel();
        $this->blocksModel = new BlocksModel();
    }

    /**
     * Ambil data halaman dan blok berdasarkan slug
     */
    public function getPageBySlug(string $slug)
    {
        $page = $this->pagesModel
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();

        if (!$page) {
            return null;
        }

        $blocks = $this->blocksModel
            ->where('page_id', $page->id)
            ->where('status', 'active')
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return [
            'page'   => $page,
            'blocks' => $blocks
        ];
    }
}
