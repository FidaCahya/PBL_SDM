@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($jabatan)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <table class="table table-bordered table-striped table-hover table-sm">
            <tr>
                <th class="text-right col-3">ID :</th>
                <td class="col-9">{{ $jabatan->jabatan_id }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">Kode Jabatan :</th>
                <td class="col-9">{{ $jabatan->jabatan_kode }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">Nama Jabatan :</th>
                <td class="col-9">{{ $jabatan->jabatan_nama }}</td>
            </tr>
        </table>
        @endempty
        <a href="{{ url('jabatan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection
@push('css')
@endpush
@push('js')
@endpush