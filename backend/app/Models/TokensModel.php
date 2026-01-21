<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Token;

class TokensModel extends Model
{
    protected $table            = 'tokens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Token::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 'type', 'token', 'value', 'expired_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
