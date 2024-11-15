@empty($kegiatan)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/anggotakegiatan') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Anggota Kegiatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right col-3">ID Kegiatan :</th>
                    <td class="col-9">{{ $kegiatan->kegiatan_id }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Nama Kegiatan :</th>
                    <td class="col-9">{{ $kegiatan->nama_kegiatan }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Anggota & Jabatan :</th>
                    <td class="col-9">
                        @foreach($kegiatan->anggota_kegiatan as $anggota)
                            {{ $anggota->user->nama }} ({{ $anggota->jabatan->jabatan_nama }})<br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th class="text-right col-3">Jenis Kegiatan :</th>
                    <td class="col-9">{{ $kegiatan->jenis_kegiatan->nama_jenis_kegiatan ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Tanggal Mulai :</th>
                    <td class="col-9">{{ $kegiatan->tanggal_mulai }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Tanggal Selesai :</th>
                    <td class="col-9">{{ $kegiatan->tanggal_selesai }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Progress :</th>
                    <td class="col-9">
                        {{ $progress ? $progress->update_progress : '%' }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
@endempty