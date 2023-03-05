<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Interfaces\HasMedia;
use Modules\Media\Traits\InteractsWithMedia;
use Omaicode\Repository\Contracts\Transformable;
use Omaicode\Repository\Traits\TransformableTrait;

/**
 * Class Post.
 *
 * @package namespace Modules\Blog\Entities;
 */
class Post extends Model implements Transformable, HasMedia
{
    use TransformableTrait, InteractsWithMedia;
    protected $table = 'blog_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'title',
        'content',
        'seo_title',
        'seo_description',
        'publish',
        'created_by',
        'category_id',
        'featured_image'
    ];

    protected $casts = [
        'publish' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $appends = [
        'image_url',
        'short_description'
    ];

    public function registerMediaSavePath(): void
    {
        $this
        ->setMediaSavePath('post')
        ->useFallbackUrl(rtrim(config('app.url', 'http://localhost'), '/').'/images/default-theme.png');
    }

    public function getImageUrlAttribute()
    {
        return $this->getMediaUrl('featured_image');
    }

    public function getShortDescriptionAttribute()
    {
        if(!$this->content) {
            return '';
        }

        return substr(strip_tags($this->content), 0, 99).'...';
    }

    public function category()
    {
      return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
