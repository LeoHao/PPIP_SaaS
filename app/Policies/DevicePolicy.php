<?php

namespace App\Policies;

use App\Device;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laravel\Nova\Http\Requests\NovaRequest;

class DevicePolicy
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
        //
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $model
     * @return mixed
     */
    public function view(User $user, Device $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $model
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
     * @param  \App\Device  $model
     * @return mixed
     */
    public function update(User $user, Device $model)
    {
        //
        return true;

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $model
     * @return mixed
     */
    public function delete(User $user, Device $model)
    {
        //
        return true;

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $model
     * @return mixed
     */
    public function restore(User $user, Device $model)
    {
        //
        return true;

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $model
     * @return mixed
     */
    public function forceDelete(User $user, Device $model)
    {
        //
        return true;
    }
}
