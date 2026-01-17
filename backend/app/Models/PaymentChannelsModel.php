<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\PaymentChannel;

class PaymentChannelsModel extends Model
{
    protected $table            = 'payment_channels';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = PaymentChannel::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'bank_id', 'account_name', 'account_number', 'status',
        'created_by', 'updated_by', 'deleted_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
