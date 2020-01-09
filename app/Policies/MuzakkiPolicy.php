<?php

namespace App\Policies;

use App\Enums\UserType;
use App\User;
use App\Muzakki;
use Illuminate\Auth\Access\HandlesAuthorization;

class MuzakkiPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the muzakki.
     *
     * @param  \App\User  $user
     * @param  \App\Muzakki  $muzakki
     * @return mixed
     */
    public function view(User $user, Muzakki $muzakki)
    {
        //
    }

    /**
     * Determine whether the user can create muzakkis.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the muzakki.
     *
     * @param  \App\User  $user
     * @param  \App\Muzakki  $muzakki
     * @return mixed
     */
    public function update(User $user, Muzakki $muzakki)
    {
        //
    }

    /**
     * Determine whether the user can delete the muzakki.
     *
     * @param  \App\User  $user
     * @param  \App\Muzakki  $muzakki
     * @return mixed
     */
    public function delete(User $user, Muzakki $muzakki)
    {
        return
            ($user->type === UserType::ADMINISTRATOR || (($user->collector->id ?? null) === $muzakki->collector_id)) &&
            (($muzakki->receivements_count ?? -1) === 0);
    }

    /**
     * Determine whether the user can restore the muzakki.
     *
     * @param  \App\User  $user
     * @param  \App\Muzakki  $muzakki
     * @return mixed
     */
    public function restore(User $user, Muzakki $muzakki)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the muzakki.
     *
     * @param  \App\User  $user
     * @param  \App\Muzakki  $muzakki
     * @return mixed
     */
    public function forceDelete(User $user, Muzakki $muzakki)
    {
        //
    }
}
