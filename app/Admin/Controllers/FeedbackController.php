<?php

namespace App\Admin\Controllers;

use App\Models\Feedback;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class FeedbackController extends Controller
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
            ->header('留言')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('留言')
            ->description('详细')
            ->body($this->detail($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Feedback);

        $grid->id('ID');
        $grid->name('称呼');
        $grid->phone('手机号码');
        $grid->column('product.name', '咨询产品');
        $grid->source('来源');
        $grid->source_url('来源网址')->link();
        $grid->source_ip('来源IP')->label();
        $grid->created_at('创建时间');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
        });

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->like('name', '称呼');
            $filter->like('phone', '手机号码');

        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Feedback::findOrFail($id));

        $show->name('称呼');
        $show->phone('手机号码');
        $show->product('咨询的产品', function ($product) {
            $product->name('名称');

            $product->panel()
                ->tools(function ($tools) {
                    $tools->disableEdit();
                });
        });
        $show->content('内容');
        $show->source('来源');
        $show->source_url('来源网址')->link();
        $show->source_ip('来源IP')->unescape()->as(function ($ip) {
            return $ip.' <a class="label label-primary" href="http://www.ip138.com/ips138.asp?ip='.$ip.'" target="_blank">查询</a>';
        });;
        $show->created_at('创建时间');

        $show->panel()
            ->tools(function ($tools) {
                $tools->disableEdit();
            });

        return $show;
    }
}
