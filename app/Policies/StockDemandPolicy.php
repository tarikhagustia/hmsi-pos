<?php

namespace App\Policies;

use App\StockDemand;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockDemandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any stock demands.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the stock demand.
     *
     * @param  \App\User  $user
     * @param  \App\StockDemand  $stockDemand
     * @return mixed
     */
    public function view(User $user, StockDemand $stockDemand)
    {
        return $user->branch_id == $stockDemand->from_branch_id;
    }

    /**
     * Determine whether the user can create stock demands.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the stock demand.
     *
     * @param  \App\User  $user
     * @param  \App\StockDemand  $stockDemand
     * @return mixed
     */
    public function update(User $user, StockDemand $stockDemand)
    {
        return $user->branch_id === $stockDemand->from_branch_id;
    }

    /**
     * Determine whether the user can delete the stock demand.
     *
     * @param  \App\User  $user
     * @param  \App\StockDemand  $stockDemand
     * @return mixed
     */
    public function delete(User $user, StockDemand $stockDemand)
    {

    }

    /**
     * Determine whether the user can restore the stock demand.
     *
     * @param  \App\User  $user
     * @param  \App\StockDemand  $stockDemand
     * @return mixed
     */
    public function restore(User $user, StockDemand $stockDemand)
    {

    }

    /**
     * Determine whether the user can permanently delete the stock demand.
     *
     * @param  \App\User  $user
     * @param  \App\StockDemand  $stockDemand
     * @return mixed
     */
    public function forceDelete(User $user, StockDemand $stockDemand)
    {

    }

    public function received(User $user, StockDemand $stockDemand)
    {
        return $user->branch_id == $stockDemand->from_branch_id;
    }
}
