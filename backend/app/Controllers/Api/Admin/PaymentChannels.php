<?php

namespace App\Controllers\Api\Admin;

use CodeIgniter\RESTful\ResourceController;
use App\Services\Admin\AdminPaymentChannelsService;
use App\Services\Auth\AuthService;
use Exception;

class PaymentChannels extends ResourceController
{
    protected $service;
    protected $authService;
    protected $format = 'json';

    public function __construct()
    {
        $this->service = new AdminPaymentChannelsService();
        $this->authService = new AuthService();
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
            return $this->respond(['data' => $this->service->getAll()]);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function postCreate()
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();
            $rules = [
                'bank_id' => 'required|numeric',
                'account_name' => 'required',
                'account_number' => 'required'
            ];
            if (!$this->validate($rules)) return $this->failValidationErrors($this->validator->getErrors());
            
            $result = $this->service->create($this->request->getPost());
            return $result['success'] ? $this->respondCreated($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function putUpdate($id = null)
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();
            $result = $this->service->update((int)$id, (array) $this->request->getVar());
            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function deleteDelete($id = null)
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();
            $result = $this->service->delete((int)$id);
            return $this->respondDeleted($result);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}