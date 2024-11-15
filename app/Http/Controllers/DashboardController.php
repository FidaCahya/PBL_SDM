<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KegiatanModel;
use App\Models\ProgressKegiatanModel;
use App\Models\UserModel;

class DashboardController extends Controller
{
    public function index()
{
    $breadcrumb = (object)[
        'title' => 'Dashboard',
        'list' => ['Home', 'Dashboard']
    ];
    $page = (object)[
        'title' => 'Dashboard Kegiatan'
    ];

    $activeMenu = 'dashboard';

    // Mengambil data yang diperlukan
    $totalKegiatan = KegiatanModel::count(); // Total Kegiatan
    $totalProgramTerdaftar = KegiatanModel::distinct('nama_kegiatan')->count(); // Total Program Terdaftar
    $totalPenggunaAktif = UserModel::count(); // Total Pengguna Aktif

    $kegiatan = KegiatanModel::with('progress_kegiatan')->get(); // Pastikan untuk menggunakan relasi yang sesuai jika ada

    // Ambil 5 kegiatan terbaru
    $recentActivities = KegiatanModel::with(['progress_kegiatan' => function($query) {
        $query->orderBy('updated_at', 'desc'); // Urutkan berdasarkan updated_at
    }])->orderBy('created_at', 'desc')->take(5)->get();

     // Ambil jumlah kegiatan berdasarkan bulan dan tahun
     $monthlyData = KegiatanModel::selectRaw('YEAR(tanggal_mulai) as year, MONTH(tanggal_mulai) as month, COUNT(*) as count')
     ->groupBy('year', 'month')
     ->orderBy('year', 'asc')
     ->orderBy('month', 'asc')
     ->get();

    // Siapkan data untuk chart
    $years = []; // Inisialisasi array untuk menyimpan tahun
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $dataCounts = [];

    foreach ($monthlyData as $data) {
        // Format data untuk digunakan dalam grafik
        // Batasi jumlah kegiatan antara 1 dan 20
        $count = max(1, min($data->count, 20)); // Pastikan nilai antara 1 dan 20
        $dataCounts[$data->year][$data->month] = $count; // Mengisi jumlah kegiatan ke tahun dan bulan yang sesuai
        if (!in_array($data->year, $years)) {
            $years[] = $data->year; // Menyimpan tahun yang unik
        }
    }

    // Inisialisasi dataCounts untuk setiap tahun dan bulan
    foreach ($years as $year) {
        for ($month = 1; $month <= 12; $month++) {
            $dataCounts[$year][$month] = $dataCounts[$year][$month] ?? 0; // Jika tidak ada kegiatan, set 0
        }
    }

    return view('dashboard.index', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'activeMenu' => $activeMenu,
        'totalKegiatan' => $totalKegiatan,
        'totalProgramTerdaftar' => $totalProgramTerdaftar,
        'totalPenggunaAktif' => $totalPenggunaAktif,
        'kegiatan' => $kegiatan,
        'recentActivities' => $recentActivities,
        'dataCounts' => $dataCounts, 
        'years' => $years,
        'months' => $months, // Tambahkan variabel months ke view
    ]);
    }
    // public function index()
    // {
    //     $breadcrumb = (object)[
    //         'title' => 'Dashboard',
    //         'list' => ['Home', 'Dashboard']
    //     ];
    //     $page = (object)[
    //         'title' => 'Dashboard Kegiatan'
    //     ];

    //     $activeMenu = 'dashboard';

    //     // Mengambil data yang diperlukan
    //     $totalKegiatan = KegiatanModel::count(); // Total Kegiatan
    //     $totalProgramTerdaftar = KegiatanModel::distinct('nama_kegiatan')->count(); // Total Program Terdaftar
    //     $totalPenggunaAktif = UserModel::count(); // Total Pengguna Aktif

    //     // Ambil semua kegiatan untuk tabel
    //     $kegiatan = KegiatanModel::with('progress_kegiatan')->get(); // Pastikan untuk menggunakan relasi yang sesuai jika ada
    //     $recentActivities = KegiatanModel::orderBy('created_at', 'desc')->take(5)->get(); // Ambil 5 aktivitas terbaru
        
    //     return view('dashboard.index', [
    //         'breadcrumb' => $breadcrumb,
    //         'page' => $page,
    //         'activeMenu' => $activeMenu,
    //         'totalKegiatan' => $totalKegiatan,
    //         'totalProgramTerdaftar' => $totalProgramTerdaftar,
    //         'totalPenggunaAktif' => $totalPenggunaAktif,
    //         'kegiatan' => $kegiatan,
    //         'recentActivities' => $recentActivities, 
    //     ]);
    // }
}

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\KegiatanModel;
// use App\Models\ProgressKegiatanModel;
// use App\Models\UserModel;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         $breadcrumb = (object)[
//             'title' => 'Dashboard',
//             'list' => ['Home', 'Dashboard']
//         ];
//         $page = (object)[
//             'title' => 'Dashboard Kegiatan'
//         ];

//         $activeMenu = 'dashboard';
//         $kegiatan = KegiatanModel::all();

        
//         return view('dashboard.index', [
//             'breadcrumb' => $breadcrumb,
//             'page' => $page,
//             'activeMenu' => $activeMenu,
//             'kegiatan' => $kegiatan,
//         ]);
//     }
// }
