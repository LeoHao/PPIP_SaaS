<?php

namespace App\Policies;

use App\User;
use App\Group;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laravel\Nova\Http\Requests\NovaRequest;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $model
     * @return mixed
     */
    public function view(User $user, Group $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $model
     * @return mixed
     */
    public function update(User $user, Group $model)
    {
        return true;

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $model
     * @return mixed
     */
    public function delete(User $user, Group $model)
    {
        return true;

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $model
     * @return mixed
     */
    public function restore(User $user, Group $model)
    {
        return true;

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $model
     * @return mixed
     */
    public function forceDelete(User $user, Group $model)
    {
        return true;
    }
}
