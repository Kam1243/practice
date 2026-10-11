<?php

namespace App\Policies;

use App\Models\User;

class InvitationPolicy
{
    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }
}
