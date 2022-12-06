<?php

namespace Modules\Blog\Http\Controllers\Admin;

use ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Core\Contracts\AdminPage;
use Modules\Core\Http\Controllers\FormBuilderController;
use Modules\Blog\Entities\Category;
use Modules\Blog\Tables\CategoryTable;
use Modules\Form\Form;
use Modules\Form\Tools;

class CategoryController extends FormBuilderController
{
    protected $request;
    protected array $breadcrumb = [[
        'title' => 'Blog',
        'url'   => '#'
    ]];     
    protected $title = 'Categories';

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->breadcrumb[] = [
            'title'  => __('blog::messages.categories'), 
            'url'    => route('admin.blog.categories.index'),
        ];
    }

    protected function index()
    {        
        return app(AdminPage::class)
        ->title('blog::messages.categories')
        ->breadcrumb($this->breadcrumb)
        ->body(new CategoryTable);
    }

    protected function form()
    {
        $form = new Form(new Category());
        $form->overrides('name', 'slug');

        $form->text('name->'.$this->request->getLocale(), __('blog::messages.name'))
              ->creationRules('required|string|max:255')
              ->updateRules('required|string|max:255');
        $form->select('active', 'Status')
        ->options([1 => __('blog::messages.active'),  0 => __('blog::messages.inactive')])
        ->default(1);

        $form->submitted(function(Form $form) {
            $form->ignore('name', 'slug');
        });

        $form->saving(function(Form $form) {
            $locale = $this->request->getLocale();
            $name_input  = $this->request->get('name');

            if($form->isEditing()) {
                $cat = Category::find($this->request->route('category'));
                if($locale == 'en') {
                    $data = ['en' => $name_input['en'], 'vi' => $cat->getTranslation('name', 'vi')];
                } else {
                    $data = ['vi' => $name_input['vi'], 'en' => $cat->getTranslation('name', 'en')];
                }

                $name_input = $data;
            } else {
                if($locale == 'en') {
                    $name_input = array_merge($name_input, ['vi' => $name_input['en']]);
                } else {
                    $name_input = array_merge($name_input, ['en' => $name_input['vi']]);
                }
            }

            $form->input('slug', Str::slug($name_input['en']));
            $form->input('name', $name_input);
        });

        return $form;
    }


    public function deletes()
    {
        $rows = $this->request->rows;
        Category::whereIn('id', $rows)->delete();

        return ApiResponse::success();
    }    
}
