<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $message
 * @property int $is_read
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \CodeIgniter\I18n\Time $created_at
 * @property \CodeIgniter\I18n\Time $updated_at
 * @property \CodeIgniter\I18n\Time $deleted_at
 */
class Notification extends Entity
{
    protected $attributes = [
        'id'         => null,
        'user_id'    => null,
        'title'      => null,
        'message'    => null,
        'is_read'    => 0,
        'status'     => 'active',
        'created_by' => null,
        'updated_by' => null,
        'deleted_by' => null,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null,
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Get the user who received the notification.
     * @return \App\Entities\User|null
     */
    public function user()
    {
        $model = model('App\Models\UsersModel');
        return $model->find($this->user_id);
    }
}
