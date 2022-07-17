<?php

namespace App\Policies;

use App\Models\Groups;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
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
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Groups $groups)
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
            $check = isRole($roleArr, 'groups', 'add');
            return $check;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Groups $group)
    {
        //
        return $user->id === $group->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Groups $group)
    {
        //
        return $user->id === $group->user_id;
    }
    public function permissions(User $user, Groups $group)
    {
        return ($user->id === $group->user_id || $group->user_id == $user->user_id);
    }
    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Groups $group)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Groups $group)
    {
        //
    }
}
