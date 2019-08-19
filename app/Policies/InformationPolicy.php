<?php

namespace App\Policies;

use App\User;
use App\Information;
use Illuminate\Auth\Access\HandlesAuthorization;

class InformationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the information.
     *
     * @param  \App\User  $user
     * @param  \App\Information  $information
     * @return mixed
     */
    public function view(User $user, Information $information)
    {
        //
    }

    /**
     * Determine whether the user can create information.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the information.
     *
     * @param  \App\User  $user
     * @param  \App\Information  $information
     * @return mixed
     */
    public function update(User $user, Information $information)
    {
        return in_array($user->type, [User::ADMINISTRATOR_TYPE]);
    }

    /**
     * Determine whether the user can delete the information.
     *
     * @param  \App\User  $user
     * @param  \App\Information  $information
     * @return mixed
     */
    public function delete(User $user, Information $information)
    {
        //
    }

    /**
     * Determine whether the user can restore the information.
     *
     * @param  \App\User  $user
     * @param  \App\Information  $information
     * @return mixed
     */
    public function restore(User $user, Information $information)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the information.
     *
     * @param  \App\User  $user
     * @param  \App\Information  $information
     * @return mixed
     */
    public function forceDelete(User $user, Information $information)
    {
        //
    }
}
