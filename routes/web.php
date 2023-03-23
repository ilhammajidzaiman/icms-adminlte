<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Private\LoginController;
use App\Http\Controllers\Private\ProfilController as DeveloperProfilController;
use App\Http\Controllers\Private\DashboardController as DeveloperDashboardController;
use App\Http\Controllers\Private\Developer\UserController as DeveloperUserController;
use App\Http\Controllers\Private\Developer\UserLevelController as DeveloperUserLevelController;
use App\Http\Controllers\Private\Developer\UserAccessController as DeveloperUserAccessController;
use App\Http\Controllers\Private\Developer\UserStatusController as DeveloperUserStatusController;
use App\Http\Controllers\Private\Developer\UserMenuParentController as DeveloperUserMenuParentController;
use App\Http\Controllers\Private\Developer\UserMenuChildController as DeveloperUserMenuChildController;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [App\Http\Controllers\Public\PublicController::class, 'index'])->name('/');

Route::get('/redirect', function () {
    $prefix = Str::replace(' ', '', Str::lower(auth()->user()->level->name));
    return redirect()->intended($prefix . '/dashboard');
});



Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'index')->name('login')->middleware('guest');
    Route::post('login', 'authenticate')->name('authenticate');
    Route::get('logout', 'logout')->name('logout');
    Route::post('logout', 'logout')->name('logout');
});



Route::prefix('developer')->middleware(['auth', 'isDeveloper'])->controller()->group(
    function () {
        Route::get('/dashboard', [DeveloperDashboardController::class, 'index'])->name('developer.dashboard');

        Route::prefix('profil')->controller(DeveloperProfilController::class)->group(function () {
            Route::get('/{uuid}', 'index')->name('developer.profil');
            Route::get('/{uuid}/edit', 'edit')->name('developer.profil.edit');
            Route::put('/{uuid}/edit', 'update')->name('developer.profil.update');
            Route::get('/{uuid}/password', 'password')->name('developer.profil.password');
            Route::put('/{uuid}', 'update2')->name('developer.profil.update2');
        });

        Route::prefix('management')->group(
            function () {
                Route::resource('/status', DeveloperUserStatusController::class)->scoped(['status' => 'slug']);
                Route::resource('/level', DeveloperUserLevelController::class)->scoped(['level' => 'slug']);
                Route::resource('/menu', DeveloperUserMenuParentController::class)->scoped(['menu' => 'uuid']);
                Route::controller(DeveloperUserMenuChildController::class)->group(function () {
                    Route::get('menu/{menu:uuid}/show-sub', 'show')->name('show.sub');
                    Route::get('menu/{menu:uuid}/create-sub', 'create')->name('create.sub');
                    Route::post('menu/{menu:uuid}/create-sub', 'store')->name('create.sub');
                    Route::get('menu/{menu:uuid}/edit-sub', 'edit')->name('edit.sub');
                    Route::put('menu/{menu:uuid}/edit-sub', 'update')->name('edit.sub');
                    Route::delete('menu/{menu:uuid}/delete-sub', 'destroy')->name('delete.sub');
                });
                Route::controller(DeveloperUserAccessController::class)->group(function () {
                    Route::resource('/access', DeveloperUserAccessController::class)->scoped(['access' => 'slug']);
                    Route::get('access/parent/{level}/{parent}/{order}', 'updateParent')->name('developer.access.parent');
                    Route::get('access/child/{level}/{parent}/{child}/{order}', 'updateChild')->name('developer.access.child');
                });
                Route::resource('/user', DeveloperUserController::class)->scoped(['user' => 'uuid']);
            }
        );

        // Route::prefix('master')->group(
        //     function () {
        //         Route::resource('/status', App\Http\Controllers\Private\Developer\UserStatusController::class)->scoped(['status' => 'slug']);

        //         Route::resource('/level', App\Http\Controllers\Private\Developer\UserLevelController::class)->scoped(['level' => 'slug']);

        //         Route::controller(App\Http\Controllers\Private\Developer\UserMenuController::class)->group(function () {
        //             Route::resource('/menu', App\Http\Controllers\Private\Developer\UserMenuController::class)->scoped(['menu' => 'slug']);
        //             Route::get('menu/{menu:slug}/create_sub', 'create_sub')->name('menu.create_sub');
        //             Route::post('menu/{menu:slug}/create_sub', 'store_sub')->name('menu.create_sub');
        //         });

        //         Route::controller(App\Http\Controllers\Private\Developer\UserAccessController::class)->group(function () {
        //             Route::resource('/access', App\Http\Controllers\Private\Developer\UserAccessController::class)->scoped(['access' => 'slug']);
        //             Route::get('access/parent/{level}/{parent}/{order}', 'updateParent')->name('access.parent');
        //             Route::get('access/child/{level}/{parent}/{child}/{order}', 'updateChild')->name('access.child');
        //         });

        //         Route::resource('/user', App\Http\Controllers\Private\Developer\UserController::class)->scoped(['user' => 'uuid']);
        //     }
        // );
    }
);



