<!-- Form Create Anggota Kegiatan (create_ajax) -->
<form action="{{ url('/anggotakegiatan/ajax') }}" method="POST" id="form-tambah-anggota-kegiatan" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Anggota Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Anggota</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">Pilih Anggota</option>
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Kegiatan</label>
                    <select name="kegiatan_id" id="kegiatan_id" class="form-control" required>
                        <option value="">Pilih Kegiatan</option>
                        @foreach($kegiatans as $kegiatan)
                            <option value="{{ $kegiatan->kegiatan_id }}">{{ $kegiatan->nama_kegiatan }}</option>
                        @endforeach
                    </select>
                    <small id="error-kegiatan_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Jabatan</label>
                    <select name="jabatan_id" id="jabatan_id" class="form-control" required>
                        <option value="">Pilih Jabatan</option>
                        @foreach($jabatans as $jabatan)
                            <option value="{{ $jabatan->jabatan_id }}">{{ $jabatan->jabatan_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-jabatan_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Poin</label>
                    <input type="number" name="poin" id="poin" class="form-control" step="0.5" min="0.5" required>
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
        $("#form-tambah-anggota-kegiatan").validate({
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
