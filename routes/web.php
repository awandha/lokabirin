<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminTableController;
use App\Http\Controllers\AdminReportController;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Admin\MenuController;

// Test refactor code
Route::get('/test-original', function () {
    // Enable query log
    DB::enableQueryLog();

    $posts = Post::limit(50)->get();

    foreach ($posts as $post) {
        echo "Author: {$post->user->name} / Title: {$post->title} / Comments: {$post->comments->count()} <br>";
    }

    // Dump query log ke storage/logs/laravel.log
    Log::info('Query Log:', DB::getQueryLog());
});

Route::get('/test-refactor', function () {
    // Enable query log
    DB::enableQueryLog();

    $posts = Post::with(['user', 'comments'])->limit(50)->get();

    foreach ($posts as $post) {
        echo "Author: {$post->user->name} / Title: {$post->title} / Comments: {$post->comments->count()} <br>";
    }

    // Dump query log ke storage/logs/laravel.log
    Log::info('Query Log:', DB::getQueryLog());
});

// End test refactor

Route::get('/', function () {
    return view('welcome');
});

Route::get('/order/{table_code}', function ($table_code) {
    return view('customer.menu', [
        'table' => \App\Models\Table::where('table_code', $table_code)->firstOrFail(),
    ]);
});
// Route::get('/order/{table_code}', [CustomerOrderController::class, 'showMenu']);
Route::post('/order/{table_code}', [CustomerOrderController::class, 'placeOrder']);
// Thank you page after placing an order
Route::get('/order/{table_code}/thank-you', function ($table_code) {
    $table = \App\Models\Table::where('table_code', $table_code)->firstOrFail();
    return view('customer.thank-you', ['table' => $table]);
})->name('customer.thank-you');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/orders', [AdminOrderController::class, 'index']);
    Route::post('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus']);
    Route::get('/admin/tables', [AdminTableController::class, 'index']);
    Route::get('/admin/tables/qr-pdf', [AdminTableController::class, 'downloadQrPdf']);
    Route::get('/admin/menu-items', function () {
        return view('admin.menu-items');
    });
    Route::get('/admin/menu', function () {
        return view('admin.menu');
    });
    Route::get('/kitchen', function () {
        return view('kitchen.index');
    });
    Route::get('/admin/reports', function () {
        return view('admin.reports');
    });
    Route::get('/admin/reports/export', [AdminReportController::class, 'export'])->name('admin.reports.export');
    Route::get('/admin/menus', [MenuController::class, 'index'])->name('admin.menus.index');
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
