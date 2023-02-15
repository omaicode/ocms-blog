<?php

namespace Modules\Blog\Http\Controllers\Admin;

use ApiResponse;
use Illuminate\Http\Request;
use Modules\Blog\Entities\Category;
use Modules\Core\Contracts\AdminPage;
use Modules\Core\Http\Controllers\FormBuilderController;
use Modules\Blog\Entities\Post;
use Modules\Blog\Tables\PostTable;
use Modules\Form\Form;
use Modules\Form\Tools;

class PostController extends FormBuilderController
{
    protected $request;
    protected array $breadcrumb = [[
        'title' => 'Blog',
        'url'   => '#'
    ]];  
    protected $title = 'Posts';

    public function __construct(Request $request)
    {
        $this->middleware('can:blog.posts.view', ['index']);
        $this->middleware('can:blog.posts.edit', ['edit', 'update']);
        $this->middleware('can:blog.posts.create', ['create', 'store']);
        $this->middleware('can:blog.posts.delete', ['deletes']);

        $this->request = $request;
        $this->breadcrumb[] = [
            'title'  => __('blog::messages.posts'), 
            'url'    => route('admin.blog.posts.index'),
        ];
    }

    protected function index()
    {        
        return app(AdminPage::class)
        ->title('blog::messages.posts')
        ->breadcrumb($this->breadcrumb)
        ->body(new PostTable);
    }

    protected function form()
    {
        $statuses   = [0 => __('blog::messages.draft'), 1 => __('blog::messages.publish')];
        $categories = Category::where('active', true)->get()->pluck('name', 'id')->toArray();
        $form = new Form(new Post());

        $form->slug('title', 'slug', __('blog::messages.title'))
              ->creationRules('required|unique:blog_posts,slug')
              ->updateRules('required|unique:blog_posts,slug,{{id}},id');
        $form->quillEditor('content', __('blog::messages.content'));
        $form->text('seo_title', __('blog::messages.seo_title'));
        $form->textarea('seo_description', __('blog::messages.seo_description'))->rows(2);

        $form->tools(function(Tools $tool) use ($statuses, $categories) {
            $tool->select('publish', __('blog::messages.status'))->options($statuses)->default(0);
            $tool->select('category_id', __('blog::messages.category'))->options($categories);
            $tool->media('featured_image', __('blog::messages.featured_image'), Post::class)->placeholder(__('blog::messages.select_featured_image'));
        });

        return $form;
    }


    public function deletes()
    {
        $rows = $this->request->rows;
        Post::whereIn('id', $rows)->delete();

        return ApiResponse::success();
    }    
}
