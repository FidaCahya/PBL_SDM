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
    <form action="{{ url('/anggotakegiatan/' . $anggota_kegiatan->anggota_id. 'update_ajax') }}" method="POST" id="form-edit">

        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Anggota Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Anggota</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">Pilih Anggota</option>
                            @foreach($user as $user)
                                <option {{ ($user->user_id == $anggota_kegiatan->user_id) ? 'selected' : '' }} 
                                value="{{ $user->user_id }}">{{ $user->nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-user_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <select name="kegiatan_id" id="kegiatan_id" class="form-control" required>
                            <option value="">Pilih Kegiatan</option>
                            @foreach($kegiatan as $kegiatan)
                                <option {{ ($kegiatan->kegiatan_id == $anggota_kegiatan->kegiatan_id) ? 'selected' : '' }} 
                                value="{{ $kegiatan->kegiatan_id }}">{{ $kegiatan->nama_kegiatan }}</option>
                            @endforeach
                        </select>
                        <small id="error-kegiatan_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="jabatan_id" id="jabatan_id" class="form-control" required>
                            <option value="">Pilih Jabatan</option>
                            @foreach($jabatan_kegiatan as $jabatan)
                                <option {{ ($jabatan->jabatan_id == $anggota_kegiatan->jabatan_id) ? 'selected' : '' }} 
                                value="{{ $jabatan->jabatan_id }}">{{ $jabatan->jabatan_nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-jabatan_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Poin</label>
                        <input type="number" name="poin" id="poin" class="form-control" value="{{ $anggota_kegiatan->poin }}" step="0.5" min="0.5" required>
                        <small id="error-poin" class="error-text form-text text-danger"></small>
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
                    user_id: { required: true },
                    kegiatan_id: { required: true },
                    jabatan_id: { required: true },
                    poin: { required: true, min: 0.5 }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide'); // Close the modal
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                $('#table_anggota_kegiatan').DataTable().ajax.reload(); // Reload the data table
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
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Silakan coba lagi nanti.'
                            });
                        }
                    });
                    return false; // Prevent the default form submission
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
