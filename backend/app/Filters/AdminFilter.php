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
            $response = service('response')->setJSON(['message' => 'Akses ditolak. Hanya untuk administrator.'])->setStatusCode(403);

            // Tambahkan header CORS manual
            $origin = $request->getHeaderLine('Origin');
            $allowedOrigins = ['http://localhost:5173', 'http://127.0.0.1:5173'];

            if (in_array($origin, $allowedOrigins)) {
                $response->setHeader('Access-Control-Allow-Origin', $origin);
                $response->setHeader('Access-Control-Allow-Credentials', 'true');
            }

            return $response;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan
    }
}
