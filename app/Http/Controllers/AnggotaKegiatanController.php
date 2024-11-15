<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKegiatanModel;
use App\Models\JabatanKegiatanModel;
use App\Models\KegiatanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Psy\Readline\Userland;

class AnggotaKegiatanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Anggota Kegiatan',
            'list' => ['Home', 'Anggota Kegiatan']
        ];

        $page = (object) [
            'title' => 'Daftar anggota kegiatan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'anggota_kegiatan';
        $jabatan_kegiatan = JabatanKegiatanModel::all();

        return view('anggotakegiatan.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'jabatan_kegiatan' => $jabatan_kegiatan, 
            'activeMenu' => $activeMenu
        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Anggota Kegiatan',
            'list' => ['Home', 'Anggota Kegiatan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Anggota Kegiatan'
        ];
        $anggota_kegiatan = AnggotaKegiatanModel::all();
        $activeMenu = 'anggota_kegiatan';

        return view('anggotakegiatan.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu, 
            'anggota_kegiatan' => $anggota_kegiatan
        ]);
    }


    public function list(Request $request) 
    {
    $anggota_kegiatan = AnggotaKegiatanModel::select(
        'anggota_kegiatan_id',
        'user_id',
        'kegiatan_id', 
        'jabatan_id',  
    )
    ->with([
        'user' => function ($query) {
            $query->select('user_id', 'nama'); // Replace with the correct field for the activity name
        },
        'kegiatan' => function ($query) {
            $query->select('kegiatan_id', 'nama_kegiatan'); // Replace with the correct field for the activity name
        },
        'jabatan' => function ($query) {
            $query->select('jabatan_id', 'jabatan_nama', 'poin'); // Replace with the correct field for the position name
        }
        
        
    ]);

    if ($request->jabatan_id) {
        $anggota_kegiatan->where('jabatan_id', $request->jabatan_id);
    }

    return DataTables::of($anggota_kegiatan)
        ->addIndexColumn()
        ->addColumn('user', function ($row) {
            return $row->user ? $row->user->nama : '-';
        })
        ->addColumn('kegiatan', function ($row) {
            return $row->kegiatan ? $row->kegiatan->nama_kegiatan : '-';
        })
        ->addColumn('jabatan', function ($row) {
            return $row->jabatan ? $row->jabatan->jabatan_nama : '-';
        })
        ->addColumn('poin', function ($row) {
            return $row->jabatan ? $row->jabatan->poin : '-'; // Menampilkan poin sesuai jabatan
        })
        ->addColumn('aksi', function ($anggota_kegiatan) {
            $btn = '<button onclick="modalAction(\'' . url('/anggotakegiatan/' . $anggota_kegiatan->anggota_kegiatan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/anggotakegiatan/' . $anggota_kegiatan->anggota_kegiatan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/anggotakegiatan/' . $anggota_kegiatan->anggota_kegiatan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }


    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|integer',
            'jabatan_id' => 'required|integer',
            'poin' => 'required|integer',
        ]);

        AnggotaKegiatanModel::create($request->all());

        return redirect('/anggotakegiatan')->with('success', 'Data anggota kegiatan berhasil disimpan');
    }

    public function show(string $anggota_kegiatan_id)
    {
        $anggota_kegiatan = AnggotaKegiatanModel::find($anggota_kegiatan_id);
        $breadcrumb = (object)[
            'title' => 'Detail Anggota Kegiatan',
            'list' => ['Home', 'Anggota Kegiatan', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Anggota Kegiatan'
        ];
        $activeMenu = 'anggota_kegiatan';
        return view('anggota_kegiatan.show', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'anggota_kegiatan' => $anggota_kegiatan, 
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
    // Validate the incoming request data
    $request->validate([
        'user_id' => 'required|exists:m_user,user_id',
        'kegiatan_id' => 'required|exists:t_kegiatan,kegiatan_id',
        'jabatan_id' => 'required|exists:m_jabatan_kegiatan,jabatan_id',
        'poin' => 'required|numeric|min:0.5',                                // Validates that poin is a non-negative integer
    ]);

    // Find the anggota_kegiatan record by its ID
    $anggota_kegiatan = AnggotaKegiatanModel::find($id);

    // Check if the anggota_kegiatan record exists
    if (!$anggota_kegiatan) {
        // If not found, return with an error message
        return redirect('/anggotakegiatan')->with('error', 'Data anggota kegiatan tidak ditemukan');
    }

    // Update the anggota_kegiatan record
    $anggota_kegiatan->update([
            'user_id' => $request->user_id,
            'kegiatan_id' => $request->kegiatan_id,
            'jabatan_id' => $request->jabatan_id,
            'poin' => $request->poin,
    ]);


    // Return updated data with a success message
    return redirect('/anggotakegiatan')->with('success', 'Data anggota kegiatan berhasil diubah');
    }


    public function show_ajax(string $id)
    {
        $anggota_kegiatan = AnggotaKegiatanModel::find($id);
        return view('anggotakegiatan.show_ajax', ['anggota_kegiatan' => $anggota_kegiatan]);
    }
    

    public function create_ajax()
    {
        // Ambil data jabatan dan kegiatan untuk dropdown
        $jabatans = JabatanKegiatanModel::all();
        $kegiatans = KegiatanModel::all();
        $users = UserModel::all();  // Ambil data user jika diperlukan untuk dropdown

        return view('anggotakegiatan.create_ajax', compact('jabatans', 'kegiatans', 'users'));
    }

    public function store_ajax(Request $request)
    {
    // Validate the incoming data
    $validated = $request->validate([
        'user_id' => 'required|exists:m_user,user_id',
        'kegiatan_id' => 'required|exists:t_kegiatan,kegiatan_id',
        'jabatan_id' => 'required|exists:m_jabatan_kegiatan,jabatan_id',
        'poin' => 'required|numeric|min:0.5',
    ]);

    try {
        // Insert data into the AnggotaKegiatan table
        $anggota_kegiatan = AnggotaKegiatanModel::create([
            'user_id' => $request->user_id,
            'kegiatan_id' => $request->kegiatan_id,
            'jabatan_id' => $request->jabatan_id,
            'poin' => $request->poin,
        ]);

        // Load related data using Eloquent relationships, similar to the `list` function
        $anggota_kegiatan->load([
            'user' => function ($query) {
                $query->select('user_id', 'nama');
            },
            'kegiatan' => function ($query) {
                $query->select('kegiatan_id', 'nama_kegiatan');
            },
            'jabatan' => function ($query) {
                $query->select('jabatan_id', 'jabatan_nama', 'poin');
            }
        ]);

        // Return success response
        return response()->json([
            'status' => true,
            'message' => 'Anggota kegiatan berhasil ditambahkan.',
            'anggota_kegiatan' => [
                'anggota_kegiatan_id' => $anggota_kegiatan->anggota_kegiatan_id,
                'user' => $anggota_kegiatan->user->nama ?? '-',
                'kegiatan' => $anggota_kegiatan->kegiatan->nama_kegiatan ?? '-',
                'jabatan' => $anggota_kegiatan->jabatan->jabatan_nama ?? '-',
                'poin' => $anggota_kegiatan->jabatan->poin ?? '-',
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan, silakan coba lagi.',
        ]);
    }
    }


    public function edit_ajax(string $id)
    {
    $anggota_kegiatan = AnggotaKegiatanModel::find($id);
    $user = UserModel::select('user_id', 'nama')->get();  // Change $users to $user
    $kegiatan = KegiatanModel::select('kegiatan_id', 'nama_kegiatan')->get();
    $jabatan_kegiatan = JabatanKegiatanModel::select('jabatan_id', 'jabatan_nama')->get();

    return view('anggotakegiatan.edit_ajax', [
        'anggota_kegiatan' => $anggota_kegiatan, 
        'user' => $user,  
        'kegiatan' => $kegiatan, 
        'jabatan_kegiatan' => $jabatan_kegiatan
    ]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Define validation rules
            $rules = [
                'user_id' => 'required|exists:m_user,user_id',  // Ensure user exists
                'kegiatan_id' => 'required|exists:t_kegiatan,kegiatan_id',  // Ensure kegiatan exists
                'jabatan_id' => 'required|exists:m_jabatan_kegiatan,jabatan_id',  // Ensure jabatan exists
                'poin' => 'required|numeric|min:0.5',  // Ensure poin is numeric and meets the minimum value
            ];
    
            // Perform validation
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
            $anggota_kegiatan = AnggotaKegiatanModel::find($id);
            if ($anggota_kegiatan) {
                $anggota_kegiatan->update($request->all());
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
        return redirect('/');;
    }
    

    public function confirm_ajax(string $id)
    {
        $anggota_kegiatan = AnggotaKegiatanModel::find($id);
        return view('anggotakegiatan.confirm_ajax', ['anggota_kegiatan' => $anggota_kegiatan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $anggota_kegiatan = AnggotaKegiatanModel::find($id);
            if ($anggota_kegiatan) {
                $anggota_kegiatan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data anggota kegiatan berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data anggota kegiatan tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_pdf()
    {
        $anggota_kegiatan = AnggotaKegiatanModel::all();
        $pdf = Pdf::loadView('anggotakegiatan.pdf', ['anggota_kegiatan' => $anggota_kegiatan]);
        return $pdf->download('anggotakegiatan.pdf');
    }
}
