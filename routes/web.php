<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Models\Album;
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

Route::get('/', function () {
    return view('welcome');
});

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::middleware('auth')->name('admin.')->group(function () {
    Route::get('/dashboard', [AlbumController::class, 'index'])->name('albums.index');
    Route::post('/dashboard', [AlbumController::class, 'store'])->name('albums.store');
    Route::put('/dashboard/{album}', [AlbumController::class, 'update'])->name('albums.update');
    Route::delete('/dashboard/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');

    /* Route::resource('/dashboard', AlbumController::class); */


    Route::get('/dashboard/files/{album}', [FileController::class, 'albumPage'])->name('files.albumPage');
    Route::post('/dashboard/files', [FileController::class, 'store'])->name('files.store');
    Route::get('/dashboard/files/album/{file}', [FileController::class, 'show'])->name('files.show');
    Route::put('/dashboard/files/{file}', [FileController::class, 'update'])->name('files.update');
    Route::delete('/dashboard/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::post('/dashboard/files/destroyAll/{album}', [FileController::class, 'destroyAll'])->name('files.destroyAll');
    Route::post('/dashboard/files/downloadFile/{file}', [FileController::class, 'downloadFile'])->name('files.downloadFile');
  
    Route::post('/dashboard/files/upload', [DropzoneController::class, 'store'])->name('dropzone.store');
});