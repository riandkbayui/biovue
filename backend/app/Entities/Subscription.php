<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Subscription extends Entity
{
    protected $dates = ['started_at', 'expired_at', 'created_at', 'updated_at', 'deleted_at'];
}
