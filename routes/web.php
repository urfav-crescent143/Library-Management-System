
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Guest authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Admin-only library management routes
Route::middleware(['auth', 'admin'])->group(function () {

    // Category routes
    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::get('/categories/create', [CategoryController::class, 'create'])
        ->name('categories.create');

    Route::post('/categories', [CategoryController::class, 'store'])
        ->name('categories.store');

    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
        ->name('categories.edit');

    Route::put('/categories/{category}', [CategoryController::class, 'update'])
        ->name('categories.update');

    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');


    // Author routes
    Route::get('/authors', [AuthorController::class, 'index'])
        ->name('authors.index');

    Route::get('/authors/create', [AuthorController::class, 'create'])
        ->name('authors.create');

    Route::post('/authors', [AuthorController::class, 'store'])
        ->name('authors.store');

    Route::get('/authors/{author}/edit', [AuthorController::class, 'edit'])
        ->name('authors.edit');

    Route::put('/authors/{author}', [AuthorController::class, 'update'])
        ->name('authors.update');


    // Book routes
    Route::get('/books', [BookController::class, 'index'])
        ->name('books.index');

    Route::get('/books/create', [BookController::class, 'create'])
        ->name('books.create');

    Route::post('/books', [BookController::class, 'store'])
        ->name('books.store');

    Route::get('/books/{book}/edit', [BookController::class, 'edit'])
        ->name('books.edit');

    Route::put('/books/{book}', [BookController::class, 'update'])
        ->name('books.update');


    // Member routes
    Route::get('/members', [MemberController::class, 'index'])
        ->name('members.index');

    Route::get('/members/create', [MemberController::class, 'create'])
        ->name('members.create');

    Route::post('/members', [MemberController::class, 'store'])
        ->name('members.store');

    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])
        ->name('members.edit');

    Route::put('/members/{member}', [MemberController::class, 'update'])
        ->name('members.update');


    // Borrowing routes
    Route::resource('borrowings', BorrowingController::class);


    // Return routes
    Route::get('/returns', [ReturnController::class, 'index'])
        ->name('returns.index');

    Route::put('/returns/{borrowing}', [ReturnController::class, 'update'])
        ->name('returns.update');


    // Fine routes
    Route::get('/fines', [FineController::class, 'index'])
        ->name('fines.index');

    Route::put('/fines/{fine}/pay', [FineController::class, 'pay'])
        ->name('fines.pay');


    // Reservation routes
    Route::get('/reservations', [ReservationController::class, 'index'])
        ->name('reservations.index');

    Route::get('/reservations/create', [ReservationController::class, 'create'])
        ->name('reservations.create');

    Route::post('/reservations', [ReservationController::class, 'store'])
        ->name('reservations.store');

    Route::patch('/reservations/{reservation}/fulfill', [ReservationController::class, 'fulfill'])
        ->name('reservations.fulfill');


    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboards.index');


    // Reports route
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

});
