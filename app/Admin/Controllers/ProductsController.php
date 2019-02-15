<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ProductsController extends Controller
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
            ->header('产品')
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
            ->header('产品')
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
            ->header('产品')
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
        $grid = new Grid(new Product);

        $grid->id('ID');
        $grid->order('排序')->editable();
        $grid->column('category.title', '分类')->label();
        $grid->name('名称');
        $grid->profit_min_value('产品收益')->display(function ($value) {
            return ($this->profit_max_value ? $value.'%~'.$this->profit_max_value : $value).'%';
        });
        $grid->term_min_value('投资期限')->display(function ($value) {
            return ($this->term_max_value ? $value.'个月~'.$this->term_max_value : $value).'个月';
        });
        $grid->raise('募集状态')->display(function ($value) {
            $colors = [1 => 'success', 0 => 'danger'];
            return '<span class="text-'.$colors[$value].'">'.Product::$raiseMap[$value].'</span>';
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
            $filter->equal('raise', '募集状态')->radio(Product::$raiseMap);
            $filter->equal('profit', '收益范围')->select(Product::$profitMap);
            $filter->equal('term', '期限范围')->select(Product::$termMap);
            $filter->equal('invest_direction', '投资方向')->select(Product::$investDirectionMap);
            $filter->equal('interest_type', '付息方式')->select(Product::$interestTypeMap);
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

        $form = new Form(new Product);

        $form->tab('基本', function ($form) use ($categories) {

            $form->text('name', '名称')->rules('required');
            $form->text('full_name', '全称')->rules('required');
            $form->select('category_id', '所属分类')->options($categories)->load('company', 'productCategories/api/companies')->rules('required');;
            $form->select('company', '所属公司')->rules('nullable');
            $form->textarea('description', '描述')->rules('nullable');
            $form->text('profit_min_value', '收益最小值')->append('%')->rules('required');
            $form->text('profit_max_value', '收益最大值')->append('%')->rules('nullable');
            $form->textarea('profit_description', '收益描述')->rules('nullable');
            $form->text('term_min_value', '期限最小值')->append('个月')->rules('required|min:1');
            $form->text('term_max_value', '期限最大值')->append('个月')->rules('nullable|min:1');
            $form->text('min_invest', '起投金额')->default(100)->append('万')->rules('required');
            $form->text('collect_size', '募集规模')->append('亿')->rules('required');
            $form->switch('status', '状态')->default(1)->states([
                'on'  => ['value' => 1, 'text' => '启用', 'color' => 'primary'],
                'off' => ['value' => 0, 'text' => '禁用', 'color' => 'default'],
            ]);
            $form->number('order', '排序')->default(999);

        })->tab('属性', function ($form) {
            $form->radio('raise', '募集状态')->options(Product::$raiseMap)->default(1)->rules('required');
            $form->select('profit', '收益范围')->options(Product::$profitMap)->rules('required');
            $form->select('term', '期限范围')->options(Product::$termMap)->rules('required');
            $form->select('invest_direction', '投资方向')->options(Product::$investDirectionMap)->rules('required');
            $form->select('interest_type', '付息方式')->options(Product::$interestTypeMap)->rules('required');

        })->tab('详情', function ($form) {
            $form->hasMany('details', '主要内容', function (Form\NestedForm $form) {
                $form->text('title','标题')->rules('required');
                $form->textarea('content', '内容')->rules('required');
            });
        });

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
