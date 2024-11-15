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
                <a href="{{ url('/kegiatan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/kegiatan/' . $kegiatan->kegiatan_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin menghapus data kegiatan berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">ID Kegiatan :</th>
                            <td class="col-9">{{ $kegiatan->kegiatan_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis Kegiatan :</th>
                            <td class="col-9">{{ $kegiatan->jenis_kegiatan_id ? $kegiatan->jenis_kegiatan->nama_jenis_kegiatan : '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Kegiatan :</th>
                            <td class="col-9">{{ $kegiatan->nama_kegiatan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Deskripsi :</th>
                            <td class="col-9">{{ $kegiatan->deskripsi_kegiatan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Bobot Kerja :</th>
                            <td class="col-9">{{ $kegiatan->bobot_kerja }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Mulai :</th>
                            <td class="col-9" >{{ $kegiatan->tanggal_mulai }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal Selesai :</th>
                            <td class="col-9">{{ $kegiatan->tanggal_selesai }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Status:</th>
                            <td class="col-9">{{ $kegiatan->status }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataKegiatan.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Data kegiatan gagal dihapus. Silakan coba lagi.'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan Server',
                                text: 'Terjadi kesalahan pada server. Silakan coba beberapa saat lagi.'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endempty
