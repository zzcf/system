<?php

namespace App\Admin\Controllers;

use Encore\Admin\Facades\Admin;
use Illuminate\Notifications\DatabaseNotification;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class NotificationsController extends Controller
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
            ->header('消息通知')
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
        $notification = DatabaseNotification::findOrFail($id);
        if (Admin::user()->notification_count > 0) {
            Admin::user()->decrement('notification_count');
        }
        $notification->markAsRead();
        return redirect($notification->data['link']);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DatabaseNotification);

        $grid->model()->orderBy('created_at', 'desc');

        $grid->column('data', '标题')->display(function () {
            switch (snake_case(class_basename($this->type))) {
                case 'feedback_created' :
                    $notificationTitle = "您有一条【{$this->data['feedback_name']}】的留言，请注意查看！";
                    break;
            }
            return $notificationTitle;
        });
        $grid->read_at('是否已读')->display(function () {
            $color = $this->read_at ? 'danger' :'muted';
            $text = $this->read_at ? '已读' :'未读';
            return '<span class="text-'.$color.'">'.$text.'</span>';
        });
        $grid->created_at('创建时间');

        $grid->disableFilter();

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            if ($actions->row['read_at']) {
                $actions->disableView();
            }
            $actions->disableEdit();
        });

        return $grid;
    }

    public function destroy($id)
    {
        if (DatabaseNotification::destroy($id)) {
            $data = [
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ];
        } else {
            $data = [
                'status'  => false,
                'message' => trans('admin.delete_failed'),
            ];
        }
        if (Admin::user()->notification_count > 0) {
            Admin::user()->decrement('notification_count');
        }

        return response()->json($data);
    }

}
