<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JenisKegiatanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\AnggotaKegiatanController;
use App\Http\Controllers\ProfileDosenController;
use App\Http\Controllers\ProgressKegiatanController;
use App\Http\Controllers\DashboardController;


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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', [WelcomeController::class, 'index']);
Route::get('login', [AuthController::class, 'login'])->name('login');


Route::get('/jeniskegiatan', [JenisKegiatanController::class, 'index']);

Route::get('/', [DashboardController::class, 'index']);

Route::get('/user', [UserController::class, 'index']);          //menampilkan halaman awal user
Route::post('/user/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
Route::get('/user/create', [UserController::class, 'create']);   //menampilkan hal form tambah user 
Route::post('/user', [UserController::class, 'store']);
Route::get('/user/create_ajax', [UserController::class, 'create_ajax']);   
Route::post('/user/ajax', [UserController::class, 'store_ajax']);           
Route::get('/user/{id}', [UserController::class, 'show']);       //menampilkan detail user
Route::get('/user/{id}/show_ajax', [UserController::class, 'show_ajax']); 
Route::get('/user/{id}/edit', [UserController::class, 'edit']);  //menampilkan hal form edit user
Route::put('/user/{id}', [UserController::class, 'update']);     //menyimpan perubahan data user
Route::get('/user/{id}/edit_ajax', [UserController::class, 'edit_ajax']);  //menampilkan hal form edit user
Route::put('/user/{id}/update_ajax', [UserController::class, 'update_ajax']);     //menyimpan perubahan data user
Route::get('/user/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
Route::delete('/user/{id}/delete_ajax', [UserController::class, 'delete_ajax']);  //Menyimpan perubahan data user
Route::delete('/user/{id}', [UserController::class, 'destroy']); //menghapus data user
Route::get('/user/import', [UserController::class, 'import']); //ajax form upload excel
Route::post('/user/import_ajax', [UserController::class, 'import_ajax']);
Route::get('/user/export_excel', [UserController::class, 'export_excel']); //export excel
Route::get('/user/export_pdf', [UserController::class, 'export_pdf']);

Route::get('/level', [LevelController::class, 'index']);
        //Route::get('/', [LevelController::class, 'index']);          //menampilkan halaman awal user
        Route::post('/level/list', [LevelController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
        Route::get('/level/create', [LevelController::class, 'create']);   //menampilkan hal form tambah user 
        Route::post('/level', [LevelController::class, 'store']);         //menyimpan data user baru
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);   
        Route::post('/level/ajax', [LevelController::class, 'store_ajax']);  
        Route::get('/level/{id}', [LevelController::class, 'show']);       //menampilkan detail user
        Route::get('/level/{id}/show_ajax', [LevelController::class, 'show_ajax']); 
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']);  //menampilkan hal form edit user
        Route::put('/level/{id}', [LevelController::class, 'update']);     //menyimpan perubahan data user
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);  //menampilkan hal form edit user
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']);     //menyimpan perubahan data user
        Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //Menampilkan halaman form edit user Ajax
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);  //Menyimpan perubahan data user
        Route::delete('/level/{id}', [LevelController::class, 'destroy']); //menghapus data user
        Route::get('/level/import', [LevelController::class, 'import']); //ajax form upload excel
        Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']);
        Route::get('/level/export_excel', [LevelController::class, 'export_excel']); //export excel
        Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']);

        Route::get('/kegiatan', [KegiatanController::class, 'index']);
        Route::post('/kegiatan/list', [KegiatanController::class, 'list']);
        Route::get('/kegiatan/create', [KegiatanController::class, 'create']);
        Route::post('/kegiatan', [KegiatanController::class, 'store']);
        Route::get('/kegiatan/create_ajax', [KegiatanController::class, 'create_ajax']);
        Route::post('/kegiatan/ajax', [KegiatanController::class, 'store_ajax']);  
        Route::get('/kegiatan/{id}', [KegiatanController::class, 'show']);
        Route::get('/kegiatan/{id}/show_ajax', [KegiatanController::class, 'show_ajax']); 
        Route::get('/kegiatan/{id}/edit', [KegiatanController::class, 'edit']);
        Route::put('/kegiatan/{id}', [KegiatanController::class, 'update']);
        Route::get('/kegiatan/{id}/edit_ajax', [KegiatanController::class, 'edit_ajax']);  
        Route::put('/kegiatan/{id}/update_ajax', [KegiatanController::class, 'update_ajax']);     
        Route::get('/kegiatan/{id}/delete_ajax', [KegiatanController::class, 'confirm_ajax']); 
        Route::delete('/kegiatan/{id}/delete_ajax', [KegiatanController::class, 'delete_ajax']);
        Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy']);
        Route::get('/kegiatan/import', [KegiatanController::class, 'import']); //ajax form upload excel
        Route::post('/kegiatan/import_ajax', [KegiatanController::class, 'import_ajax']);
        Route::get('/kegiatan/export_excel', [KegiatanController::class, 'export_excel']); //export excel
        Route::get('/kegiatan/export_pdf', [KegiatanController::class, 'export_pdf']);

        Route::get('/jeniskegiatan', [JenisKegiatanController::class, 'index']);
        Route::post('/jeniskegiatan/list', [JenisKegiatanController::class, 'list']);
        Route::get('/jeniskegiatan/create', [JenisKegiatanController::class, 'create']);
        Route::post('/jeniskegiatan', [JenisKegiatanController::class, 'store']);
        Route::get('/jeniskegiatan/create_ajax', [JenisKegiatanController::class, 'create_ajax']);
        Route::post('/jeniskegiatan/ajax', [JenisKegiatanController::class, 'store_ajax']);  
        Route::get('/jeniskegiatan/{id}', [JenisKegiatanController::class, 'show']);
        Route::get('/jeniskegiatan/{id}/show_ajax', [JenisKegiatanController::class, 'show_ajax']);
        Route::get('/jeniskegiatan/{id}/edit', [JenisKegiatanController::class, 'edit']);
        Route::put('/jeniskegiatan/{id}', [JenisKegiatanController::class, 'update']);
        Route::get('/jeniskegiatan/{id}/edit_ajax', [JenisKegiatanController::class, 'edit_ajax']);  
        Route::put('/jeniskegiatan/{id}/update_ajax', [JenisKegiatanController::class, 'update_ajax']);     
        Route::get('/jeniskegiatan/{id}/delete_ajax', [JenisKegiatanController::class, 'confirm_ajax']); 
        Route::delete('/jeniskegiatan/{id}/delete_ajax', [JenisKegiatanController::class, 'delete_ajax']);
        Route::delete('/jeniskegiatan/{id}', [JenisKegiatanController::class, 'destroy']);
        Route::get('/jeniskegiatan/import', [JenisKegiatanController::class, 'import']); //ajax form upload excel
        Route::post('/jeniskegiatan/import_ajax', [JenisKegiatanController::class, 'import_ajax']);
        Route::get('/jeniskegiatan/export_excel', [JenisKegiatanController::class, 'export_excel']); //export excel
        Route::get('/jeniskegiatan/export_pdf', [JenisKegiatanController::class, 'export_pdf']);


        Route::get('/jabatan', [JabatanController::class, 'index']);
        Route::post('/jabatan/list', [JabatanController::class, 'list']);
        Route::get('/jabatan/create', [JabatanController::class, 'create']);
        Route::post('/jabatan', [JabatanController::class, 'store']);
        Route::get('/jabatan/create_ajax', [JabatanController::class, 'create_ajax']);
        Route::post('/jabatan/ajax', [JabatanController::class, 'store_ajax']);
        Route::get('/jabatan/{id}', [JabatanController::class, 'show']);
        Route::get('/jabatan/{id}/show_ajax', [JabatanController::class, 'show_ajax']);
        Route::get('/jabatan/{id}/edit', [JabatanController::class, 'edit']);
        Route::put('/jabatan/{id}', [JabatanController::class, 'update']);
        Route::get('/jabatan/{id}/edit_ajax', [JabatanController::class, 'edit_ajax']);
        Route::put('/jabatan/{id}/update_ajax', [JabatanController::class, 'update_ajax']);
        Route::get('/jabatan/{id}/delete_ajax', [JabatanController::class, 'confirm_ajax']);
        Route::delete('/jabatan/{id}/delete_ajax', [JabatanController::class, 'delete_ajax']);
        Route::delete('/jabatan/{id}', [JabatanController::class, 'destroy']);
        Route::get('/jabatan/import', [JabatanController::class, 'import']); // ajax form upload excel
        Route::post('/jabatan/import_ajax', [JabatanController::class, 'import_ajax']);
        Route::get('/jabatan/export_excel', [JabatanController::class, 'export_excel']); // export to excel
        Route::get('/jabatan/export_pdf', [JabatanController::class, 'export_pdf']);
        
        Route::get('/anggotakegiatan', [AnggotaKegiatanController::class, 'index']); 
        Route::post('/anggotakegiatan/list', [AnggotaKegiatanController::class, 'list']);
        Route::get('/anggotakegiatan/create', [AnggotaKegiatanController::class, 'create']);
        Route::post('/anggotakegiatan', [AnggotaKegiatanController::class, 'store']);
        Route::get('/anggotakegiatan/create_ajax', [AnggotaKegiatanController::class, 'create_ajax']);
        Route::post('/anggotakegiatan/ajax', [AnggotaKegiatanController::class, 'store_ajax']);
        Route::get('/anggotakegiatan/{id}', [AnggotaKegiatanController::class, 'show']);
        Route::get('/anggotakegiatan/{id}/show_ajax', [AnggotaKegiatanController::class, 'show_ajax']);
        Route::get('/anggotakegiatan/{id}/edit', [AnggotaKegiatanController::class, 'edit']);
        Route::put('/anggotakegiatan/{id}', [AnggotaKegiatanController::class, 'update']);
        Route::get('/anggotakegiatan/{id}/edit_ajax', [AnggotaKegiatanController::class, 'edit_ajax']);
        Route::put('/anggotakegiatan/{id}/update_ajax', [AnggotaKegiatanController::class, 'update_ajax']);
        Route::get('/anggotakegiatan/{id}/delete_ajax', [AnggotaKegiatanController::class, 'confirm_ajax']);
        Route::delete('/anggotakegiatan/{id}/delete_ajax', [AnggotaKegiatanController::class, 'delete_ajax']);
        Route::delete('/anggotakegiatan/{id}', [AnggotaKegiatanController::class, 'destroy']);
        Route::get('/anggotakegiatan/import', [AnggotaKegiatanController::class, 'import']); // ajax form upload excel
        Route::post('/anggotakegiatan/import_ajax', [AnggotaKegiatanController::class, 'import_ajax']);
        Route::get('/anggotakegiatan/export_excel', [AnggotaKegiatanController::class, 'export_excel']); // export to excel
        Route::get('/anggotakegiatan/export_pdf', [AnggotaKegiatanController::class, 'export_pdf']);

        Route::get('/profiledosen', [ProfileDosenController::class, 'index']);
        Route::post('/profiledosen/list', [ProfileDosenController::class, 'list']);
        Route::get('/profiledosen/create', [ProfileDosenController::class, 'create']);
        Route::post('/profiledosen', [ProfileDosenController::class, 'store']);
        Route::get('/profiledosen/create_ajax', [ProfileDosenController::class, 'create_ajax']);
        Route::post('/profiledosen/ajax', [ProfileDosenController::class, 'store_ajax']);
        Route::get('/profiledosen/{id}', [ProfileDosenController::class, 'show']);
        Route::get('/profiledosen/{id}/show_ajax', [ProfileDosenController::class, 'show_ajax']);
        Route::get('/profiledosen/{id}/edit', [ProfileDosenController::class, 'edit']);
        Route::put('/profiledosen/{id}', [ProfileDosenController::class, 'update']);
        Route::get('/profiledosen/{id}/edit_ajax', [ProfileDosenController::class, 'edit_ajax']);
        Route::put('/profiledosen/{id}/update_ajax', [ProfileDosenController::class, 'update_ajax']);
        Route::get('/profiledosen/{id}/delete_ajax', [ProfileDosenController::class, 'confirm_ajax']);
        Route::delete('/profiledosen/{id}/delete_ajax', [ProfileDosenController::class, 'delete_ajax']);
        Route::delete('/profiledosen/{id}', [ProfileDosenController::class, 'destroy']);
        Route::get('/profiledosen/import', [ProfileDosenController::class, 'import']); // ajax form upload excel
        Route::post('/profiledosen/import_ajax', [ProfileDosenController::class, 'import_ajax']);
        Route::get('/profiledosen/export_excel', [ProfileDosenController::class, 'export_excel']); // export to excel
        Route::get('/profiledosen/export_pdf', [ProfileDosenController::class, 'export_pdf']); // export to pdf

        Route::get('/progresskegiatan', [ProgressKegiatanController::class, 'index']);
        Route::get('/progresskegiatan/list', [ProgressKegiatanController::class, 'list']);
        Route::get('/progresskegiatan/create', [ProgressKegiatanController::class, 'create']);
        // Route::post('/progresskegiatan', [ProgressKegiatanController::class, 'store']);
        Route::get('/progresskegiatan/create_ajax', [ProgressKegiatanController::class, 'create_ajax']);
        // Route::post('/progresskegiatan/ajax', [ProgressKegiatanController::class, 'store_ajax']);
        Route::get('/progresskegiatan/{id}', [ProgressKegiatanController::class, 'show']);
        Route::get('/progresskegiatan/{id}/show_ajax', [ProgressKegiatanController::class, 'show_ajax']);
        Route::get('/progresskegiatan/{id}/edit', [ProgressKegiatanController::class, 'edit']);
        Route::put('/progresskegiatan/{id}', [ProgressKegiatanController::class, 'update']);
        Route::get('/progresskegiatan/{id}/edit_ajax', [ProgressKegiatanController::class, 'edit_ajax']);
        Route::put('/progresskegiatan/{id}/update_ajax', [ProgressKegiatanController::class, 'update_ajax']);
        Route::get('/progresskegiatan/{id}/delete_ajax', [ProgressKegiatanController::class, 'confirm_ajax']);
        Route::delete('/progresskegiatan/{id}/delete_ajax', [ProgressKegiatanController::class, 'delete_ajax']);
        Route::delete('/progresskegiatan/{id}', [ProgressKegiatanController::class, 'destroy']);
        Route::get('/progresskegiatan/import', [ProgressKegiatanController::class, 'import']); // ajax form upload excel
        Route::post('/progresskegiatan/import_ajax', [ProgressKegiatanController::class, 'import_ajax']);
        Route::get('/progresskegiatan/export_excel', [ProgressKegiatanController::class, 'export_excel']); // export to excel
        Route::get('/progresskegiatan/export_pdf', [ProgressKegiatanController::class, 'export_pdf']); // export to pdf


