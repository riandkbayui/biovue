<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $token
 * @property string|null $value
 * @property string|null $expired_at
 * @property \CodeIgniter\I18n\Time $created_at
 * @property \CodeIgniter\I18n\Time $updated_at
 */
class Token extends Entity
{
    protected $attributes = [
        'id'         => null,
        'user_id'    => null,
        'type'       => null,
        'token'      => null,
        'value'      => null,
        'expired_at' => null,
        'created_at' => null,
        'updated_at' => null,
    ];
    protected $dates = ['created_at', 'updated_at', 'expired_at'];
    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * Get the user associated with the token.
     * @return \App\Entities\User|null
     */
    public function user()
    {
        $model = model('App\Models\UsersModel');
        return $model->find($this->user_id);
    }
}
