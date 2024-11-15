<?php

namespace App\Http\Controllers;

use App\Models\JenisKegiatanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class JenisKegiatanController extends Controller
{
    // Menampilkan halaman awal jenis kegiatan
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Jenis Kegiatan',
            'list' => ['Home', 'Jenis Kegiatan']
        ];
        $page = (object)[
            'title' => 'Daftar Jenis Kegiatan yang terdaftar dalam sistem'
        ];
        $activeMenu = 'jeniskegiatan';

        return view('jeniskegiatan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Ambil data jenis kegiatan dalam bentuk JSON untuk DataTables
    public function list(Request $request)
    {
        $jeniskegiatan = JenisKegiatanModel::select('jenis_kegiatan_id', 'nama_jenis_kegiatan');

        return DataTables::of($jeniskegiatan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($jeniskegiatan) {
                $btn = '<button onclick="modalAction(\'' . url('/jeniskegiatan/' . $jeniskegiatan->jenis_kegiatan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jeniskegiatan/' . $jeniskegiatan->jenis_kegiatan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jeniskegiatan/' . $jeniskegiatan->jenis_kegiatan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan form tambah jenis kegiatan
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Jenis Kegiatan',
            'list' => ['Home', 'Tambah Jenis Kegiatan']
        ];
        $page = (object)[
            'title' => 'Tambah Jenis Kegiatan baru'
        ];
        $activeMenu = 'jenis_kegiatan';

        return view('jeniskegiatan.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data jenis kegiatan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_kegiatan' => 'required|string|max:255',
        ]);

        JenisKegiatanModel::create($request->all());

        return redirect('/jeniskegiatan')->with('success', 'Data jenis kegiatan berhasil disimpan');
    }

    // Menampilkan detail jenis kegiatan
    public function show(string $id)
    {
        $jeniskegiatan = JenisKegiatanModel::find($id);
        if (!$jeniskegiatan) {
            return redirect('/jeniskegiatan')->with('error', 'Data jenis kegiatan tidak ditemukan');
        }

        $breadcrumb = (object)[
            'title' => 'Detail Jenis Kegiatan',
            'list' => ['Home', 'Jenis Kegiatan', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Data Jenis Kegiatan'
        ];
        $activeMenu = 'jeniskegiatan';

        return view('jeniskegiatan.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'jeniskegiatan' => $jeniskegiatan,
            'activeMenu' => $activeMenu
        ]);
    }

   // Menampilkan halaman form tambah jenis kegiatan melalui AJAX
    public function create_ajax()
    {
        $jeniskegiatan = JenisKegiatanModel::select('jenis_kegiatan_id', 'nama_jenis_kegiatan')->get();
        return view('jeniskegiatan.create_ajax');
    }

    // Menyimpan data jenis kegiatan baru melalui AJAX
    public function store_ajax(Request $request)
    {
    // Validasi data yang diterima
    $rules = [
        'nama_jenis_kegiatan' => 'required|string|max:255',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi gagal.',
            'msgField' => $validator->errors()
        ]);
    }

    // Membuat entri baru di database
    $jeniskegiatan = JenisKegiatanModel::create($request->all());

    return response()->json([
        'status' => true,
        'message' => 'Data jenis kegiatan berhasil disimpan',
        'data' => $jeniskegiatan // mengembalikan data yang baru disimpan
    ]);
    }

    // Menampilkan form edit jenis kegiatan
    public function edit_ajax(string $id)
    {
        $jeniskegiatan = JenisKegiatanModel::find($id);
        if (!$jeniskegiatan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        return view('jeniskegiatan.edit_ajax', ['jeniskegiatan' => $jeniskegiatan]);
    }

    public function show_ajax(string $id)
    {
    $jeniskegiatan = JenisKegiatanModel::find($id);
    return view('jeniskegiatan.show_ajax', ['jeniskegiatan' => $jeniskegiatan]);
    }

    // Mengupdate data jenis kegiatan
    public function update_ajax(Request $request, $id)
    {
        $rules = [
            'nama_jenis_kegiatan' => 'required|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $jeniskegiatan = JenisKegiatanModel::find($id);
        if ($jeniskegiatan) {
            $jeniskegiatan->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    // Menghapus data jenis kegiatan
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $jeniskegiatan = JenisKegiatanModel::find($id);
            if ($jeniskegiatan) {
                $jeniskegiatan->delete();
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
        return redirect('/jeniskegiatan');
    }

    public function confirm_ajax(string $id)
    {
    $jeniskegiatan = JenisKegiatanModel::find($id);
    if (!$jeniskegiatan) {
        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }
    return view('jeniskegiatan.confirm_ajax', ['jeniskegiatan' => $jeniskegiatan]);
    }

    // Mengimpor data jenis kegiatan
    public function import()
    {
        return view('jeniskegiatan.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_jeniskegiatan' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_jeniskegiatan');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'nama_jenis_kegiatan' => $value['A'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    JenisKegiatanModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

    // Mengekspor data jenis kegiatan ke Excel
    public function export_excel()
    {
        $jeniskegiatan = JenisKegiatanModel::select('jenis_kegiatan_id', 'nama_jenis_kegiatan')
            ->orderBy('jenis_kegiatan_id')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama Jenis Kegiatan');

        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $baris = 2;
        foreach ($jeniskegiatan as $value) {
            $sheet->setCellValue('A' . $baris, $value->jenis_kegiatan_id);
            $sheet->setCellValue('B' . $baris, $value ->nama_jenis_kegiatan);
            $baris++;
        }

        foreach (range('A', 'B') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Jenis Kegiatan');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Jenis Kegiatan ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    // Mengekspor data jenis kegiatan ke PDF
    public function export_pdf()
    {
        $jeniskegiatan = JenisKegiatanModel::select('jenis_kegiatan_id', 'nama_jenis_kegiatan')
            ->orderBy('jenis_kegiatan_id')
            ->get();

        $pdf = Pdf::loadView('jeniskegiatan.export_pdf', ['jeniskegiatan' => $jeniskegiatan]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);

        return $pdf->stream('Data Jenis Kegiatan ' . date('Y-m-d H:i:s') . '.pdf');
    }
}