<form action="{{ url('/kegiatan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required>
                    <small id="error-nama_kegiatan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jenis Kegiatan</label>
                    <select name="jenis_kegiatan_id" id="jenis_kegiatan" class="form-control" required>
                        <option value="">Pilih Jenis Kegiatan</option>
                        @foreach($jenis_kegiatan as $jenis)
                            <option value="{{ $jenis->jenis_kegiatan_id }}">{{ $jenis->nama_jenis_kegiatan }}</option>
                        @endforeach
                    </select>
                    <small id="error-jenis_kegiatan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Deskripsi Kegiatan</label>
                    <textarea name="deskripsi_kegiatan" id="deskripsi_kegiatan" class="form-control" required></textarea>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                    <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                    <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Bobot Kerja</label>
                    <select name="bobot_kerja" id="bobot_kerja" class="form-control" required>
                        <option value="">Pilih Bobot Kerja</option>
                        <option value="ringan">Ringan</option>
                        <option value="berat">Berat</option>
                    </select>
                    <small id="error-bobot_kerja" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Status Kerja</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">Pilih Status Kerja</option>
                        <option value="Belum Dimulai">Belum Dimulai</option>
                        <option value="Sedang Berlangsung">Sedang Berlangsung</option>
                        <option value="Selesai">Selesai</option>
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
$('#form-tambah').submit(function(e) {
    e.preventDefault(); // Mencegah submit standar

    // Bersihkan pesan error sebelumnya
    $('.error-text').text('');

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message
                });
                // Misalnya, reload data tabel
                $('#dataKegiatan').DataTable().ajax.reload();
                $('#modal-master').modal('hide');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Harap periksa data yang Anda masukkan.'
                });
                // Tampilkan pesan error validasi dari server
                $.each(response.msgField, function(key, value) {
                    $('#error-' + key).text(value[0]);
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Terjadi kesalahan'
            });
            console.log(xhr.responseText);
        }
    });
});


// $(document).ready(function() {
//     $("#form-tambah").validate({
//         rules: {
//             jenis_kegiatan_id: { required: true, number: true },
//             nama_kegiatan: { required: true, minlength: 3, maxlength: 255 },
//             deskripsi_kegiatan: { required: true, minlength: 5, maxlength: 255 },
//             bobot_kerja: { required: true, in: ["ringan", "berat"] },
//             tanggal_mulai: { required: true, date: true },
//             tanggal_selesai: { required: true, date: true },
//             status: { required: true, in: ["Belum Dimulai", "Sedang Berlangsung", "Selesai"] }
//         },
//         submitHandler: function(form) {
//             $.ajax({
//                 url: form.action,
//                 type: form.method, // Pastikan ini POST
//                 data: $(form).serialize(),
//                 success: function(response) {
//                     if (response.status) {
//                         $('#myModal').modal('hide');
//                         Swal.fire({
//                             icon: 'success',
//                             title: 'Berhasil',
//                             text: response.message
//                         });
//                         dataKegiatan.ajax.reload();
//                     } else {
//                         $('.error-text').text('');
//                         $.each(response.msgField, function(prefix, val) {
//                             $('#error-' + prefix).text(val[0]);
//                         });
//                         Swal.fire({
//                             icon: 'error',
//                             title: 'Terjadi Kesalahan',
//                             text: response.message
//                         });
//                     }
//                 }
//             });
//             return false; // Prevent the default form submission
//         },
//         errorElement: 'span',
//         errorPlacement: function(error, element) {
//             error.addClass('invalid-feedback');
//             element.closest('.form-group').append(error);
//         },
//         highlight: function(element, errorClass, validClass) {
//             $(element).addClass('is-invalid');
//         },
//         unhighlight: function(element, errorClass, validClass) {
//             $(element).removeClass('is-invalid');
//         }
//     });
// });