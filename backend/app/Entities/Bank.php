<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \CodeIgniter\I18n\Time $created_at
 * @property \CodeIgniter\I18n\Time $updated_at
 * @property \CodeIgniter\I18n\Time $deleted_at
 */
class Bank extends Entity
{
    protected $attributes = [
        'id'         => null,
        'name'       => null,
        'code'       => null,
        'status'     => 'active',
        'created_by' => null,
        'updated_by' => null,
        'deleted_by' => null,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null,
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
