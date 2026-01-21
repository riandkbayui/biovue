<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Services\PublicService;
use Exception;

class PublicPage extends ResourceController
{
    protected $publicService;
    protected $format = 'json';

    public function __construct()
    {
        $this->publicService = new PublicService();
    }

    /**
     * GET /api/public-page/show/(:slug)
     */
    public function getShow($slug = null)
    {
        try {
            if (!$slug) return $this->failNotFound();

            $data = $this->publicService->getPageBySlug($slug);

            if (!$data) {
                return $this->failNotFound('Halaman tidak ditemukan atau sudah dinonaktifkan.');
            }

            return $this->respond($data);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
