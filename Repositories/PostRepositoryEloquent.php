<?php

namespace Modules\Blog\Repositories;

use Omaicode\Repository\Eloquent\BaseRepository;
use Omaicode\Repository\Criteria\RequestCriteria;
use Modules\Blog\Repositories\PostRepository;
use Modules\Blog\Entities\Post;
use Modules\Blog\Validators\PostValidator;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace Modules\Blog\Repositories;
 */
class PostRepositoryEloquent extends BaseRepository implements PostRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
