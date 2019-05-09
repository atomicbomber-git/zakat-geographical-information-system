<?php

namespace App\Policies;

use App\User;
use App\Collector;
use Illuminate\Auth\Access\HandlesAuthorization;

class CollectorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the collector.
     *
     * @param  \App\User  $user
     * @param  \App\Collector  $collector
     * @return mixed
     */
    public function view(User $user, Collector $collector)
    {
        //
    }

    /**
     * Determine whether the user can create collectors.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the collector.
     *
     * @param  \App\User  $user
     * @param  \App\Collector  $collector
     * @return mixed
     */
    public function update(User $user, Collector $collector)
    {
        //
    }

    /**
     * Determine whether the user can delete the collector.
     *
     * @param  \App\User  $user
     * @param  \App\Collector  $collector
     * @return mixed
     */
    public function delete(User $user, Collector $collector)
    {
        if ($user->type !== User::ADMINISTRATOR_TYPE) {
            return false;
        }
        
        foreach (Collector::HAS_RELATIONS as $relation) {
            if ($collector->{"{$relation}_count"} === null) {
                $collector->loadCount($relation);
            }

            if ($collector->{"{$relation}_count"} > 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine whether the user can restore the collector.
     *
     * @param  \App\User  $user
     * @param  \App\Collector  $collector
     * @return mixed
     */
    public function restore(User $user, Collector $collector)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the collector.
     *
     * @param  \App\User  $user
     * @param  \App\Collector  $collector
     * @return mixed
     */
    public function forceDelete(User $user, Collector $collector)
    {
        //
    }
}
