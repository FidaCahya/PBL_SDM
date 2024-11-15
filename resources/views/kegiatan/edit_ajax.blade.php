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
    <form action="{{ url('/kegiatan/' . $kegiatan->kegiatan_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <input value="{{ $kegiatan->nama_kegiatan }}" type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required>
                        <small id="error-nama_kegiatan" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kegiatan</label>
                        <select name="jenis_kegiatan_id" id="jenis_kegiatan" class="form-control" required>
                            <option value="">- Pilih Jenis Kegiatan -</option>
                            @foreach($jenis_kegiatan as $jenis)
                                <option value="{{ $jenis->jenis_kegiatan_id }}" {{ ($jenis->jenis_kegiatan_id == $kegiatan->jenis_kegiatan_id) ? 'selected' : '' }}>
                                    {{ $jenis->nama_jenis_kegiatan }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-jenis_kegiatan_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Kegiatan</label>
                        <input value="{{ $kegiatan->deskripsi_kegiatan }}" type="text" name="deskripsi_kegiatan" id="deskripsi_kegiatan" class="form-control" required>
                        <small id="error-deskripsi_kegiatan" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input value="{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('Y-m-d') }}" type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                        <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input value="{{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('Y-m-d') }}" type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                        <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Bobot Kerja</label>
                        <select name="bobot_kerja" id="bobot_ker _kerja" class="form-control" required>
                            <option value="">- Pilih Bobot Kerja -</option>
                            <option value="ringan" {{ ($kegiatan->bobot_kerja == 'ringan') ? 'selected' : '' }}>Ringan</option>
                            <option value="berat" {{ ($kegiatan->bobot_kerja == 'berat') ? 'selected' : '' }}>Berat</option>
                        </select>
                        <small id="error-bobot_kerja" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Status Kerja</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Pilih Status Kerja</option>
                            <option value="Belum Dimulai" {{ ($kegiatan->status == 'Belum Dimulai') ? 'selected' : '' }}>Belum Dimulai</option>
                            <option value="Sedang Berlangsung" {{ ($kegiatan->status == 'Sedang Berlangsung') ? 'selected' : '' }}>Sedang Berlangsung</option>
                            <option value="Selesai" {{ ($kegiatan->status == 'Selesai') ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <small id="error-status" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    nama_kegiatan: { required: true, minlength: 3, maxlength: 100 },
                    jenis_kegiatan_id: { required: true, number: true },
                    tanggal_mulai: { required: true, date: true },
                    tanggal_selesai: { required: true, date: true },
                    deskripsi: { required: true, minlength: 3, maxlength: 255 },
                    bobot_kerja: { required: true }
                },
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
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty