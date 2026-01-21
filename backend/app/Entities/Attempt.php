<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property string $ip_address
 * @property int|null $user_id
 * @property string|null $user_agent
 * @property int $success
 * @property \CodeIgniter\I18n\Time $created_at
 * @property \CodeIgniter\I18n\Time $updated_at
 * @property \CodeIgniter\I18n\Time $deleted_at
 */
class Attempt extends Entity
{
    protected $attributes = [
        'id'         => null,
        'ip_address' => null,
        'user_id'    => null,
        'user_agent' => null,
        'success'    => 0,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null,
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'user_id' => 'integer',
        'success' => 'boolean',
    ];

    /**
     * Get the user who attempted the login.
     * @return \App\Entities\User|null
     */
    public function user()
    {
        if (!$this->user_id) return null;
        $model = model('App\Models\UsersModel');
        return $model->find($this->user_id);
    }
}
