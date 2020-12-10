<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TournamentTableEntry;
use Illuminate\Auth\Access\HandlesAuthorization;

class TournamentTableEntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the tournamentTableEntry can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list tournamenttableentries');
    }

    /**
     * Determine whether the tournamentTableEntry can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TournamentTableEntry  $model
     * @return mixed
     */
    public function view(User $user, TournamentTableEntry $model)
    {
        return $user->hasPermissionTo('view tournamenttableentries');
    }

    /**
     * Determine whether the tournamentTableEntry can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create tournamenttableentries');
    }

    /**
     * Determine whether the tournamentTableEntry can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TournamentTableEntry  $model
     * @return mixed
     */
    public function update(User $user, TournamentTableEntry $model)
    {
        return $user->hasPermissionTo('update tournamenttableentries');
    }

    /**
     * Determine whether the tournamentTableEntry can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TournamentTableEntry  $model
     * @return mixed
     */
    public function delete(User $user, TournamentTableEntry $model)
    {
        return $user->hasPermissionTo('delete tournamenttableentries');
    }

    /**
     * Determine whether the tournamentTableEntry can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TournamentTableEntry  $model
     * @return mixed
     */
    public function restore(User $user, TournamentTableEntry $model)
    {
        return false;
    }

    /**
     * Determine whether the tournamentTableEntry can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\TournamentTableEntry  $model
     * @return mixed
     */
    public function forceDelete(User $user, TournamentTableEntry $model)
    {
        return false;
    }
}
