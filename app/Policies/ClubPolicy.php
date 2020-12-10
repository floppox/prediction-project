<?php

namespace App\Policies;

use App\Models\Club;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClubPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the club can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list clubs');
    }

    /**
     * Determine whether the club can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Club  $model
     * @return mixed
     */
    public function view(User $user, Club $model)
    {
        return $user->hasPermissionTo('view clubs');
    }

    /**
     * Determine whether the club can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create clubs');
    }

    /**
     * Determine whether the club can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Club  $model
     * @return mixed
     */
    public function update(User $user, Club $model)
    {
        return $user->hasPermissionTo('update clubs');
    }

    /**
     * Determine whether the club can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Club  $model
     * @return mixed
     */
    public function delete(User $user, Club $model)
    {
        return $user->hasPermissionTo('delete clubs');
    }

    /**
     * Determine whether the club can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Club  $model
     * @return mixed
     */
    public function restore(User $user, Club $model)
    {
        return false;
    }

    /**
     * Determine whether the club can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Club  $model
     * @return mixed
     */
    public function forceDelete(User $user, Club $model)
    {
        return false;
    }
}
