<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $role
 * @property string|null $photo
 * @property string $status
 * @property string|null $email_verified_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \CodeIgniter\I18n\Time $created_at
 * @property \CodeIgniter\I18n\Time $updated_at
 * @property \CodeIgniter\I18n\Time $deleted_at
 */
class User extends Entity
{
    protected $attributes = [
        'id'                => null,
        'name'              => null,
        'email'             => null,
        'username'          => null,
        'password'          => null,
        'role'              => 'member',
        'photo'             => null,
        'status'            => 'active',
        'email_verified_at' => null,
        'created_by'        => null,
        'updated_by'        => null,
        'deleted_by'        => null,
        'created_at'        => null,
        'updated_at'        => null,
        'deleted_at'        => null,
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'email_verified_at'];

    /**
     * Get all pages owned by the user.
     * @return \App\Entities\Page[]
     */
    public function pages()
    {
        $model = model('App\Models\PagesModel');
        return $model->where('user_id', $this->id)->findAll();
    }

    /**
     * Get all subscriptions for the user.
     * @return \App\Entities\Subscription[]
     */
    public function subscriptions()
    {
        $model = model('App\Models\SubscriptionsModel');
        return $model->where('user_id', $this->id)->findAll();
    }

    /**
     * Get all transactions made by the user.
     * @return \App\Entities\Transaction[]
     */
    public function transactions()
    {
        $model = model('App\Models\TransactionsModel');
        return $model->where('user_id', $this->id)->findAll();
    }

    /**
     * Get user notifications.
     * @return \App\Entities\Notification[]
     */
    public function notifications()
    {
        $model = model('App\Models\NotificationsModel');
        return $model->where('user_id', $this->id)->orderBy('created_at', 'DESC')->findAll();
    }
}
