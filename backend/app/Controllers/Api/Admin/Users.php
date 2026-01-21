<?php

namespace App\Controllers\Api\Admin;

use CodeIgniter\RESTful\ResourceController;
use App\Services\Admin\AdminUsersService;
use App\Services\Auth\AuthService;
use Exception;

class Users extends ResourceController
{
    protected $adminUsersService;
    protected $authService;
    protected $format = 'json';

    public function __construct()
    {
        $this->adminUsersService = new AdminUsersService();
        $this->authService       = new AuthService();
    }

    private function isAdmin()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        if (!$authHeader) return false;
        $token = str_replace('Bearer ', '', $authHeader);
        $user = $this->authService->getUserByToken($token);
        return $user && $user->role === 'admin';
    }

    public function getIndex()
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();
            $data = $this->adminUsersService->getAllUsers();
            return $this->respond(['data' => $data]);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getShow($id = null)
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();
            $data = $this->adminUsersService->getUser((int)$id);
            if (!$data) return $this->failNotFound('User tidak ditemukan');
            return $this->respond(['data' => $data]);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function postCreate()
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();

            $rules = [
                'name'     => 'required|min_length[3]',
                'email'    => 'required|valid_email',
                'username' => 'required|min_length[3]',
                'password' => 'required|min_length[6]',
                'role'     => 'required|in_list[admin,member]',
                'status'   => 'required|in_list[active,inactive]'
            ];

            if (!$this->validate($rules)) return $this->failValidationErrors($this->validator->getErrors());

            $input = [
                'name'     => $this->request->getVar('name'),
                'email'    => $this->request->getVar('email'),
                'username' => $this->request->getVar('username'),
                'password' => $this->request->getVar('password'),
                'role'     => $this->request->getVar('role'),
                'status'   => $this->request->getVar('status'),
            ];

            $result = $this->adminUsersService->createUser($input);
            return $result['success'] ? $this->respondCreated($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function putUpdate($id = null)
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();

            $rules = [
                'name'     => 'required|min_length[3]',
                'email'    => 'required|valid_email',
                'username' => 'required|min_length[3]',
                'role'     => 'required|in_list[admin,member]',
                'status'   => 'required|in_list[active,inactive]'
            ];

            if (!$this->validate($rules)) return $this->failValidationErrors($this->validator->getErrors());

            $input = (array) $this->request->getVar();
            $result = $this->adminUsersService->updateUser((int)$id, $input);
            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function postUpdate($id = null)
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();

            $rules = [
                'name'     => 'required|min_length[3]',
                'email'    => 'required|valid_email',
                'username' => 'required|min_length[3]',
                'role'     => 'required|in_list[admin,member]',
                'status'   => 'required|in_list[active,inactive]'
            ];

            if (!$this->validate($rules)) return $this->failValidationErrors($this->validator->getErrors());

            $input = $this->request->getPost();
            $photo = $this->request->getFile('photo');
            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $input['photo'] = $photo;
            }

            $result = $this->adminUsersService->updateUser((int)$id, $input);
            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function deleteDelete($id = null)
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();
            $result = $this->adminUsersService->deleteUser((int)$id);
            return $result['success'] ? $this->respondDeleted($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}