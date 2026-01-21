<?php

namespace App\Controllers\Api\Member;

use CodeIgniter\RESTful\ResourceController;
use App\Services\Member\UsersService;
use App\Services\Auth\AuthService;
use Exception;

class Profile extends ResourceController
{
    protected $usersService;
    protected $authService;
    protected $format = 'json';

    public function __construct()
    {
        $this->usersService = new UsersService();
        $this->authService  = new AuthService();
    }

    private function getUserId()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        if (!$authHeader) return null;
        $token = str_replace('Bearer ', '', $authHeader);
        $user = $this->authService->getUserByToken($token);
        return $user ? $user->id : null;
    }

    public function getIndex()
    {
        try {
            $userId = $this->getUserId();
            $user = $this->authService->getUserById($userId);
            
            if (!$user) return $this->failUnauthorized();

            return $this->respond([
                'data' => [
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

    /**
     * POST /api/member/profile/update
     */
    public function postUpdate()
    {
        try {
            $rules = [
                'name'     => 'required|min_length[3]|max_length[100]',
                'username' => 'required|min_length[3]|max_length[50]',
            ];

            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $data = [
                'name'     => $this->request->getVar('name'),
                'username' => $this->request->getVar('username'),
            ];

            // Handle photo if exists in multipart form data
            $photo = $this->request->getFile('photo');
            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $data['photo_file'] = $photo;
            } else {
                $data['photo'] = $this->request->getVar('photo'); // Fallback to URL string if already uploaded via separate API
            }

            $result = $this->usersService->updateProfile($data);
            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /**
     * POST /api/member/profile/change-password
     */
    public function postChangePassword()
    {
        try {
            $rules = [
                'old_password' => 'required',
                'new_password' => 'required|min_length[6]',
                'confirm_new_password' => 'required|matches[new_password]'
            ];

            if (!$this->validate($rules)) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $result = $this->usersService->changePassword(
                $this->request->getVar('old_password'),
                $this->request->getVar('new_password')
            );

            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}