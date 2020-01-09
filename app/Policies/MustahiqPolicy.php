<?php

namespace App\Policies;

use App\Enums\UserType;
use App\User;
use App\Mustahiq;
use Illuminate\Auth\Access\HandlesAuthorization;

class MustahiqPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the mustahiq.
     *
     * @param  \App\User  $user
     * @param  \App\Mustahiq  $mustahiq
     * @return mixed
     */
    public function view(User $user, Mustahiq $mustahiq)
    {
        //
    }

    /**
     * Determine whether the user can create mustahiqs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the mustahiq.
     *
     * @param  \App\User  $user
     * @param  \App\Mustahiq  $mustahiq
     * @return mixed
     */
    public function update(User $user, Mustahiq $mustahiq)
    {
        return $user->type === UserType::ADMINISTRATOR || (($user->collector->id ?? null) === $mustahiq->collector_id);
    }

    /**
     * Determine whether the user can delete the mustahiq.
     *
     * @param  \App\User  $user
     * @param  \App\Mustahiq  $mustahiq
     * @return mixed
     */
    public function delete(User $user, Mustahiq $mustahiq)
    {
        return
            (
                $user->type === UserType::ADMINISTRATOR ||
                (($user->collector->id ?? null) === $mustahiq->collector_id)
            ) &&
            (($mustahiq->donations_count ?? -1) === 0);
    }

    /**
     * Determine whether the user can restore the mustahiq.
     *
     * @param  \App\User  $user
     * @param  \App\Mustahiq  $mustahiq
     * @return mixed
     */
    public function restore(User $user, Mustahiq $mustahiq)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the mustahiq.
     *
     * @param  \App\User  $user
     * @param  \App\Mustahiq  $mustahiq
     * @return mixed
     */
    public function forceDelete(User $user, Mustahiq $mustahiq)
    {
        //
    }
}
