<?php

namespace App\Controllers\Api\Admin;

use CodeIgniter\RESTful\ResourceController;
use App\Services\Admin\DashboardService;
use Exception;

class Dashboard extends ResourceController
{
    protected $dashboardService;
    protected $format = 'json';

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    /**
     * GET /api/admin/dashboard
     */
    public function getIndex()
    {
        try {
            $data = $this->dashboardService->getStatsSummary();
            return $this->respond($data);
        } catch (Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}