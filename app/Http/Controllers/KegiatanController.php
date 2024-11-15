<?php

namespace App\Http\Controllers;

use App\Models\KegiatanModel;
use App\Models\JenisKegiatanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class KegiatanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kegiatan',
            'list' => ['Home', 'Kegiatan']
        ];

        $page = (object) [
            'title' => 'Daftar kegiatan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kegiatan';   // set menu yang sedang aktif

        $jenis_kegiatan = JenisKegiatanModel::all();     // ambil data jenis kegiatan untuk filter jenis kegiatan

        return view('kegiatan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'jenis_kegiatan' => $jenis_kegiatan, 'activeMenu' => $activeMenu]);
    }
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kegiatan',
            'list' => ['Home', 'kegiatan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Kegiatan'
        ];
        $kegiatan = KegiatanModel::all();
        $activeMenu = 'kegiatan'; //set menu yag sedang aktif
    
        return view('kegiatan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'kegiatan' => $kegiatan]);
    }

    
    public function list(Request $request)
    {
    $kegiatan = KegiatanModel::select('kegiatan_id', 'jenis_kegiatan_id', 'nama_kegiatan', 'deskripsi_kegiatan', 'bobot_kerja', 'tanggal_mulai', 'tanggal_selesai', 'status')
        ->with('jenis_kegiatan');

    // Filter data kegiatan berdasarkan jenis_kegiatan_id
    if ($request->jenis_kegiatan_id) {
        $kegiatan->where('jenis_kegiatan_id', $request->jenis_kegiatan_id);
    }

    return DataTables::of($kegiatan)
        ->addIndexColumn()
        ->addColumn('aksi', function ($kegiatan) {
            $btn = '<button onclick="modalAction(\'' . url('/kegiatan/' . $kegiatan->kegiatan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/kegiatan/' . $kegiatan->kegiatan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/kegiatan/' . $kegiatan->kegiatan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kegiatan_id' => 'required|integer',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi_kegiatan' => 'required|string|max:255',
            'bobot_kerja' => 'required|in:ringan,berat',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status' => 'required|in:Belum Dimulai,Sedang Berlangsung,Selesai',
        ]);

        KegiatanModel::create([
            'jenis_kegiatan_id' => $request->jenis_kegiatan_id,
            'nama_kegiatan' => $request->nama_kegiatan,
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            'bobot_kerja' => $request->bobot_kerja,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status,
        ]);

        return redirect('/kegiatan')->with('success', 'Data kegiatan berhasil disimpan');
    }
    public function show(string $kegiatan_id){
        $kegiatan = KegiatanModel::find($kegiatan_id);
        $breadcrumb = (object)[
            'title' => 'Detail Kegiatan',
            'list' => ['Home', 'kegiatan', 'detail']
        ];
        $page = (object)[
            'title' => 'Detail Kegiatan'
        ];
        $activeMenu = 'kegiatan';
        return view('kegiatan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kegiatan' => $kegiatan, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data kegiatan
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis_kegiatan_id' => 'required|integer',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi_kegiatan' => 'required|string|max:255',
            'bobot_kerja' => 'required|in:ringan,berat',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status' => 'required|in:Belum Dimulai,Sedang Berlangsung,Selesai',
        ]);

        $kegiatan = KegiatanModel::find($id);

        if (!$kegiatan) {
            return redirect('/kegiatan')->with('error', 'Data kegiatan tidak ditemukan');
        }

        $kegiatan->update([
            'jenis_kegiatan_id' => $request->jenis_kegiatan_id,
            'nama_kegiatan' => $request->nama_kegiatan,
            'deskripsi_kegiatan' => $request->deskripsi_kegiatan,
            'bobot_kerja' => $request->bobot_kerja,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status,
        ]);

        return redirect('/kegiatan')->with('success', 'Data kegiatan berhasil diubah');
    }

    public function show_ajax(string $id)
    {
        $kegiatan = KegiatanModel::find($id);
        return view('kegiatan.show_ajax', ['kegiatan' => $kegiatan]);
    }

    public function create_ajax()
    {
        $jenis_kegiatan = JenisKegiatanModel::select('jenis_kegiatan_id', 'nama_jenis_kegiatan')->get();
        return view('kegiatan.create_ajax')
            ->with('jenis_kegiatan', $jenis_kegiatan);
    }

    public function store_ajax(Request $request)
    {
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'jenis_kegiatan_id' => 'required|integer',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi_kegiatan' => 'required|string|max:255',
            'bobot_kerja' => 'required|in:ringan,berat',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status' => 'required|in:Belum Dimulai,Sedang Berlangsung,Selesai',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity untuk menunjukkan data tidak valid
        }

        // Menyimpan data yang telah divalidasi
        KegiatanModel::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Data kegiatan berhasil disimpan'
        ], 200); // 200 OK untuk permintaan berhasil
    }

    // Jika bukan request AJAX, redirect ke halaman kegiatan
    return redirect('/kegiatan');
    }

    public function edit_ajax(string $id)
    {
        $kegiatan = KegiatanModel::find($id);
        $jenis_kegiatan = JenisKegiatanModel::select('jenis_kegiatan_id', 'nama_jenis_kegiatan')->get();

        return view('kegiatan.edit_ajax', ['kegiatan' => $kegiatan, 'jenis_kegiatan' => $jenis_kegiatan]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'jenis_kegiatan_id' => 'required|integer',
                'nama_kegiatan' => 'required|string|max:255',
                'deskripsi_kegiatan' => 'required|string|max:255',
                'bobot_kerja' => 'required|in:ringan,berat',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date',
                'status' => 'required|in:Belum Dimulai,Sedang Berlangsung,Selesai',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $kegiatan = KegiatanModel::find($id);
            if ($kegiatan) {
                $kegiatan->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data kegiatan berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data kegiatan tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $kegiatan = KegiatanModel::find($id);
        return view('kegiatan.confirm_ajax', ['kegiatan' => $kegiatan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kegiatan = KegiatanModel::find($id);
            if ($kegiatan) {
                $kegiatan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data kegiatan berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data kegiatan tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_pdf()
    {
        $kegiatan = KegiatanModel::all();
        $pdf = Pdf::loadView('kegiatan.export_pdf', compact('kegiatan'));
        return $pdf->download('data_kegiatan.pdf');
    }
}
