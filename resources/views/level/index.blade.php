@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
            <div class="mb-3 text-center">
                <div style="display: flex; justify-content: space-between; width: 100%; max-width: 600px; margin: 0 auto; gap: 20px;">
            <button onclick="modalAction('{{ url('/level/import') }}')" class="btn custom-button-blue">
                <i class="fa fa-upload"></i> Import Level
            </button>
            <a href="{{ url('/level/export_excel') }}" class="btn custom-button-yellow">
                <i class="fa fa-file-excel"></i> Export Level
            </a>
            <a href="{{ url('/level/export_pdf') }}" class="btn custom-button-blue">
                <i class="fa fa-file-pdf"></i> Export Level 
            </a>
            <button onclick="modalAction('{{ url('/level/create_ajax') }}')" class="btn custom-button-yellow">
                <i class="fa fa-plus"></i> Tambah Level
            </button>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_level">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Level</th>
                    <th>Nama Level</th>
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

    var dataUser;
    
    $(document).ready(function() {
        var dataLevel = $('#table_level').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('level/list') }}",
                "dataType": "json",
                "type": "POST",
                "headers": {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                    data: "level_kode",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "level_nama",
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

        $('#level_id').on('change',function(){
            dataUser.ajax.reload();
        });
    });
</script>
@endpush
