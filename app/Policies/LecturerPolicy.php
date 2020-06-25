<?php

namespace App\Policies;

use App\Lecturer;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LecturerPolicy
{
    use HandlesAuthorization;

    /**
     * Filter before all other authorization checks.
     *
     * @param User   $user
     * @param string $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        return $user->role === 'super-admin';
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Lecturer  $lecturer
     * @return mixed
     */
    public function view(User $user, Lecturer $lecturer)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Lecturer  $lecturer
     * @return mixed
     */
    public function update(User $user, Lecturer $lecturer)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Lecturer  $lecturer
     * @return mixed
     */
    public function delete(User $user, Lecturer $lecturer)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Lecturer  $lecturer
     * @return mixed
     */
    public function restore(User $user, Lecturer $lecturer)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Lecturer  $lecturer
     * @return mixed
     */
    public function forceDelete(User $user, Lecturer $lecturer)
    {
        //
    }
}
