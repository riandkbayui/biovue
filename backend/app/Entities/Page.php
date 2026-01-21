<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $seo_image
 * @property string $theme
 * @property string $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \CodeIgniter\I18n\Time $created_at
 * @property \CodeIgniter\I18n\Time $updated_at
 * @property \CodeIgniter\I18n\Time $deleted_at
 */
class Page extends Entity
{
    protected $attributes = [
        'id'          => null,
        'user_id'     => null,
        'title'       => null,
        'slug'        => null,
        'description' => null,
        'seo_image'   => null,
        'theme'       => 'default',
        'status'      => 'active',
        'created_by'  => null,
        'updated_by'  => null,
        'deleted_by'  => null,
        'created_at'  => null,
        'updated_at'  => null,
        'deleted_at'  => null,
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'theme' => 'json'
    ];

    /**
     * Get blocks associated with this page.
     * @return \App\Entities\Block[]
     */
    public function blocks()
    {
        $model = model('App\Models\BlocksModel');
        return $model->where('page_id', $this->id)->orderBy('sort_order', 'ASC')->findAll();
    }

    /**
     * Get the owner of the page.
     * @return \App\Entities\User|null
     */
    public function user()
    {
        $model = model('App\Models\UsersModel');
        return $model->find($this->user_id);
    }
}
