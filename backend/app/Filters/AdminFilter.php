<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Biarkan request OPTIONS lewat (CORS Preflight)
        if ($request->getMethod() === 'options') {
            return;
        }

        // AuthFilter harus dijalankan sebelum ini
        if (!isset($request->user) || $request->user->role !== 'admin') {
            return service('response')->setJSON(['message' => 'Akses ditolak. Hanya untuk administrator.'])->setStatusCode(403);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan
    }
}
