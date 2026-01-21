<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property int $user_id
 * @property int $plan_id
 * @property int|null $transaction_id
 * @property string $started_at
 * @property string|null $expired_at
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \CodeIgniter\I18n\Time $created_at
 * @property \CodeIgniter\I18n\Time $updated_at
 * @property \CodeIgniter\I18n\Time $deleted_at
 */
class Subscription extends Entity
{
    protected $attributes = [
        'id'             => null,
        'user_id'        => null,
        'plan_id'        => null,
        'transaction_id' => null,
        'started_at'     => null,
        'expired_at'     => null,
        'status'         => 'active',
        'created_by'     => null,
        'updated_by'     => null,
        'deleted_by'     => null,
        'created_at'     => null,
        'updated_at'     => null,
        'deleted_at'     => null,
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Get the subscriber.
     * @return \App\Entities\User|null
     */
    public function user()
    {
        $model = model('App\Models\UsersModel');
        return $model->find($this->user_id);
    }

    /**
     * Get the subscribed plan.
     * @return \App\Entities\Plan|null
     */
    public function plan()
    {
        $model = model('App\Models\PlansModel');
        return $model->find($this->plan_id);
    }

    /**
     * Get the associated transaction.
     * @return \App\Entities\Transaction|null
     */
    public function transaction()
    {
        if (!$this->transaction_id) return null;
        $model = model('App\Models\TransactionsModel');
        return $model->find($this->transaction_id);
    }
}
