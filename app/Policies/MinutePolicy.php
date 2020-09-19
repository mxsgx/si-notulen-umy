<?php

namespace App\Policies;

use App\Minute;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MinutePolicy
{
    use HandlesAuthorization;

    /**
     * Filter before all other authorization checks.
     *
     * @param  User  $user
     * @param  string  $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->role === 'super-admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return in_array($user->role, ['super-admin', 'admin', 'operator']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Minute  $minute
     * @return mixed
     */
    public function view(User $user, Minute $minute)
    {
        return $user->study_id === $minute->study_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role, ['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Minute  $minute
     * @return mixed
     */
    public function update(User $user, Minute $minute)
    {
        if ($user->role === 'operator') return false;

        return $user->study_id === $minute->study_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Minute  $minute
     * @return mixed
     */
    public function delete(User $user, Minute $minute)
    {
        if ($user->role === 'operator') return false;

        return $user->study_id === $minute->study_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Minute  $minute
     * @return mixed
     */
    public function restore(User $user, Minute $minute)
    {
        if ($user->role === 'operator') return false;

        return $user->study_id === $minute->study_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Minute  $minute
     * @return mixed
     */
    public function forceDelete(User $user, Minute $minute)
    {
        if ($user->role === 'operator') return false;

        return $user->study_id === $minute->study_id;
    }
}
