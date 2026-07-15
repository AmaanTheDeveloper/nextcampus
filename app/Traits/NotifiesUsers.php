<?php

namespace App\Traits;

use App\Models\User;
use App\Notifications\AppNotification;

trait NotifiesUsers
{
    protected function notifyAdmins(string $title, string $message, ?string $url = null): void
    {
        User::where('role', 'admin')->each(function ($admin) use ($title, $message, $url) {
            $admin->notify(new AppNotification($title, $message, $url));
        });
    }

    protected function notifyUser(User $user, string $title, string $message, ?string $url = null): void
    {
        $user->notify(new AppNotification($title, $message, $url));
    }
}
