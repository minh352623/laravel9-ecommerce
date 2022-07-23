<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SettingController;

//client
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\ProductClientController;
use App\Http\Controllers\Clients\CartController;
use App\Http\Controllers\Clients\FeaturesController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Models\Posts;
use App\Models\User;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Groups;
use App\Models\Settings;
use App\Models\Slider;

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
//forntend
Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::prefix('product')->name('product.')->group(function () {
    Route::get('/', [ProductClientController::class, 'index'])->name('index');
    Route::get('/show/{id}', [ProductClientController::class, 'showProductGlobal'])->name('show');
    Route::get('/detail/{id}', [ProductClientController::class, 'detail'])->name('detail');
});
Route::prefix('cart')->name('cart.')->group(function () {

    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
});


Route::prefix('features')->name('features.')->group(function () {
    Route::get('/', [FeaturesController::class, 'index'])->name('index');
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', function () {
        return 'blog';
    })->name('index');
});

Route::prefix('about')->name('about.')->group(function () {
    Route::get('/', function () {
        return 'about';
    })->name('index');
});


Route::prefix('contact')->name('contact.')->group(function () {
    Route::get('/', function () {
        return 'contact';
    })->name('index');
});

//end forntend


//backend
Route::get('auth/facebook/callback', function () {
    return '<h3>call back facebook</h3>';
});
Route::get('auth/facebook', function () {
    return Socialite::driver('facebook')->redirect();
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



    Route::prefix('category')->name('category.')->middleware('can:categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');

        Route::get('/add', [CategoryController::class, 'add'])->name('add')->can('create', Category::class);

        Route::post('/add', [CategoryController::class, 'categoryAdd'])->can('create', Category::class);

        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('edit');

        Route::post('/edit/{category}', [CategoryController::class, 'postEdit']);

        Route::get('/delete/{category}', [CategoryController::class, 'delete'])->name('delete');

        Route::get('/trash', [CategoryController::class, 'trash'])->name('trash');

        Route::get('/restore/{id}', [CategoryController::class, 'restore'])->name('restore');
        Route::get('/forceDelete/{id}', [CategoryController::class, 'forceDelete'])->name('forceDelete');
    });

    Route::prefix('menu')->name('menu.')->middleware('can:menus')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');

        Route::get('/add', [MenuController::class, 'add'])->name('add')->can('create', Menu::class);

        Route::post('/add', [MenuController::class, 'menuAdd'])->can('create', Menu::class);

        Route::get('/edit/{menu}', [MenuController::class, 'edit'])->name('edit');

        Route::post('/edit/{menu}', [MenuController::class, 'postEdit']);

        Route::get('/delete/{menu}', [MenuController::class, 'delete'])->name('delete');

        Route::get('/trash', [MenuController::class, 'trash'])->name('trash');

        Route::get('/restore/{id}', [MenuController::class, 'restore'])->name('restore');
        Route::get('/forceDelete/{id}', [MenuController::class, 'forceDelete'])->name('forceDelete');
    });


    Route::prefix('products')->name('products.')->middleware('can:products')->group(function () {
        Route::get('/', [ProductsController::class, 'index'])->name('index');

        Route::get('/add', [ProductsController::class, 'add'])->name('add')->can('products.add');

        Route::post('/add', [ProductsController::class, 'postAdd'])->can('products.add');

        Route::get('/edit/{product}', [ProductsController::class, 'edit'])->name('edit')->can('products.edit');

        Route::post('/edit/{product}', [ProductsController::class, 'postEdit'])->can('products.edit');

        Route::get('/delete/{product}', [ProductsController::class, 'delete'])->name('delete')->can('products.delete');

        Route::get('/trash', [ProductsController::class, 'trash'])->name('trash');

        Route::get('/restore/{id}', [ProductsController::class, 'restore'])->name('restore');

        Route::get('/forceDelete/{id}', [ProductsController::class, 'forceDelete'])->name('forceDelete');
    });

    Route::prefix('slider')->name('slider.')->middleware('can:sliders')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('index');

        Route::get('/add', [SliderController::class, 'add'])->name('add')->can('create', Slider::class);

        Route::post('/add', [SliderController::class, 'postAdd'])->can('create', Slider::class);

        Route::get('/edit/{slider}', [SliderController::class, 'edit'])->name('edit');

        Route::post('/edit/{slider}', [SliderController::class, 'postEdit']);

        Route::get('/delete/{slider}', [SliderController::class, 'delete'])->name('delete');

        Route::get('/trash', [SliderController::class, 'trash'])->name('trash');

        Route::get('/restore/{id}', [SliderController::class, 'restore'])->name('restore');

        Route::get('/forceDelete/{id}', [SliderController::class, 'forceDelete'])->name('forceDelete');
    });


    Route::prefix('setting')->name('setting.')->middleware('can:settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');

        Route::get('/add', [SettingController::class, 'add'])->name('add')->can('settings.add');

        Route::post('/add', [SettingController::class, 'postAdd'])->can('settings.add');

        Route::get('/edit/{setting}', [SettingController::class, 'edit'])->name('edit');

        Route::post('/edit/{setting}', [SettingController::class, 'postEdit']);

        Route::get('/delete/{setting}', [SettingController::class, 'delete'])->name('delete');

        Route::get('/trash', [SettingController::class, 'trash'])->name('trash');

        Route::get('/restore/{id}', [SettingController::class, 'restore'])->name('restore');

        Route::get('/forceDelete/{id}', [SettingController::class, 'forceDelete'])->name('forceDelete');
    });
});
