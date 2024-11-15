@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select class="form-control" id="kegiatan_id" name="kegiatan_id" required>
                            <option value="">- Semua -</option>
                            @foreach($kegiatan as $item)
                                <option value="{{ $item->kegiatan_id }}">{{ $item->nama_kegiatan }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Kegiatan</small>
                    </div>
                </div>
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

        <table class="table table-bordered table-striped table-hover table-sm" id="table_progress">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kegiatan</th>
                    <th>Nama Anggota & Jabatan</th>
                    <th>Jenis Kegiatan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Progress (%)</th>
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

    .custom-button-blue:hover {
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
        dataProgress = $('#table_progress').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ url('progresskegiatan/list') }}",
                dataType: "json",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                error: function(xhr, status, error) {
                    console.error("DataTables AJAX error:", xhr.responseText);
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "nama_kegiatan" },
                { data: "anggota_jabatan" }, // Kolom ini akan menampilkan semua anggota dan jabatan
                { data: "jenis_kegiatan" },
                { data: "tgl_mulai" }, 
                { data: "tgl_selesai" },
                { 
                    data: "update_progress",
                    render: function(data) {
                        return `${data}%`; // Menampilkan progress dengan simbol persen
                    },
                    className: "text-center",
                    orderable: true,
                    searchable: false
                },
                { data: "aksi", orderable: false, searchable: false }
            ]
        });

        // Trigger reload when filter is changed
        $('#kegiatan_id').on('change', function() {
            dataProgress.ajax.reload();
        });
    });
</script>
@endpush