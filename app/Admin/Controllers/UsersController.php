<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UsersController extends Controller
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
            ->header('用户')
            ->description('列表')
            ->body($this->grid());
    }

    public function show($id, Content $content)
    {
        return $content
            ->header('用户')
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
        $grid = new Grid(new User);

        $grid->model()->orderBy('created_at', 'desc');

        $grid->id('ID');
        $grid->name('用户')->display(function ($value) {
            $avatar = '<img src="'.$this->avatar.'" style="max-height:32px;margin-right: 8px;" class="img img-thumbnail">';
            return $avatar.$value;
        });
        $grid->phone('手机号码');
        $grid->created_at('注册时间');
        $grid->source('来源');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
            $actions->disableDelete();
        });

        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->like('name', '姓名');
            $filter->like('phone', '手机号码');

        });


        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->avatar('头像')->unescape()->as(function ($avatar) {
            return "<img src='{$avatar}' width='50' />";
        });
        $show->name('姓名');
        $show->nickname('昵称');
        $show->phone('手机号码');
        $show->email('邮箱地址');
        $show->source('来源');
        $show->created_at('注册时间');

        $show->panel()
            ->tools(function ($tools) {
                $tools->disableEdit();
                $tools->disableDelete();
            });

        return $show;
    }
}