Route::prefix('admin')->middleware(['auth', 'isAdmin'])->controller()->group(
    function () {
        Route::get('/dashboard', [App\Http\Controllers\Private\DashboardController::class, 'index'])->name('admin.dashboard');

        Route::prefix('profil')->controller(App\Http\Controllers\Private\ProfilController::class)->group(function () {
            Route::get('/{uuid}', 'index')->name('admin.profil');
            Route::get('/{uuid}/edit', 'edit')->name('admin.profil.edit');
            Route::put('/{uuid}', 'update')->name('admin.profil.update');
            Route::get('/{uuid}/password', 'password')->name('admin.profil.password');
            Route::put('/{uuid}', 'update2')->name('admin.profil.update2');
        });

        Route::prefix('management')->group(
            function () {
                Route::resource('/status', App\Http\Controllers\Private\Admin\UserStatusController::class)->scoped(['status' => 'slug']);

                Route::resource('/level', App\Http\Controllers\Private\Admin\UserLevelController::class)->scoped(['level' => 'slug']);

                Route::controller(App\Http\Controllers\Private\Admin\UserMenuController::class)->group(function () {
                    Route::resource('/menu', App\Http\Controllers\Private\Admin\UserMenuController::class)->scoped(['menu' => 'slug']);
                    Route::get('menu/{menu:slug}/create_sub', 'create_sub')->name('menu.create_sub');
                    Route::post('menu/{menu:slug}/create_sub', 'store_sub')->name('menu.create_sub');
                });

                Route::controller(App\Http\Controllers\Private\Admin\UserAccessController::class)->group(function () {
                    Route::resource('/access', App\Http\Controllers\Private\Admin\UserAccessController::class)->scoped(['access' => 'slug']);
                    Route::get('access/parent/{level}/{parent}/{order}', 'updateParent')->name('access.parent');
                    Route::get('access/child/{level}/{parent}/{child}/{order}', 'updateChild')->name('access.child');
                });

                Route::resource('/user', App\Http\Controllers\Private\Admin\UserController::class)->scoped(['user' => 'uuid']);
            }
        );

        // Route::prefix('master')->group(
        //     function () {
        //         Route::resource('/status', App\Http\Controllers\Private\Admin\UserStatusController::class)->scoped(['status' => 'slug']);

        //         Route::resource('/level', App\Http\Controllers\Private\Admin\UserLevelController::class)->scoped(['level' => 'slug']);

        //         Route::controller(App\Http\Controllers\Private\Admin\UserMenuController::class)->group(function () {
        //             Route::resource('/menu', App\Http\Controllers\Private\Admin\UserMenuController::class)->scoped(['menu' => 'slug']);
        //             Route::get('menu/{menu:slug}/create_sub', 'create_sub')->name('menu.create_sub');
        //             Route::post('menu/{menu:slug}/create_sub', 'store_sub')->name('menu.create_sub');
        //         });

        //         Route::resource('/access', App\Http\Controllers\Private\Admin\UserAccessController::class)->scoped(['access' => 'slug']);
        //     }
        // );

        // Route::resource('/user', App\Http\Controllers\Private\Admin\UserController::class)->scoped(['user' => 'uuid']);
    }
);



Route::prefix('user')->middleware(['auth', 'isUser'])->group(
    function () {
        Route::prefix('profil')->controller(App\Http\Controllers\Private\ProfilController::class)->group(function () {
            Route::get('/{uuid}', 'index')->name('admin.profil');
            Route::get('/{uuid}/edit', 'edit')->name('admin.profil.edit');
            Route::put('/{uuid}', 'update')->name('admin.profil.update');
        });

        Route::get('/dashboard', [App\Http\Controllers\Private\DashboardController::class, 'index'])->name('user.dashboard');
    }
);
