<?php

namespace App\Admin\Controllers;

use App\Models\ProductCompany;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductCompaniesController extends Controller
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
            ->header('公司')
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
            ->header('公司')
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
            ->header('公司')
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
        $grid = new Grid(new ProductCompany);

        $grid->id('ID');
        $grid->column('category.title', '分类')->label();
        $grid->name('名称')->display(function ($value) {
            $logo = $this->logo ? '<img src="'.$this->logo.'" style="max-height:32px;margin-right: 8px;" class="img img-thumbnail">' : '';
            return $logo.$value;
        });
        $grid->status('状态')->switch([
            'on'  => ['value' => 1, 'text' => '启用', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '禁用', 'color' => 'default'],
        ]);
        $grid->updated_at('更新时间');

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function($filter){
            $categories = ProductCategory::where('status', true)->get()->pluck('title', 'id');
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->equal('category_id', '所属分类')->select($categories);
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
        $categories = ProductCategory::where('status', true)->get()->pluck('title', 'id');

        $form = new Form(new ProductCompany);

        $form->select('category_id', '所属分类')->options($categories)->rules('required');
        $form->text('name', '名称')->rules('required');
        $form->text('simple_name', '简称')->rules('nullable');
        $form->text('english_name', '英文名称')->rules('nullable');
        $form->image('logo', 'LOGO')->rules('nullable');
        $form->text('background', '股东背景')->rules('nullable');
        $form->text('capital', '注册资本')->append('亿')->rules('nullable');
        $form->text('scale', '资产管理规模')->append('亿')->rules('nullable');
        $form->date('create_date', '成立日期')->rules('nullable');
        $form->text('city', '所在城市')->rules('nullable');
        $form->text('chairman', '董事长')->rules('nullable');
        $form->text('top_manager', '总经理')->rules('nullable');
        $form->text('representative', '法人代表')->rules('nullable');
        $form->text('stock_holder', '大股东')->rules('nullable');
        $form->switch('is_list', '是否上市')->default(1)->rules('nullable')->states([
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'danger'],
        ]);
        $form->textarea('content', '详情')->rules('nullable');
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
