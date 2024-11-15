@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Jenis Kegiatan</h3>
    </div>
    
    <div class="card-body">
        <div class="mb-3 text-center">
            <div style="display: flex; justify-content: space-between; width: 100%; max-width: 600px; margin: 0 auto; gap: 20px;">
                <button onclick="modalAction('{{ url('/jeniskegiatan/import') }}')" class="btn custom-button-blue">
                    <i class="fa fa-upload"></i> Import Jenis 
                </button>
                <a href="{{ url('/jeniskegiatan/export_excel') }}" class="btn custom-button-yellow">
                    <i class="fa fa-file-excel"></i> Export Jenis 
                </a>
                <a href="{{ url('/jeniskegiatan/export_pdf') }}" class="btn custom-button-blue">
                    <i class="fa fa-file-pdf"></i> Export Jenis 
                </a>
                <button onclick="modalAction('{{ url('/jeniskegiatan/create_ajax') }}')" class="btn custom-button-yellow">
                    <i class="fa fa-plus"></i> Tambah Jenis 
                </button>
            </div>
        </div>

        <!-- Notifications -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <table class="table table-bordered table-striped table-hover table-sm" id="table-jenis-kegiatan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jenis Kegiatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

    <div id="jenisKegiatanModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>
</div>
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
    function modalAction(url = ''){
        $('#jenisKegiatanModal').load(url, function(){
            $('#jenisKegiatanModal').modal('show');
        });
    }

    $(document).ready(function() {
        var dataJenisKegiatan = $('#table-jenis-kegiatan').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('jeniskegiatan/list') }}",
                type: "POST"
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "nama_jenis_kegiatan",
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
    });
</script>
@endpush