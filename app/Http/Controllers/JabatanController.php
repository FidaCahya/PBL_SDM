<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JabatanKegiatanModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class JabatanController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Jabatan',
            'list'  => ['Home', 'Jabatan']
        ];

        $page = (object)[
            'title' => 'Daftar Jabatan Anggota Kegiatan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'jabatan';
        
        return view('jabatan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Jabatan',
            'list' => ['Home', 'Jabatan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Jabatan'
        ];
        $jabatan = JabatanKegiatanModel::all();
        $activeMenu = 'jabatan';
    
        return view('jabatan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'jabatan' => $jabatan]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan_kode' => 'required|unique:m_jabatan,jabatan_kode',
            'jabatan_nama' => 'required',
        ]);

        JabatanKegiatanModel::create([
            'jabatan_kode' => $request->jabatan_kode,
            'jabatan_nama' => $request->jabatan_nama
        ]);

        return redirect('/jabatan')->with('success', 'Data jabatan berhasil ditambahkan');
    }

    public function show(string $jabatan_id){
        $jabatan = JabatanKegiatanModel::find($jabatan_id);
        $breadcrumb = (object)[
            'title' => 'Detail Jabatan',
            'list' => ['Home', 'Jabatan', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Jabatan'
        ];
        $activeMenu = 'jabatan';
        return view('jabatan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'jabatan' => $jabatan, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $jabatan_id){
        $jabatan = JabatanKegiatanModel::find($jabatan_id);
        $breadcrumb = (object)[
            'title' => 'Edit Jabatan',
            'list' => ['Home', 'Jabatan', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Jabatan'
        ];
        $activeMenu = 'jabatan';
        return view('jabatan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'jabatan' => $jabatan]);
    }

    public function update(Request $request, string $jabatan_id){
        $request->validate([
            'jabatan_kode' => 'required|string|max:5|unique:m_jabatan_kegiatan,jabatan_kode',
            'jabatan_nama' => 'required|string|max:100'
        ]);
        $jabatan = JabatanKegiatanModel::find($jabatan_id);
        $jabatan->update([
            'jabatan_kode' => $request->jabatan_kode,
            'jabatan_nama' => $request->jabatan_nama
        ]);
        return redirect('/jabatan')->with('success', 'Data jabatan berhasil diubah');
    }

    public function destroy(string $jabatan_id) {    
        $check = JabatanKegiatanModel::find($jabatan_id);
        if (!$check){
            return redirect('/jabatan')->with('error', 'Data jabatan tidak ditemukan');
        }

        try{
            JabatanKegiatanModel::destroy($jabatan_id);
            return redirect('/jabatan')->with('success','Data jabatan berhasil dihapus');
        }catch (\Illuminate\Database\QueryException $e){
            return redirect('/jabatan')->with('error', 'Data jabatan gagal dihapus karena terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function list(Request $request) 
    {
        $jabatan = JabatanKegiatanModel::select('jabatan_id', 'jabatan_kode', 'jabatan_nama');
            
        if ($request->jabatan_id) {
            $jabatan->where('jabatan_id', $request->jabatan_id);
        }

        return DataTables::of($jabatan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($jabatan) {
                $btn = '<button onclick="modalAction(\'' . url('/jabatan/' . $jabatan->jabatan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jabatan/' . $jabatan->jabatan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jabatan/' . $jabatan->jabatan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $jabatan = JabatanKegiatanModel::find($id);
        return view('jabatan.show_ajax', ['jabatan' => $jabatan]);
    }

    public function create_ajax(){
        return view('jabatan.create_ajax');
    }          

    public function store_ajax(Request $request){
        if($request->ajax() || $request->wantsJson()){
            $rules = [
                'jabatan_kode' => 'required|string|min:3|unique:m_jabatan_kegiatan,jabatan_kode',
                'jabatan_nama' => 'required|string|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }  
            
            JabatanKegiatanModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data jabatan berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $jabatan = JabatanKegiatanModel::find($id);
        return view('jabatan.edit_ajax',['jabatan' => $jabatan]);
    }

    public function update_ajax(Request $request, $id){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'jabatan_kode' => 'required|string|min:3|unique:m_jabatan_kegiatan,jabatan_kode',
                'jabatan_nama' => 'required|string|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }
            $check = JabatanKegiatanModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }   
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id){
        $jabatan = JabatanKegiatanModel::find($id);
        return view('jabatan.confirm_ajax', ['jabatan' => $jabatan]);
    }

    public function delete_ajax(Request $request, $id) 
    {
        if ($request->ajax() || $request->wantsJson()) {
            $jabatan = JabatanKegiatanModel::find($id);
            if ($jabatan) {
                $jabatan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function import()
    {
        return view('jabatan.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_jabatan' => ['required', 'mimes:xlsx', 'max:5120'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            $file_jabatan = $request->file('file_jabatan')->getRealPath();
            $reader = IOFactory::createReader('Xlsx');
            $spreadsheet = $reader->load($file_jabatan);
            $jabatanArray = [];
            foreach ($spreadsheet->getActiveSheet()->toArray(null, true, true, true) as $idx => $row) {
                if ($idx > 1 && !empty(array_filter($row))) {
                    $jabatanArray[] = [
                        'jabatan_kode' => $row['A'],
                        'jabatan_nama' => $row['B']
                    ];
                }
            }
            try {
                JabatanKegiatanModel::insert($jabatanArray);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data gagal diimport'
                ]);
            }
        }
        return redirect('/');
    }
}
