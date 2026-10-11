<?php

namespace App\Policies;

use App\Models\ShortUrl;
use App\Models\User;

class ShortUrlPolicy
{
    public function create(User $user)
    {
        return $user->isAdmin() || $user->isMember();
    }

    public function view(User $user, ShortUrl $shortUrl)
    {
        if ($user->isSuperAdmin()) return true;
        if ($user->isAdmin()) return $shortUrl->company_id === $user->company_id;
        if ($user->isMember()) return $shortUrl->user_id === $user->id;
        return false;
    }
}
