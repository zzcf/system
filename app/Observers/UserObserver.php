<?php
namespace App\Observers;

use App\Models\AdminUser;
use App\Models\User;
use App\Notifications\UserCreated;

class UserObserver
{
    public function created(User $user)
    {
        // 查找超级管理员
        $adminUser = AdminUser::where('username', 'admin')->firstOrFail();

        $adminUser->notify(new UserCreated($user));
    }
}