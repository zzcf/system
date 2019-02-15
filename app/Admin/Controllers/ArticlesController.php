<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ArticlesController extends Controller
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
            ->header('资讯')
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
            ->header('资讯')
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
            ->header('资讯')
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
        $grid = new Grid(new Article);

        $grid->id('ID');
        $grid->order('排序')->editable();
        $grid->column('category.title', '分类')->label();
        $grid->cover('封面')->image(null, null, 50);
        $grid->title('标题');
        $grid->status('状态')->switch([
            'on'  => ['value' => 1, 'text' => '启用', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '禁用', 'color' => 'default'],
        ]);
        $grid->published_at('发布时间');
        $grid->updated_at('更新时间');

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $categories = ArticleCategory::where('status', true)->get()->pluck('title', 'id');

        $form = new Form(new Article);

        $form->select('category_id', '所属分类')->options($categories)->rules('required');
        $form->text('title', '标题')->rules('required');
        $form->image('cover', '封面')->rules('required');
        $form->textarea('description', '描述')->rules('nullable');
        $form->textarea('content', '详情')->rules('required');
        $form->datetime('published_at', '发布时间')->default(date('Y-m-d H:i:s'))->rules('nullable');
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

        //保存前回调
        $form->saving(function (Form $form) {
            $form->published_at = $form->published_at ?: Carbon::now();
        });

        return $form;
    }
}
