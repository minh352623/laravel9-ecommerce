<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\Posts;
use App\Models\User;
use App\Models\Groups;
use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return 'trang chu';
})->middleware('auth');

Route::get('auth/facebook/callback', function () {
    return '<h3>call back facebook</h3>';
});
Route::get('auth/facebook', function () {
    // return Socialite::driver('facebook')->redirect();
});

Auth::routes();
Route::get('chinh-sach-quyen-rieng-tu', function () {
    return 'Chính sách quyền riêng tư';
});
//đăng kí
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/admin');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

//end đăng kí

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware('auth', 'verified')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');


    Route::prefix('posts')->name('posts.')->middleware('can:posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index')->can('viewAny', Posts::class);

        Route::get('/add', [PostController::class, 'add'])->name('add')->can('create', Posts::class);

        Route::post('/add', [PostController::class, 'postAdd'])->can('create', Posts::class);

        Route::get('/edit/{post}', [PostController::class, 'edit'])->name('edit')->can('posts.edit');

        Route::post('/edit/{post}', [PostController::class, 'postEdit'])->can('posts.edit');

        Route::get('/delete/{post}', [PostController::class, 'delete'])->name('delete')->can('posts.delete');
    });

    Route::prefix('groups')->name('groups.')->middleware('can:groups')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('index');

        Route::get('/add', [GroupController::class, 'add'])->name('add')->can('create', Groups::class);

        Route::post('/add', [GroupController::class, 'postAdd'])->can('create', Groups::class);

        Route::get('/edit/{group}', [GroupController::class, 'edit'])->name('edit')->can('groups.edit');

        Route::post('/edit/{group}', [GroupController::class, 'postEdit'])->can('groups.edit');

        Route::get('/delete/{group}', [GroupController::class, 'delete'])->name('delete')->can('groups.delete');

        //phân quyền

        Route::get('/permissions/{group}', [GroupController::class, 'permissions'])->name('permissions')->can('groups.permission');

        Route::post('/permissions/{group}', [GroupController::class, 'postPermissions'])->can('groups.permission');
    });

    Route::prefix('users')->name('users.')->middleware('can:users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');

        Route::get('/add', [UsersController::class, 'add'])->name('add')->can('create', User::class);
        Route::post('/add', [UsersController::class, 'postAdd'])->can('create', User::class);


        Route::get('/edit/{user}', [UsersController::class, 'edit'])->name('edit')->can('edit', User::class);

        Route::post('/edit/{user}', [UsersController::class, 'postEdit'])->can('edit', User::class);

        Route::get('/delete/{user}', [UsersController::class, 'delete'])->name('delete')->can('delete', User::class);
    });
});
