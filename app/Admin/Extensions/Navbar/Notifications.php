<?php
namespace App\Admin\Extensions\Navbar;

use Encore\Admin\Facades\Admin;

class Notifications
{
    public function __toString()
    {
        $notificationCount = Admin::user()->notification_count;

        $unreadNotifications = Admin::user()->unreadNotifications()->get();

        $notificationMenu = '';

        if ($notificationCount > 0) {
            foreach ($unreadNotifications as $notification) {
                $link = admin_base_path('notifications/'. $notification->id);

                switch (snake_case(class_basename($notification->type))) {
                    case 'feedback_created' :
                        $notificationMenu .= <<<HTML
<li>
    <a href="{$link}">
        <i class="fa fa-commenting text-red"></i> 您有一条【{$notification->data['feedback_name']}】的留言，请注意查看！
    </a>
</li>
HTML;

                        break;
                }
            }
        }else {
            $notificationMenu = <<<HTML
<li class="text-center text-muted" style="margin-top: 20px;">暂时没有消息通知！</li>
HTML;

        }

        $link = admin_base_path('/notifications');


        return <<<HTML
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-bell-o"></i>
        <span class="label label-warning">{$notificationCount}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">{$notificationCount}条未读通知</li>
        <li>
            <ul class="menu">
                {$notificationMenu}
            </ul>
        </li>
        <li class="footer"><a href="{$link}">查看全部</a></li>
    </ul>
</li>

HTML;
    }
}
