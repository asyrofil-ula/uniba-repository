<?php

use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\Categories;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\Documents;
use App\Http\Controllers\Admin\DocumentTypeController;
use App\Http\Controllers\Admin\Faculties;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\DocumentController;
use Illuminate\Support\Facades\Route;




// landing page
Route::get('/landing', function () {
    return view('landing.app');
});
// result
Route::get('/result', function () {
    return view('landing.result');
});
// item detail
Route::get('/detail', function () {
    return view('landing.item-detail');
});

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/search', [LandingController::class, 'search'])->name('search');

Route::get('/semua-dokumen', [LandingController::class, 'allDocuments'])->name('all.documents');

Route::get('/detail/{document}', [LandingController::class, 'show'])->name('document.show');

Route::get('/download/{document}', [LandingController::class, 'download'])->name('document.download');

Route::get('/jelajahi/fakultas', [LandingController::class, 'exploreByFaculty'])->name('explore.faculties');
Route::get('/jelajahi/tahun', [LandingController::class, 'exploreByYear'])->name('explore.years');
Route::get('/jelajahi/penulis', [LandingController::class, 'exploreByAuthor'])->name('explore.authors');
Route::get('/jelajahi/jenis-dokumen', [LandingController::class, 'exploreByType'])->name('explore.types');

Route::get('/jelajahi/fakultas/{id}',[LandingController::class, 'fakultas_detail'])->name('faculty.documents');
Route::get('/jelajahi/tahun/{year}',[LandingController::class, 'tahun_detail'])->name('year.documents');
Route::get('/jelajahi/penulis/{id}',[LandingController::class, 'penulis_detail'])->name('author.documents');
Route::get('/jelajahi/jenis-dokumen/{id}',[LandingController::class, 'jenis_dokumen_detail'])->name('type.documents');


Route::get('/faq', fn() => view('landing.faq-bantuan'))->name('faq');
Route::get('/tentang', fn() => view('landing.tentang'))->name('about');


    // admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/home', [Dashboard::class, 'index'])->name('admin.home');
    Route::get('/api/chart-data', [Dashboard::class, 'getChartData']);


    // kategori
    Route::get('/admin/categories', [Categories::class, 'index'])->name('admin.categories');
    Route::post('/admin/categories/store', [Categories::class, 'store'])->name('admin.categories.store');
    Route::post('/admin/categories/update/{id}',[Categories::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}',[Categories::class, 'destroy'])->name('admin.categories.destroy');

    //fakultas
    Route::get('admin/faculties', [Faculties::class, 'index'])->name('admin.faculties');
    Route::post('/admin/faculties/store', [Faculties::class, 'store'])->name('admin.faculties.store');
    Route::post('/admin/faculties/update/{id}',[Faculties::class, 'update'])->name('admin.faculties.update');
    Route::delete('/admin/faculties/{id}',[Faculties::class, 'destroy'])->name('admin.faculties.destroy');

    // department
    Route::get('/admin/departments', [DepartmentController::class, 'index'])->name('admin.departments');
    Route::post('/admin/departments/store', [DepartmentController::class, 'store'])->name('admin.departments.store');
    Route::post('/admin/departments/update/{id}',[DepartmentController::class, 'update'])->name('admin.departments.update');
    Route::delete('/admin/departments/{id}',[DepartmentController::class, 'destroy'])->name('admin.departments.destroy');

    // documenttype
    Route::get('/admin/documenttypes', [DocumentTypeController::class, 'index'])->name('admin.documenttypes');
    Route::post('/admin/documenttypes/store', [DocumentTypeController::class, 'store'])->name('admin.documenttypes.store');
    Route::put('/admin/documenttypes/update/{id}',[DocumentTypeController::class, 'update'])->name('admin.documenttypes.update');
    Route::delete('/admin/documenttypes/{id}',[DocumentTypeController::class, 'destroy'])->name('admin.documenttypes.destroy');

    //dokumen
    Route::get('/admin/documents', [Documents::class, 'index'])->name('admin.documents');
    Route::post('/admin/documents/store', [Documents::class, 'store'])->name('admin.documents.store');
    Route::get('/admin/documents/{id}',[Documents::class, 'show'])->name('admin.documents.show');
    Route::post('/admin/documents/update/{id}',[Documents::class, 'update'])->name('admin.documents.update');
    Route::delete('/admin/documents/{id}',[Documents::class, 'destroy'])->name('admin.documents.destroy');

    // review document
    Route::post('/admin/documents/review/{id}',[Documents::class, 'review'])->name('admin.documents.review');

    // download document
    Route::get('/admin/documents/download/{id}',[Documents::class, 'download'])->name('admin.documents.download');

    // user
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{id}',[UserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/edit/{id}',[UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/update/{id}',[UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}',[UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::post('/import', [UserController::class, 'import'])->name('admin.users.import');
    Route::get('/export', [UserController::class, 'export'])->name('admin.users.export');
    Route::get('/export-template', [UserController::class, 'exportTemplate'])->name('admin.users.export-template');

});


Route::middleware(['auth', 'role:mahasiswa,dosen'])->group(function () {
    // api
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    // document
    Route::get('/document', [DocumentController::class, 'index'])->name('user.documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('user.documents.create');
    Route::post('/documents/store', [DocumentController::class, 'store'])->name('user.documents.store');
    Route::get('/documents/{id}',[DocumentController::class, 'show'])->name('user.documents.show');
    Route::get('/documents/edit/{document}',[DocumentController::class, 'edit'])->name('user.documents.edit');
    Route::put('/documents/update/{id}',[DocumentController::class, 'update'])->name('user.documents.update');
    Route::delete('/documents/{id}',[DocumentController::class, 'destroy'])->name('user.documents.destroy');

    // search
    // Route::get('/search', [DocumentController::class, 'search'])->name('search');
//
    // profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update/{id}',[ProfileController::class, 'update'])->name('profile.update');

}) ;
Route::get('api/faculties/{id}/departments', [DocumentController::class, 'departments']);


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
