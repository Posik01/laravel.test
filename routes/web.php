<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MyPlaceController;
use App\Http\Controllers\Post\IndexController;
use App\Http\Controllers\Admin\Post\IndexAdminController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Post\StoreController;
use App\Http\Controllers\Post\CreateController;
use App\Http\Controllers\Post\EditController;
use App\Http\Controllers\Post\DestroyController;
use App\Http\Controllers\Post\UpdateController;
use App\Http\Controllers\Post\ShowController;
//use App\Http\Controllers\PostController;

use GuzzleHttp\Promise\Create;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/posts', [IndexController::class, '__invoke'])->name('post.index');
Route::get('/my-country', [PostController::class]);
Route::get('/posts/create', [CreateController::class, '__invoke'])->name('post.create');

Route::post('/posts', [StoreController::class, '__invoke'])->name('post.store');
Route::get('/posts/{post}', [ShowController::class, '__invoke'])->name('post.show');
Route::get('/posts/{post}/edit', [EditController::class, '__invoke'])->name('post.edit');
Route::patch('/posts/{post}', [UpdateController::class, '__invoke'])->name('post.update');
Route::delete('/posts/{post}', [DestroyController::class, '__invoke'])->name('post.delete');

Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::group(['namespace' => 'post'], function () {
        Route::get('/post', [IndexAdminController::class, '__invoke'])->name('admin.post.index');
    });
});

Route::get('/posts/update', [PostController::class, 'update']);
Route::get('/posts/delete', [PostController::class, 'delete']);
Route::get('/posts/restore', [PostController::class, 'restore']);
Route::get('/posts/first_or_create', [PostController::class, 'firstOrCreate']);
Route::get('/posts/update_or_create', [PostController::class, 'updateOrCreate']);

Route::get('/main', [MainController::class, 'index'])->name('main.index');
Route::get('/contacts', [ContactsController::class, 'index'])->name('contact.index');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



require __DIR__ . '/auth.php';
