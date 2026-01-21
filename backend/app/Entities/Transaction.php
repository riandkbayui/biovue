<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property int $user_id
 * @property int $plan_id
 * @property int $amount
 * @property int $unique_code
 * @property string|null $payment_proof
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \CodeIgniter\I18n\Time $created_at
 * @property \CodeIgniter\I18n\Time $updated_at
 * @property \CodeIgniter\I18n\Time $deleted_at
 */
class Transaction extends Entity
{
    protected $attributes = [
        'id'            => null,
        'user_id'       => null,
        'plan_id'       => null,
        'amount'        => 0,
        'unique_code'   => 0,
        'payment_proof' => null,
        'status'        => 'active',
        'created_by'    => null,
        'updated_by'    => null,
        'deleted_by'    => null,
        'created_at'    => null,
        'updated_at'    => null,
        'deleted_at'    => null,
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Get the user who made the transaction.
     * @return \App\Entities\User|null
     */
    public function user()
    {
        $model = model('App\Models\UsersModel');
        return $model->find($this->user_id);
    }

    /**
     * Get the plan purchased.
     * @return \App\Entities\Plan|null
     */
    public function plan()
    {
        $model = model('App\Models\PlansModel');
        return $model->find($this->plan_id);
    }
}
