<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Subscription;

class SubscriptionsModel extends Model
{
    protected $table            = 'subscriptions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Subscription::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 
        'plan_id', 
        'transaction_id', 
        'started_at', 
        'expired_at', 
        'status',
        'created_by', 
        'updated_by', 
        'deleted_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
