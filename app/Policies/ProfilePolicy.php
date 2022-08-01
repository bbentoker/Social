<?php

namespace App\Policies;

use App\Models\{User,Profile};
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user,Profile $profile){
        return $user->id == $profile->user_id;
    }
}
