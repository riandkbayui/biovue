<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Services\Common\UploadService;
use App\Services\Auth\AuthService;
use Exception;

class Upload extends ResourceController
{
    protected $uploadService;
    protected $format = 'json';

    public function __construct()
    {
        $this->uploadService = new UploadService();
    }

    /**
     * POST /api/upload/create
     */
    public function postCreate()
    {
        try {
            $file = $this->request->getFile('file');
            $folder = $this->request->getVar('folder') ?? 'others';

            if (!$file) {
                return $this->fail('File tidak ditemukan.');
            }

            // Sanitasi nama folder untuk keamanan
            $folder = preg_replace('/[^a-zA-Z0-9_-]/', '', $folder);
            if (empty($folder)) $folder = 'others';

            $result = $this->uploadService->uploadImage($file, $folder);

            if ($result['success']) {
                return $this->respondCreated($result);
            }

            return $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}