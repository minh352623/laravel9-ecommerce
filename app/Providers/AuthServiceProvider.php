<?php

namespace App\Providers;

use App\Models\Groups;
use App\Models\Modules;
use App\Models\Posts;
use App\Models\User;
use App\Policies\GroupPolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Posts::class => PostPolicy::class,
        User::class => UserPolicy::class,
        Groups::class => GroupPolicy::class,


    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //

        /**
         * 1.lấy danh sách module
         */

        $moduleList = Modules::all();

        if ($moduleList->count() > 0) {
            foreach ($moduleList as $module) {
                Gate::define($module->name, function (User $user) use ($module) {
                    $roleJson = $user->groups->permissions;
                    if (!empty($roleJson)) {
                        $roleArr  = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name);
                        return $check;
                    }
                    return false;
                });


                Gate::define($module->name . '.add', function (User $user) use ($module) {
                    $roleJson = $user->groups->permissions;
                    if (!empty($roleJson)) {
                        $roleArr  = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'add');
                        return $check;
                    }
                    return false;
                });


                Gate::define($module->name . '.edit', function (User $user) use ($module) {
                    $roleJson = $user->groups->permissions;
                    if (!empty($roleJson)) {
                        $roleArr  = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'edit');
                        return $check;
                    }
                    return false;
                });


                Gate::define($module->name . '.delete', function (User $user) use ($module) {
                    $roleJson = $user->groups->permissions;
                    if (!empty($roleJson)) {
                        $roleArr  = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'delete');
                        return $check;
                    }
                    return false;
                });


                Gate::define($module->name . '.permission', function (User $user) use ($module) {
                    $roleJson = $user->groups->permissions;
                    if (!empty($roleJson)) {
                        $roleArr  = json_decode($roleJson, true);
                        $check = isRole($roleArr, $module->name, 'permission');
                        return $check;
                    }
                    return false;
                });
            }
        }
    }
}
