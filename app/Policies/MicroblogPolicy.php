<?php

namespace App\Policies;

use App\Models\User;


use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Microblog;

class MicroblogPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }


    use HandlesAuthorization;

    public function destroy(User $user, Microblog $microblog)
    {
        return $user->id === $microblog->user_id;
    }
}
