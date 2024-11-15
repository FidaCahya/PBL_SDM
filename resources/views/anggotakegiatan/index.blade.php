@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <div class="mb-3 text-center">
            <div style="display: flex; justify-content: space-between; width: 100%; max-width: 600px; margin: 0 auto; gap: 20px;">
                <button onclick="modalAction('{{ url('/anggotakegiatan/import') }}')" class="btn custom-button-blue">
                    <i class="fa fa-upload"></i> Import Anggota
                </button>
                <a href="{{ url('/anggota/export_excel') }}" class="btn custom-button-yellow">
                    <i class="fa fa-file-excel"></i> Export Anggota
                </a>
                <a href="{{ url('/anggota/export_pdf') }}" class="btn custom-button-blue">
                    <i class="fa fa-file-pdf"></i> Export Anggota
                </a>
                <button onclick="modalAction('{{ url('/anggotakegiatan/create_ajax') }}')" class="btn custom-button-yellow">
                    <i class="fa fa-plus"></i> Tambah Anggota
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_anggota_kegiatan">
            <thead>
                <tr>
                    <th>Anggota</th>
                    <th>Nama</th>
                    <th>Kegiatan</th>
                    <th>Jabatan</th>
                    <th>Poin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Dynamic content will be loaded through DataTables --}}
            </tbody>
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

    $(document).ready(function() {
        var dataAnggotaKegiatan = $('#table_anggota_kegiatan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('/anggotakegiatan/list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                        { data: "anggota_kegiatan_id", className: "text-center", orderable: false },
                        { data: "user", orderable: true },
                        { data: "kegiatan", orderable: true },
                        { data: "jabatan", orderable: true },
                        { data: "poin", orderable: true },
                        {
                            data: "aksi",
                            orderable: false,
                            searchable: false
                        }
                    ]
        });

        $('#jabatan_id').on('change', function() {
            dataAnggotaKegiatan.ajax.reload();
        });
    });
</script>
@endpush

{{-- <script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function() {
        // Initialize DataTables
        var dataAnggotaKegiatan = $('#table_anggota_kegiatan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('anggotakegiatan/list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                { data: "anggota_kegiatan_id", className: "text-center", orderable: false },
                { data: "profile_dosen_id", orderable: true },
                { data: "jabatan", orderable: true },
                { data: "poin", orderable: true }
            ]
        });

        $('#jabatan_id').on('change', function() {
            dataJabatan.ajax.reload();
        });
    });
</script>
@endpush --}}
