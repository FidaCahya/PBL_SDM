@empty($anggota_kegiatan)
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
                        <th class="text-right col-3">ID Anggota Kegiatan :</th>
                        <td class="col-9">{{ $anggota_kegiatan->anggota_kegiatan_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama Anggota :</th>
                        <td class="col-9">{{ $anggota_kegiatan->user->nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Kegiatan :</th>
                        <td class="col-9">{{ $anggota_kegiatan->kegiatan->nama_kegiatan }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Jabatan :</th>
                        <td class="col-9">{{ $anggota_kegiatan->jabatan->jabatan_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Poin :</th>
                        <td class="col-9">{{ $anggota_kegiatan->jabatan->poin }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@endempty
