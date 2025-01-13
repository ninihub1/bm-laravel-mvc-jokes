<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JokeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [StaticPageController::class, 'home'])->name('static.home');
Route::get('/about', [StaticPageController::class, 'about'])->name('static.about');
Route::get('/contact', [StaticPageController::class, 'contact'])->name('static.contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/jokes/create', [JokeController::class, 'create'])->name('jokes.create');
    Route::post('/jokes', [JokeController::class, 'store'])->name('jokes.store');
    Route::get('/jokes/{id}/edit', [JokeController::class, 'edit'])->name('jokes.edit');
    Route::put('/jokes/{id}', [JokeController::class, 'update'])->name('jokes.update');
    Route::delete('/jokes/{id}', [JokeController::class, 'destroy'])->name('jokes.destroy');
});

Route::get('/jokes', [JokeController::class, 'index'])->name('jokes.index');
Route::get('/jokes/{id}', [JokeController::class, 'show'])->name('jokes.show');

Route::middleware(['auth:sanctum','role:Superuser|Administrator'])->group(function () {
    Route::get('/admin', [RolesAndPermissionsController::class, 'index'])->name('admin.roles-editor');
    Route::post('/admin/assign-permissions', [RolesAndPermissionsController::class, 'assignPermissionToRole'])->name('admin.assign-permissions');
    Route::post('/admin/revoke-permissions', [RolesAndPermissionsController::class, 'revokePermissionFromRole'])->name('admin.revoke-permissions');
    Route::post('/admin/store', [RolesAndPermissionsController::class, 'store'])->name('admin.store');
    Route::delete('/admin/destroy', [RolesAndPermissionsController::class, 'destroy'])->name('admin.destroy');

    Route::get('/roles-permissions', [PermissionController::class, 'index'])->name('roles-permissions.index');
    Route::get('/roles-permissions/create', [PermissionController::class, 'create'])->name('roles-permissions.create');
    Route::get('roles-permissions/{id}/edit', [PermissionController::class, 'edit'])->name('roles-permissions.edit');
    Route::put('roles-permissions/{id}', [PermissionController::class, 'update'])->name('roles-permissions.update');
    Route::post('/roles-permissions/store', [PermissionController::class, 'store'])->name('roles-permissions.store');
    Route::delete('/roles-permissions/{permissions}', [PermissionController::class, 'destroy'])->name('roles-permissions.destroy');

});




require __DIR__.'/auth.php';
