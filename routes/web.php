<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AcaraController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\ProgramController;

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

// Letakkan fungsi ini pada route paling atas
\Campusdigital\CampusCMS\FaturCMS::routes();

// Home
Route::get('/', [HomeController::class,'index'])->name('site.home');

// Search
Route::get('/search', [HomeController::class, 'search'])->name('site.search');

// Program
Route::get('/program', [ProgramController::class,'index'])->name('site.program.index');
Route::get('/program/{permalink}', [ProgramController::class,'detail'])->name('site.program.detail');

// Acara
Route::get('/acara', [AcaraController::class, 'index'])->name('site.acara.index');
Route::get('/acara/{permalink}', [AcaraController::class, 'detail'])->name('site.acara.detail');

// Artikel
Route::get('/artikel', [ArtikelController::class, 'index'])->name('site.artikel.index');
Route::get('/artikel/{permalink}', [ArtikelController::class, 'detail'])->name('site.artikel.detail');
Route::get('/artikel/kategori/{category}', [ArtikelController::class, 'category'])->name('site.artikel.category');
Route::get('/artikel/tag/{tag}', [ArtikelController::class, 'tag'])->name('site.artikel.tag');
//sitemap
Route::get('/seo/sitemap.xml', [ArtikelController::class, 'generate'])->name('site.artikel.sitemaps');

// Program
Route::get('/mentor', [MentorController::class, 'index'])->name('site.mentor.index');

// Halaman
Route::get('/{permalink}', [HalamanController::class,'detail'])->name('site.halaman.detail');
Route::get('/page/gallery', [HalamanController::class,'gallery'])->name('site.halaman.gallery');

