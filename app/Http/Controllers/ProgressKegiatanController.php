<?php

namespace App\Http\Controllers;

use App\Models\ProgressKegiatanModel;
use App\Models\KegiatanModel;
use App\Models\AnggotaKegiatanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProgressKegiatanController extends Controller
{
    // Menampilkan data progress kegiatan
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Progress Kegiatan',
            'list' => ['Home', 'Kegiatan', 'Progress']
        ];
        $page = (object)[
            'title' => 'Daftar Progress Kegiatan'
        ];

        $activeMenu = 'progress';
        $kegiatan = KegiatanModel::all();

        return view('progress.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kegiatan' => $kegiatan,
            'activeMenu' => $activeMenu,
        ]);
    }



    public function list(Request $request) 
    {
    // Ambil semua kegiatan beserta anggota dan jabatan mereka
    $kegiatan = KegiatanModel::with(['anggota_kegiatan.user', 'anggota_kegiatan.jabatan'])
        ->select('kegiatan_id', 'nama_kegiatan', 'jenis_kegiatan_id', 'tanggal_mulai', 'tanggal_selesai')
        ->get();

    $result = [];

    // Looping untuk setiap kegiatan
    foreach ($kegiatan as $item) {
        // Gabungkan anggota dan jabatan
        $anggotaJabatan = [];
        $update_progress = '0'; // Default progress

        // Ambil progress terakhir berdasarkan kegiatan_id
        $progress = ProgressKegiatanModel::where('kegiatan_id', $item->kegiatan_id)
            ->orderBy('updated_at', 'desc') // Urutkan berdasarkan updated_at terbaru
            ->first();

        if ($progress) {
            // Ambil progress terakhir
            $update_progress = rtrim($progress->update_progress, '%'); // Hapus simbol %
        }

        // Gabungkan anggota dan jabatan untuk ditampilkan
        foreach ($item->anggota_kegiatan as $anggota) {
            $anggotaJabatan[] = $anggota->user->nama . ' (' . $anggota->jabatan->jabatan_nama . ')';
        }

        // Tambahkan data ke hasil
        $result[] = [
            'kegiatan_id' => $item->kegiatan_id,
            'nama_kegiatan' => $item->nama_kegiatan,
            'anggota_jabatan' => implode(', ', $anggotaJabatan), // Gabungkan anggota dan jabatan
            'jenis_kegiatan' => $item->jenis_kegiatan->nama_jenis_kegiatan ?? '-',
            'tgl_mulai' => $item->tanggal_mulai,
            'tgl_selesai' => $item->tanggal_selesai,
            'update_progress' => $update_progress, 
            'aksi' => '<button onclick="modalAction(\'' . url('/progresskegiatan/' . $item->kegiatan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>',
        ];
    }

    // Kembalikan hasil dalam bentuk DataTables
    return DataTables::of($result)
        ->addIndexColumn()
        ->rawColumns(['aksi'])
        ->make(true);
    }


   
    // public function list(Request $request)
    // {
    // // Ambil semua kegiatan dan anggota yang terkait
    // $kegiatan = KegiatanModel::with([
    //     'anggota_kegiatan.user', 
    //     'anggota_kegiatan.jabatan',
    //     'jenis_kegiatan'
    // ])
    // ->select('kegiatan_id', 'nama_kegiatan', 'jenis_kegiatan_id', 'tanggal_mulai', 'tanggal_selesai')
    // ->get();

    // $result = [];

    // // Looping untuk setiap kegiatan
    // foreach ($kegiatan as $item) {
    //     // Gabungkan anggota dan jabatan
    //     $anggotaJabatan = [];
    //     $update_progress = '0'; // Default progress

    //     foreach ($item->anggota_kegiatan as $anggota) {
    //         // Gabungkan anggota dan jabatan
    //         $anggotaJabatan[] = $anggota->user->nama . ' (' . $anggota->jabatan->jabatan_nama . ')';
        
    //         // Ambil progress terbaru dari tabel t_progress_kegiatan berdasarkan kegiatan_id dan anggota_kegiatan_id
    //         $progress = $anggota->progress()->where('kegiatan_id', $item->kegiatan_id)
    //             ->orderBy('updated_at', 'desc') // Ambil progress terakhir berdasarkan waktu update
    //             ->first();
        
    //         if ($progress) {
    //             $update_progress = rtrim($progress->update_progress); // Ambil progress terakhir (hapus simbol %)
    //         }
    //     }
    //     }
    
    //     // Tambahkan data ke hasil
    //     $result[] = [
    //         'kegiatan_id' => $item->kegiatan_id,
    //         'nama_kegiatan' => $item->nama_kegiatan,
    //         'anggota_jabatan' => implode(', ', $anggotaJabatan), // Gabungkan anggota dan jabatan
    //         'jenis_kegiatan' => $item->jenis_kegiatan->nama_jenis_kegiatan ?? '-',
    //         'tgl_mulai' => $item->tanggal_mulai,
    //         'tgl_selesai' => $item->tanggal_selesai,
    //         'update_progress' => $update_progress, 
    //         'aksi' => '<button onclick="modalAction(\'' . url('/progresskegiatan/' . $item->kegiatan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>',
    //     ];
    

    // // Return data for DataTables
    // return DataTables::of($result)
    //     ->addIndexColumn()
    //     ->rawColumns(['aksi'])
    //     ->make(true);
    // }


    // 
    






//    public function list(Request $request)
//     {
//     // Ambil semua kegiatan dan anggota yang terkait
//     $kegiatan = KegiatanModel::with(['anggota_kegiatan.user', 'anggota_kegiatan.jabatan'])
//         ->select('kegiatan_id', 'nama_kegiatan', 'jenis_kegiatan_id', 'tanggal_mulai', 'tanggal_selesai')
//         ->get();

//     $result = [];

//     // Looping untuk setiap kegiatan
//     foreach ($kegiatan as $item) {
//         // Gabungkan anggota dan jabatan
//         $anggotaJabatan = [];
       

//         foreach ($item->anggota_kegiatan as $anggota) {
//             $anggotaJabatan[] = $anggota->user->nama . ' (' . $anggota->jabatan->jabatan_nama . ')';

//             $progress = $anggota->progress()->where('kegiatan_id', $item->kegiatan_id)->first();
//             if ($progress) {
//                 $update_progress = rtrim($progress->update_progress, '%');
//             } else {
//                 $update_progress = '0'; // Atur default jika tidak ada progress
//             }
//         }

//         // Hitung rata-rata progress
//         // $averageProgress = $progressCount > 0 ? round($totalProgress / $progressCount) : 0;

//         // Tambahkan data ke hasil
//         $result[] = [
//             'kegiatan_id' => $item->kegiatan_id,
//             'nama_kegiatan' => $item->nama_kegiatan,
//             'anggota_jabatan' => implode(', ', $anggotaJabatan), // Gabungkan anggota dan jabatan
//             'jenis_kegiatan' => $item->jenis_kegiatan->nama_jenis_kegiatan ?? '-',
//             'tgl_mulai' => $item->tanggal_mulai,
//             'tgl_selesai' => $item->tanggal_selesai,
//             'update_progress' => $update_progress, 
//             'aksi' => '<button onclick="modalAction(\'' . url('/progresskegiatan/' . $item->kegiatan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>',
//         ];
//     }

//     return DataTables::of($result)
//         ->addIndexColumn()
//         ->rawColumns(['aksi'])
//         ->make(true);
//     }

    
    // Menampilkan detail untuk progress kegiatan tertentu

    public function show(string $progress_kegiatan_id)
    {
        $progress = ProgressKegiatanModel::find($progress_kegiatan_id);
        $breadcrumb = (object)[
            'title' => 'Detail Kegiatan',
            'list' => ['Home', 'Kegiatan', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Kegiatan'
        ];
        $activeMenu = 'progress_kegiatan';

        return view('progress.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'progress' => $progress,
            'activeMenu' => $activeMenu
        ]);
    }

    // Method untuk menampilkan progress secara AJAX
    public function show_ajax($id)
    {
    // Ambil data kegiatan berdasarkan ID
    $kegiatan = KegiatanModel::with(['anggota_kegiatan.user', 'anggota_kegiatan.jabatan', 'jenis_kegiatan'])
        ->find($id);

    // Jika tidak ada kegiatan ditemukan, kembalikan error
    if (!$kegiatan) {
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    // Ambil progress terakhir berdasarkan kegiatan_id
    $progress = ProgressKegiatanModel::where('kegiatan_id', $id)
        ->orderBy('updated_at', 'desc')
        ->first();

    return view('progress.show_ajax', [
        'kegiatan' => $kegiatan,
        'progress' => $progress
    ]);
    }
}
