<?php
namespace Modules\Blog\Tables;

use Modules\Core\Supports\TableBuilder;
use Modules\Blog\Entities\Category;
use Omaicode\TableBuilder\Column;

class CategoryTable extends TableBuilder
{
    /**
     * Model namespace
     * @var string
     */    
    protected $model = Category::class;

    /**
     * Set table header title
     * @var string
     */
    protected string $header_title = 'blog::messages.categories';
    
    /**
     * Show actions
     * @var bool
     */    
    protected bool $show_actions = true;

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        // Set create URL 
        $this->create_url = route('admin.blog.categories.create');

        // Set delete URL (method => POST)
        $this->delete_url = route('admin.blog.categories.destroy');

        // Set edit URL. See documentation for more details
        $this->edit_url = route('admin.blog.categories.edit', ['category' => ':id']);

        // Apply custom query
        $this->applyQuery(function($query, $request) {
            if($request->filled('search')) {
                $query->where('name', 'LIKE', '%'.$request->search.'%')
                ->orWhere('slug', 'LIKE',  '%'.$request->search.'%');
            }
        });        
    }

    /**
     * Add columns to table
     *
     * @return Column[] 
     * @throws BindingResolutionException 
     * @throws NotFoundExceptionInterface 
     * @throws ContainerExceptionInterface 
     */
    protected function columns()
    {
        return [
            new Column("id", __('ID')),
            new Column("name", __('Name'), fn($x) => $x->getTranslation('name', request()->getLocale())),
            new Column("slug", __('Slug')),
            new Column("active", __('Status'), fn($x) => $x->active ? __('blog::messages.active') : __('blog::messages.inactive')),
            new Column("created_at", __('Created at'), fn($item) => $item->created_at->format('Y-m-d H:i:s')),
            new Column("updated_at", __('Updated at'), fn($item) => $item->updated_at->format('Y-m-d H:i:s')),
        ];
    }  
}