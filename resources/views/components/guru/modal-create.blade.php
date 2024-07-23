<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="name" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="nama">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                </div>


                <div class="form-group">
                    <label class="control-label">NIP</label>
                    <input type="text" class="form-control" id="nip" maxlength="18">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nip"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" maxlength="10">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jabatan"></div>
                </div>

                <div class="form-group">
                    <label for="kelas" class="control-label">Kelas</label>
                    <select class="form-control" id="kelas">

                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kelas"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="store">SIMPAN</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('body').on('click', '#btn-create-post', function () {
    $('#modal-create').modal('show');

    $.ajax({
        url: '/carikelas', // Menggunakan route yang telah didefinisikan
        type: 'GET',
        success: function(response) {
            let kelasDropdown = $('#kelas');
            kelasDropdown.empty(); // Clear existing options

            // Populate dropdown with data from response
            response.data.forEach(function(kelas) {
                let option = `<option value="${kelas.id}">${kelas.nama} - ${kelas.jurusan}</option>`;
                kelasDropdown.append(option);
            });
        },
        error: function(error) {
            console.error('Error fetching kelas data', error);
        }
    });
});
    document.getElementById('nip').addEventListener('input', function(event) {
        this.value = this.value.replace(/[^0-9]/g, '');
        this.value = this.value.substring(0, 18);
    });

    //action create post
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        let nama   = $('#nama').val();
        let nip = $('#nip').val();
        let jabatan = $('#jabatan').val();
        let id_kelas = $('#kelas').val();
        let token   = $("meta[name='csrf-token']").attr("content");

        //ajax
        $.ajax({

            url: `/guru`,
            type: "POST",
            cache: false,
            data: {
                "nama": nama,
                "nip": nip,
                "jabatan": jabatan,
                "id_kelas": id_kelas,
                "_token": token
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,

                });

                //data post
                let post = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.nama}</td>
                        <td>${response.data.nip}</td>
                        <td>${response.data.jabatan}</td>
                        <td>${response.data.kelas.nama} - ${response.data.kelas.jurusan}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;

                //append to table
                $('#table-posts').prepend(post);

                //clear form
                $('#nama').val('');
                $('#nip').val('');
                $('#jabatan').val('');
                $('#kelas').val('');

                //close modal
                $('#modal-create').modal('hide');


            },
            error:function(error){

                if(error.responseJSON.nama[0]) {

                    //show alert
                    $('#alert-nama').removeClass('d-none');
                    $('#alert-nama').addClass('d-block');

                    //add message to alert
                    $('#alert-nama').html(error.responseJSON.nama[0]);
                }

                if(error.responseJSON.nip[0]) {

                    //show alert
                    $('#alert-nip').removeClass('d-none');
                    $('#alert-nip').addClass('d-block');

                    //add message to alert
                    $('#alert-nip').html(error.responseJSON.nip[0]);
                }

                if(error.responseJSON.jabatan[0]) {

                    //show alert
                    $('#alert-jabatan').removeClass('d-none');
                    $('#alert-jabatan').addClass('d-block');

                    //add message to alert
                    $('#alert-jabatan').html(error.responseJSON.jabatan[0]);
                }

                if(error.responseJSON.id_kelas[0]) {

                    //show alert
                    $('#alert-kelas').removeClass('d-none');
                    $('#alert-kelas').addClass('d-block');

                    //add message to alert
                    $('#alert-kelas').html(error.responseJSON.id_kelas[0]);
                }

            }

        });

    });

</script>
