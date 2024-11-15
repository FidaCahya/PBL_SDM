@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <div class="mb-3 text-center">
            <div style="display: flex; justify-content: space-between; width: 100%; max-width: 600px; margin: 0 auto; gap: 20px;">
                <button onclick="modalAction('{{ url('/kegiatan/import') }}')" class="btn custom-button-blue">
                    <i class="fa fa-upload"></i> Import Kegiatan
                </button>
                <a href="{{ url('/kegiatan/export_excel') }}" class="btn custom-button-yellow">
                    <i class="fa fa-file-excel"></i> Export Kegiatan
                </a>
                <a href="{{ url('/kegiatan/export_pdf') }}" class="btn custom-button-blue">
                    <i class="fa fa-file-pdf"></i> Export Kegiatan
                </a>
                <button onclick="modalAction('{{ url('/kegiatan/create_ajax') }}')" class="btn custom-button-yellow">
                    <i class="fa fa-plus"></i> Tambah Kegiatan
                </button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select class="form-control" id="jenis_kegiatan_id" name="jenis_kegiatan_id" required>
                            <option value="">- Semua -</option>
                            @foreach($jenis_kegiatan as $item)
                                <option value="{{ $item->jenis_kegiatan_id }}">{{ $item->nama_jenis_kegiatan }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Jenis Kegiatan</small>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-striped table-hover table-sm" id="table_kegiatan">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jenis Kegiatan</th>
                    <th>Nama Kegiatan</th>
                    <th>Deskripsi Kegiatan</th>
                    <th>Bobot Kerja</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" 
    data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
<style>
    .custom-button-blue {
        background-color: #003366 !important;
        color: white;
        width: 150px;
        height: 50px;
        border: none;
    }

    .custom-button-yellow {
        background-color: #ffc107 !important;
        color: black;
        width: 150px;
        height: 50px;
        border: none;
    }

    .custom-button-blue:hover,
    .custom-button-yellow:hover {
        opacity: 0.9;
    }
</style>
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataKegiatan;

    $(document).ready(function() {
        dataKegiatan = $('#table_kegiatan').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('kegiatan/list') }}",
                dataType: "json",
                type: "POST",
                data: function (d) {
                    d.jenis_kegiatan_id = $('#jenis_kegiatan_id').val();
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "jenis_kegiatan.nama_jenis_kegiatan",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "nama_kegiatan",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "deskripsi_kegiatan",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "bobot_kerja",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "tanggal_mulai",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "tanggal_selesai",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "status",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#jenis_kegiatan_id').on('change', function() {
            dataKegiatan.ajax.reload();
        });
    });
</script>
@endpush
