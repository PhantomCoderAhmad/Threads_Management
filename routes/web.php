<?php

use Illuminate\Support\Facades\Route;

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
$prefix = config('forum.web.route_prefixes');
$authMiddleware = config('forum.web.router.auth_middleware');

// Route::get('/', function () {
//     return view('dashboard');
// });
Route::get('/', [App\Http\Controllers\BlogController::class, 'index']);
Route::post('/blog', [App\Http\Controllers\BlogController::class, 'store'])->name('blog');
Route::get('/search', [App\Http\Controllers\BlogController::class, 'index'])->name('search');
Route::get('/blog/category', [App\Http\Controllers\BlogController::class, 'index'])->name('blog_category');
Route::get('/blog/detail'.'/{slug}', [App\Http\Controllers\BlogdetailController::class, 'index']);
Route::get('/edit/blog', [App\Http\Controllers\BlogController::class, 'edit']);
Route::post('/blogupdate', [App\Http\Controllers\BlogController::class, 'update'])->name('blogupdate');
Route::match(['get','post'],'/delete/post'.'/{id}', [App\Http\Controllers\BlogController::class, 'destroy'])->name('blog.delete');

Route::group(['middleware' => ['admin']], function () {
    Route::get('/manage/blog', [App\Http\Controllers\BlogdetailController::class, 'manageblog']);
    Route::get('/manage/users', [App\Http\Controllers\UserController::class, 'index']);
    Route::post('/userupdate', [App\Http\Controllers\UserController::class, 'update'])->name('userupdate');
    Route::match(['get','post'],'/delete/user'.'/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.delete');
    Route::post('/createuser', [App\Http\Controllers\UserController::class, 'store'])->name('createuser');


 });

// comments
Route::post('/postcomment', [App\Http\Controllers\CommentController::class, 'store'])->name('postcomment');
Route::match(['get','post'],'/delete/comment'.'/{id}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comment.delete');
Route::get('/edit/comment', [App\Http\Controllers\CommentController::class, 'edit']);
Route::post('/commentupdate', [App\Http\Controllers\CommentController::class, 'update'])->name('commentupdate');
Route::get('/checkauth', [App\Http\Controllers\CommentController::class, 'checkauth']);

// Replies
Route::post('/postreply', [App\Http\Controllers\ReplyController::class, 'store'])->name('postreply');
Route::get('/edit/reply', [App\Http\Controllers\ReplyController::class, 'edit']);
Route::post('/replyupdate', [App\Http\Controllers\ReplyController::class, 'update'])->name('replyupdate');
Route::match(['get','post'],'/delete/reply'.'/{id}', [App\Http\Controllers\ReplyController::class, 'destroy'])->name('reply.delete');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');



require __DIR__.'/auth.php';

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Auth::routes();
//
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/forum', [App\Http\Controllers\ForumController::class, 'forumIndex'])->name('forum.index');

Route::group(['prefix' => 'forum'], function () use ($prefix, $authMiddleware) {
    
    Route::post($prefix['category'].'/create', [App\Http\Controllers\ForumController::class, 'store'])->name('forum.category.store');
    Route::patch('/', [App\Http\Controllers\ForumController::class, 'update'])->middleware($authMiddleware)->name('forum.category.update');
});

   