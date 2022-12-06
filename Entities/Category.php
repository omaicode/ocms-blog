<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Omaicode\Repository\Contracts\Transformable;
use Omaicode\Repository\Traits\TransformableTrait;
use Spatie\Translatable\HasTranslations;

/**
 * Class Category.
 *
 * @package namespace Modules\Blog\Entities;
 */
class Category extends Model implements Transformable
{
    use TransformableTrait, HasTranslations;

    protected $table = 'blog_categories';
    
    public $translatable = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'active',
        'parent_id'
    ];

    protected $casts = [
        'active'     => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
