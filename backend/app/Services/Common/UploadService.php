<?php

namespace App\Services\Common;

use CodeIgniter\Files\File;

class UploadService
{
    protected $uploadPath = FCPATH . 'uploads/';
    protected $allowedMimes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp'];
    protected $maxSize = 2048; // 2MB

    public function __construct()
    {
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
    }

    /**
     * Upload Image
     * @param \CodeIgniter\HTTP\Files\UploadedFile $file
     * @param string $folder Subfolder in uploads (e.g., 'avatars', 'pages')
     */
    public function uploadImage($file, string $folder = 'others')
    {
        if (!$file->isValid()) {
            return [
                'success' => false,
                'message' => $file->getErrorString() . '(' . $file->getError() . ')'
            ];
        }

        if (!in_array($file->getMimeType(), $this->allowedMimes)) {
             return [
                'success' => false,
                'message' => 'Tipe file tidak diizinkan. Gunakan PNG, JPG, atau WEBP.'
            ];
        }

        if ($file->getSizeByUnit('kb') > $this->maxSize) {
             return [
                'success' => false,
                'message' => 'Ukuran file terlalu besar. Maksimal 2MB.'
            ];
        }

        // Generate nama unik
        $newName = $file->getRandomName();
        $targetDir = $this->uploadPath . $folder;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if ($file->move($targetDir, $newName)) {
            // Return URL publik
            // Asumsi base_url sudah dikonfigurasi di App.php atau .env, jika tidak pakai relatif root
            $url = base_url('uploads/' . $folder . '/' . $newName);
            
            return [
                'success' => true,
                'message' => 'Upload berhasil.',
                'data'    => [
                    'file_name' => $newName,
                    'url'       => $url
                ]
            ];
        }

        return [
            'success' => false,
            'message' => 'Gagal memindahkan file.'
        ];
    }
}
