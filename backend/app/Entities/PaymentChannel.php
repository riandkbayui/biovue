<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property int $bank_id
 * @property string $account_name
 * @property string $account_number
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \CodeIgniter\I18n\Time $created_at
 * @property \CodeIgniter\I18n\Time $updated_at
 * @property \CodeIgniter\I18n\Time $deleted_at
 */
class PaymentChannel extends Entity
{
    protected $attributes = [
        'id'             => null,
        'bank_id'        => null,
        'account_name'   => null,
        'account_number' => null,
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
     * Get the bank details.
     * @return \App\Entities\Bank|null
     */
    public function bank()
    {
        $model = model('App\Models\BanksModel');
        return $model->find($this->bank_id);
    }
}
