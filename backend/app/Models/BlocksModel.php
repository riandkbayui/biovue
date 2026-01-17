<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Block;

class BlocksModel extends Model
{
    protected $table            = 'blocks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Block::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'page_id', 'type', 'data', 'sort_order', 'status',
        'created_by', 'updated_by', 'deleted_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
