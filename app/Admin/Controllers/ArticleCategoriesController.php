<?php

namespace App\Admin\Controllers;

use App\Models\ArticleCateGory;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ArticleCategoriesController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('资讯分类')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('资讯分类')
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('资讯分类')
            ->description('创建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ArticleCateGory);

        $grid->model()->orderBy('order', 'asc')->orderBy('created_at', 'desc');

        $grid->id('ID');
        $grid->order('排序')->editable();
        $grid->title('标题');
        $grid->status('状态')->switch([
            'on'  => ['value' => 1, 'text' => '启用', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '禁用', 'color' => 'default'],
        ]);
        $grid->updated_at('更新时间');

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->like('title', '标题');
            $filter->like('name', '名称');
            $filter->equal('status', '状态')->radio([
                ''   => '全部',
                1    => '启用',
                0    => '禁用',
            ]);

        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ArticleCateGory);

        $form->text('title', '标题')->rules('required');
        $form->switch('status', '状态')->default(1)->states([
            'on'  => ['value' => 1, 'text' => '启用', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '禁用', 'color' => 'default'],
        ]);
        $form->number('order', '排序')->default(999);

        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });

        $form->footer(function ($footer) {
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
        });

        return $form;
    }
}
