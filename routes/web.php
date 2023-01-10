<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware( ['admin'])->group(function () {
    Route::post('/api/books', [BookController::class, 'store']);
    Route::get('/api/books',[BookController::class, 'index']);
Route::put('/api/books/{id}', [BookController::class, 'update']);
Route::delete('/api/books/{id}', [BookController::class, 'destroy']);
Route::get('/copy/new', [CopyController::class, 'newView']);
Route::get('/copy/edit/{id}', [CopyController::class, 'editView']);
Route::get('/copy/list', [CopyController::class, 'listView']); 

//user   
Route::apiResource('/api/users', UserController::class);
Route::patch('/api/users/password/{id}', [UserController::class, 'updatePassword']);
//queries
//user lendings
Route::get('/api/user_lendings', [LendingController::class, 'userLendingsList']);
Route::get('/api/user_lendings_count', [LendingController::class, 'userLendingsCount']);
//csak a tesztelés miatt van "kint"
Route::patch('/api/users/password/{id}', [UserController::class, 'updatePassword']);
Route::get('/api/rperuser', [ReservationController::class, 'reservations_per_user']);
//feladatok:
Route::get('/api/bookabc',[BookController::class, 'bookabc']);
Route::get('/api/morea/{number}',[BookController::class, 'morea']);
Route::get('/api/ba',[BookController::class, 'ba']);
Route::get('/api/thrday',[ReservationController::class, 'thrday']);
Route::post('/api/lendings', [LendingController::class, 'store']);
});

Route::middleware(['librarian'])->group(function (){

    Route::get('/api/lendings', [LendingController::class, 'index']); 
    Route::get('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'show']);
    Route::put('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);
    Route::patch('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);
    Route::post('/api/lendings', [LendingController::class, 'store']);
    Route::delete('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'destroy']);
    Route::get('/api/book_copies_count/{title}',[CopyController::class, 'bookCopyCount']);
    Route::get('/api/hardcoveredCopies/{hardcovered}',[CopyController::class, 'hardcoveredCopies']);
    Route::get('/api/givenYear/{year}', [CopyController::class, 'givenYear']);
    Route::get('/api/inStock/{status}',[CopyController::class, 'inStock']);
    Route::get('/api/checkBook/{book_id}/{year}',[CopyController::class, 'bookCheck']);
    Route::get('/api/dataDB/{book_id}',[CopyController::class, 'lendingsDataDB']);
    Route::get('/api/dataWT/{book_id}',[CopyController::class,'lendingsDataWT']);
    Route::get('/api/rperuser', [ReservationController::class, 'reservations_per_user']);
    Route::get('/api/mybooks', [ReservationController::class, 'mybooks']);
});

Route::middleware('auth.basic')->group(function () {
    Route::apiResource('/api/copies', CopyController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/api/bringBack/{copy}/{start}',[LendingController::class,'bringBack']);
});

Route::get('file_upload', [FileController   ::class, 'index']);
Route::post('file_upload', [FileController::class, 'store'])->name('file.store');
Route::get('/api/rvuser', [ReservationController::class, 'reservUsers']);
Route::delete('/api/derev',[ReservationController::class, 'deleteOldOnes']);

require __DIR__.'/auth.php';


//copies
//Route::apiResource('/api/copies', CopyController::class);
//queries
//Route::get('/api/book_copies/{title}', [BookController::class, 'bookCopies']);
//view - copy
