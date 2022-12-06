<?php

namespace Modules\Blog\Repositories;

use Omaicode\Repository\Eloquent\BaseRepository;
use Omaicode\Repository\Criteria\RequestCriteria;
use Modules\Blog\Repositories\CategoryRepository;
use Modules\Blog\Entities\Category;
use Modules\Blog\Validators\CategoryValidator;

/**
 * Class CategoryRepositoryEloquent.
 *
 * @package namespace Modules\Blog\Repositories;
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
