<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Bank;

class BanksModel extends Model
{
    protected $table            = 'banks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Bank::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'code', 'status', 'created_by', 'updated_by', 'deleted_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
