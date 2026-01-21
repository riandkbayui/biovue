<?php

namespace App\Controllers\Api\Member;

use CodeIgniter\RESTful\ResourceController;
use App\Services\Member\PaymentService;
use App\Services\Auth\AuthService;
use Exception;

class Payments extends ResourceController
{
    protected $paymentService;
    protected $authService;
    protected $format = 'json';

    public function __construct()
    {
        $this->paymentService = new PaymentService();
        $this->authService    = new AuthService();
    }

    private function getUserId()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        if (!$authHeader) return null;
        $token = str_replace('Bearer ', '', $authHeader);
        $user = $this->authService->getUserByToken($token);
        return $user ? $user->id : null;
    }

    public function getPlans()
    {
        try {
            return $this->respond(['data' => $this->paymentService->getActivePlans()]);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getChannels()
    {
        try {
            return $this->respond(['data' => $this->paymentService->getPaymentChannels()]);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getHistory()
    {
        try {
            return $this->respond(['data' => $this->paymentService->getUserTransactions()]);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function postCheckout()
    {
        try {
            $planId = $this->request->getVar('plan_id');
            if (!$planId) return $this->fail('Pilih paket terlebih dahulu.');

            $result = $this->paymentService->createTransaction((int)$planId);
            return $result['success'] ? $this->respondCreated($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function getShow($id = null)
    {
        try {
            $data = $this->paymentService->getTransactionDetail((int)$id);
            if (!$data) return $this->failNotFound();
            return $this->respond(['data' => $data]);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    public function postUploadProof($id = null)
    {
        try {
            $imageUrl = $this->request->getVar('image_url');
            if (!$imageUrl) return $this->fail('URL gambar bukti bayar wajib ada.');

            $result = $this->paymentService->uploadProof((int)$id, $imageUrl);
            return $result['success'] ? $this->respond($result) : $this->fail($result['message']);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}