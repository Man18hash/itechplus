<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BusinessMessageController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\CartController   as AdminCartController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing — guests vs. logged-in business or admin
Route::get('/', [ProjectController::class, 'landingRedirect'])
     ->name('dashboard');

// Guest project browsing
Route::get('/projects',           [ProjectController::class, 'projects'])
     ->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])
     ->name('projects.show');

// Static researches page
Route::get('/researches', function () {
    return view('researches', [
        'categories' => \App\Models\Category::all(),
    ]);
})->name('researches.index');


/*
|--------------------------------------------------------------------------
| Business Guest Auth
|--------------------------------------------------------------------------
*/
Route::middleware('guest:web')->group(function () {
    Route::get('/login',     [AuthController::class, 'show'])
         ->name('login');
    Route::post('/login',    [AuthController::class, 'login'])
         ->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])
         ->name('auth.register');
});


/*
|--------------------------------------------------------------------------
| Admin Guest Auth
|--------------------------------------------------------------------------
| Must come before any auth:admin routes so /admin/login is reachable
*/
Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])
         ->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])
         ->name('admin.auth.login');
});
Route::get('/attachments/{filename}', [ChatController::class, 'downloadAttachment'])
     ->name('attachments.download');

/*
|--------------------------------------------------------------------------
| Business Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {
    // Business logout & dashboard
    Route::post('/logout', [AuthController::class, 'logout'])
         ->name('auth.logout');
    Route::get('/home',    [ProjectController::class, 'homeView'])
         ->name('home');

    // Cart / Quotation
    Route::post  ('/cart/{project}',         [CartController::class, 'add'])
         ->name('cart.add');
    Route::get   ('/cart',                   [CartController::class, 'index'])
         ->name('cart.index');
    Route::delete('/cart/{item}',            [CartController::class, 'remove'])
         ->name('cart.remove');
    Route::patch ('/cart/{cartItem}/status', [CartController::class, 'updateStatus'])
         ->name('cart.updateStatus');

    // Profile updates
    Route::post('/profile', [AuthController::class, 'updateProfile'])
         ->name('profile.update');

    Route::patch('/profile-info', [AuthController::class, 'updateInfo'])
         ->name('profile.info');


    // Business Message Threads & Chat
    Route::get('/messages',                     [BusinessMessageController::class, 'index'])
         ->name('messages');
    Route::get('/messages/{cartItem}/chat',     [ChatController::class,             'index'])
         ->name('messages.chat');
    Route::get('/messages/{cartItem}/messages', [ChatController::class,             'fetch'])
         ->name('messages.fetch');
    Route::post('/messages/{cartItem}/messages',[ChatController::class,             'store'])
         ->name('messages.store');
});


/*
|--------------------------------------------------------------------------
| Admin Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
     ->middleware('auth:admin')
     ->name('admin.')
     ->group(function () {
         // Admin home & dashboard
         Route::get('/',          [AdminAuthController::class,    'home'])
              ->name('home');
         Route::get('/dashboard', [AdminDashboardController::class,'index'])
              ->name('dashboard');

         // Admin Message Threads & Chat
         Route::get('/messages',                     [AdminMessageController::class,'index'])
              ->name('messages');
         Route::get('/messages/{cartItem}/chat',     [ChatController::class,         'index'])
              ->name('messages.chat');
         Route::get('/messages/{cartItem}/messages', [ChatController::class,         'fetch'])
              ->name('messages.fetch');
         Route::post('/messages/{cartItem}/messages',[ChatController::class,         'store'])
              ->name('messages.store');

         // Admin Cart listing & status-update
         Route::get  ('/cart',            [AdminCartController::class, 'index'])
              ->name('cart');
         Route::patch('/cart/{cartItem}', [AdminCartController::class, 'update'])
              ->name('cart.update');

         // Admin Projects CRUD
         Route::resource('projects', AdminProjectController::class)
              ->only(['index','store','update','destroy'])
              ->names([
                  'index'   => 'projects',
                  'store'   => 'projects.store',
                  'update'  => 'projects.update',
                  'destroy' => 'projects.destroy',
              ]);

         // Admin logout
         Route::post('/logout', [AdminAuthController::class, 'logout'])
              ->name('logout');
     });
     use App\Http\Controllers\Admin\DashboardController;

     Route::prefix('admin')
          ->name('admin.')
          ->middleware(['auth', 'admin'])  // adjust as needed
          ->group(function() {
              Route::get('dashboard', [DashboardController::class, 'index'])
                   ->name('dashboard');
          });
          Route::get('/admin/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])
          ->name('admin.home');
          Route::get('/attachments/{filename}', [ChatController::class, 'downloadAttachment'])
          ->name('attachments.download');
     
     