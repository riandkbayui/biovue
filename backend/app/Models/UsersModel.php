<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = User::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'email', 'username', 'password', 'role', 'photo', 'status', 'email_verified_at',
        'created_by', 'updated_by', 'deleted_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
