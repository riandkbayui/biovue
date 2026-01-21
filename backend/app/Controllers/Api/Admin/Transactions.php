<?php

namespace App\Controllers\Api\Admin;

use CodeIgniter\RESTful\ResourceController;
use App\Services\Admin\AdminTransactionsService;
use App\Services\Auth\AuthService;
use Exception;

class Transactions extends ResourceController
{
    protected $service;
    protected $authService;
    protected $format = 'json';

    public function __construct()
    {
        $this->service = new AdminTransactionsService();
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

    public function getShow($id = null)
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();
            $data = $this->service->getOne((int)$id);
            if (!$data) return $this->failNotFound();
            return $this->respond(['data' => $data]);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /**
     * POST /api/admin/transactions/confirm/(:id)
     */
    public function postConfirm($id = null)
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();
            $result = $this->service->confirmPayment((int)$id);
            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    /**
     * POST /api/admin/transactions/reject/(:id)
     */
    public function postReject($id = null)
    {
        try {
            if (!$this->isAdmin()) return $this->failUnauthorized();
            $result = $this->service->rejectPayment((int)$id);
            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}