<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property int $page_id
 * @property string $type
 * @property string $data
 * @property int $sort_order
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \CodeIgniter\I18n\Time $created_at
 * @property \CodeIgniter\I18n\Time $updated_at
 * @property \CodeIgniter\I18n\Time $deleted_at
 */
class Block extends Entity
{
    protected $attributes = [
        'id'         => null,
        'page_id'    => null,
        'type'       => null,
        'data'       => null,
        'sort_order' => 0,
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
     * Get the page this block belongs to.
     * @return \App\Entities\Page|null
     */
    public function page()
    {
        $model = model('App\Models\PagesModel');
        return $model->find($this->page_id);
    }
}
