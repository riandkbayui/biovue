<?php

namespace App\Services\Admin;

use App\Models\UsersModel;
use App\Models\PagesModel;
use App\Models\TransactionsModel;
use App\Models\SubscriptionsModel;

class DashboardService
{
    protected $usersModel;
    protected $pagesModel;
    protected $transactionsModel;
    protected $subscriptionsModel;

    public function __construct()
    {
        $this->usersModel         = new UsersModel();
        $this->pagesModel         = new PagesModel();
        $this->transactionsModel  = new TransactionsModel();
        $this->subscriptionsModel = new SubscriptionsModel();
    }

    /**
     * Ambil ringkasan statistik untuk dashboard admin
     */
    public function getStatsSummary()
    {
        return [
            'total_users'        => $this->usersModel->countAllResults(),
            'total_pages'        => $this->pagesModel->countAllResults(),
            'total_transactions' => $this->transactionsModel->countAllResults(),
            'total_revenue'      => $this->transactionsModel->where('status', 'paid')->selectSum('amount')->first()->amount ?? 0,
            'recent_users'       => $this->usersModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'recent_transactions' => $this->transactionsModel
                                        ->select('transactions.*, users.name as user_name')
                                        ->join('users', 'users.id = transactions.user_id')
                                        ->orderBy('transactions.created_at', 'DESC')
                                        ->limit(5)
                                        ->findAll(),
        ];
    }
}
