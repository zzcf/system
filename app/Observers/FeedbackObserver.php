<?php
namespace App\Observers;

use App\Models\AdminUser;
use App\Models\Feedback;
use App\Notifications\FeedbackCreated;

class FeedbackObserver
{
    public function created(Feedback $feedback)
    {
        // 查找超级管理员
        $user = AdminUser::where('username', 'admin')->firstOrFail();

        $user->notify(new FeedbackCreated($feedback));
    }
}