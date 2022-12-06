<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Entities\UploadSession;
use Modules\Media\Interfaces\HasMedia;
use Modules\Media\MediaCollections\Models\Media;
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

    public function registerMediaCollections(): void
    {
        $this
        ->addMediaCollection('default')
        ->useFallbackUrl(rtrim(config('app.url', 'http://localhost'), '/').'/images/default-theme.png');
    }

    public function getImageUrlAttribute()
    {
        $media = $this->getMediaRepository()->getByUuids([$this->featured_image])->first();
        if($media) {
            return $media->getFullUrl();
        }   
        return null;
    }

    public function getShortDescriptionAttribute()
    {
        if(!$this->content) {
            return '';
        }

        return substr(strip_tags($this->content), 0, 99).'...';
    }
}
