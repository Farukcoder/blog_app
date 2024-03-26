<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [UserController::class, 'index']);
Route::get('post/{id}', [UserController::class, 'single_post_view'])->name('single_post_view');
Route::get('post/category/{category_id}', [UserController::class, 'filter_by_category'])->name('filter_by_category');

Route::group(['middleware' => 'auth'], function (){
   Route::post('/posts/{id}/comment/store', [UserController::class, 'comment_store'])->name('comment_store');

   Route::get('/questions', [UserController::class, 'questions'])->name('questions');

   Route::post('/questions/store', [UserController::class, 'question_store'])->name('question_store');

   Route::delete('/question/{id}/delete', [UserController::class, 'question_delete'])->name('question_delete');

   Route::get('/question/answers/{id}', [UserController::class, 'questionAnswers'])->name('question_answers');

   Route::post('/question/answer/store/{id}', [UserController::class, 'questionAnswerStore'])->name('question_answer_store');

   Route::delete('/question/answer/{id}/delete', [UserController::class, 'questionAnswerDelete'])->name('question_answer_delete');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.login')->middleware('guest:admin');

Route::post('/admin/login/store', [AuthenticatedSessionController::class, 'store'])->name('admin.login.store');

Route::group(['middleware' => 'admin'], function() {

    Route::get('/admin', [HomeController::class, 'index'])->name('admin.dashboard');

    Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');

    Route::resource('/admin/category', CategoryController::class);

    Route::resource('/admin/post', PostController::class);

});

