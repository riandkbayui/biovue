<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Attempt;

class AttemptsModel extends Model
{
    protected $table            = 'attempts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Attempt::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ip_address', 'user_id', 'user_agent', 'success',
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
