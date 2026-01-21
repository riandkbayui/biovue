<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Services\Auth\AuthService;
use Exception;

class Auth extends ResourceController
{
    protected $authService;
    protected $format = 'json';

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function postRegister()
    {
        try {
            $rules = [
                'name'     => 'required|min_length[3]|max_length[100]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'username' => 'required|min_length[3]|is_unique[users.username]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]'
            ];

            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $data = [
                'name'     => $this->request->getVar('name'),
                'email'    => $this->request->getVar('email'),
                'username' => $this->request->getVar('username'),
                'password' => $this->request->getVar('password'),
            ];

            $result = $this->authService->register($data);

            if ($result['success']) {
                return $this->respondCreated($result);
            }

            return $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function postLogin()
    {
        try {
            $rules = [
                'credential' => 'required',
                'password'   => 'required'
            ];

            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $credential = $this->request->getVar('credential');
            $password   = $this->request->getVar('password');
            $ipAddress  = $this->request->getIPAddress();
            $userAgent  = $this->request->getUserAgent()->getAgentString();

            $result = $this->authService->login($credential, $password, $ipAddress, $userAgent);

            if ($result['success']) {
                return $this->respond($result);
            }

            return $this->failUnauthorized($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function postLogout()
    {
        try {
            $authHeader = $this->request->getHeaderLine('Authorization');
            $token = $authHeader ? str_replace('Bearer ', '', $authHeader) : null;
            
            $this->authService->logout($token);

            return $this->respond(['message' => 'Logout berhasil']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getMe()
    {
        try {
            $authHeader = $this->request->getHeaderLine('Authorization');
            if (!$authHeader) {
                return $this->failUnauthorized('Token tidak ditemukan');
            }

            $token = str_replace('Bearer ', '', $authHeader);
            $user = $this->authService->getUserByToken($token);

            if (!$user) {
                return $this->failUnauthorized('Token tidak valid atau kadaluarsa');
            }

            return $this->respond([
                'user' => [
                    'id'       => $user->id,
                    'name'     => $user->name,
                    'email'    => $user->email,
                    'username' => $user->username,
                    'role'     => $user->role,
                    'photo'    => $user->photo,
                ]
            ]);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
