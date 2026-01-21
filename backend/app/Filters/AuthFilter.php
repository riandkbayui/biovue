<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\Auth\AuthService;
use App\Libraries\Auth; // Tambahkan ini
use CodeIgniter\API\ResponseTrait;

class AuthFilter implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null)
    {
        // Biarkan request OPTIONS lewat (CORS Preflight)
        if ($request->getMethod() === 'options') {
            return;
        }

        $authService = new AuthService();
        $authHeader = $request->getHeaderLine('Authorization');
        $user = null;

        // 1. Cek via Bearer Token (API)
        if ($authHeader) {
            $token = str_replace('Bearer ', '', $authHeader);
            $user = $authService->getUserByToken($token);
        }

        // 2. Jika tidak ada token atau token tidak valid, cek via Session (Web/Built SPA)
        if (!$user) {
            $userId = session()->get('user_id');
            if ($userId) {
                $user = $authService->getUserById($userId);
            }
        }

        if (!$user) {
            return service('response')->setJSON(['message' => 'Sesi berakhir atau token tidak valid'])->setStatusCode(401);
        }

        // Simpan data user ke request dan ke static class Auth
        $request->user = $user;
        Auth::set($user);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan
    }
}
