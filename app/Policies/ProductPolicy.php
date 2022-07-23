<?php

namespace App\Policies;

use App\Models\Products;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Products $products)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
        $roleJson = $user->groups->permissions;
        if (!empty($roleJson)) {
            $roleArr  = json_decode($roleJson, true);
            $check = isRole($roleArr, 'products', 'add');
            return $check;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Products $products)
    {
        //
        return $user->id === $products->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Products $products)
    {
        //
        return $user->id === $products->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Products $products)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Products $products)
    {
        //
    }
}
