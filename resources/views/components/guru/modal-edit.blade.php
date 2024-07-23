<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="post_id">

                <div class="form-group">
                    <label for="name" class="control-label">Nama</label>
                    <input type="text" class="form-control" id="nama-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-edit"></div>
                </div>


                <div class="form-group">
                    <label class="control-label">NIP</label>
                    <input type="text" class="form-control" id="nip-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nip-edit"></div>
                </div>

                <div class="form-group">
                    <label class="control-label">jabatan</label>
                    <input type="text" class="form-control" id="jabatan-edit">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jabatan-edit"></div>
                </div>

                <div class="form-group">
                    <label for="kelas" class="control-label">Kelas</label>
                    <select class="form-control" id="kelas-edit">

                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kelas-edit"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="button" class="btn btn-primary" id="update">UPDATE</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    document.getElementById('nip-edit').addEventListener('input', function(event) {
        this.value = this.value.replace(/[^0-9]/g, '');
        this.value = this.value.substring(0, 18);
    });
    $('body').on('click', '#btn-edit-post', function () {

        let post_id = $(this).data('id');

        //fetch detail post with ajax
        $.ajax({
            url: `/guru/${post_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#post_id').val(response.data.id);
                $('#nama-edit').val(response.data.nama);
                $('#nip-edit').val(response.data.nip);
                $('#jabatan-edit').val(response.data.jabatan);

                //open modal
                $('#modal-edit').modal('show');
                $.ajax({
                    url: '/carikelas',
                    type: 'GET',
                    success: function(kelasResponse) {
                        let kelasDropdown = $('#kelas-edit');
                        kelasDropdown.empty(); // Clear existing options

                        // Populate dropdown with data from response
                        kelasResponse.data.forEach(function(kelas) {
                            let option = `<option value="${kelas.id}" ${kelas.id === response.data.id_kelas ? 'selected' : ''}>${kelas.nama} - ${kelas.jurusan}</option>`;
                            kelasDropdown.append(option);
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching kelas data', error);
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching siswa data', error);
            }
        });
    });

    //action update post
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let post_id = $('#post_id').val();
        let nama   = $('#nama-edit').val();
        let nip = $('#nip-edit').val();
        let jabatan = $('#jabatan-edit').val();
        let id_kelas = $('#kelas-edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");

        //ajax
        $.ajax({

            url: `/guru/${post_id}`,
            type: "PUT",
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
                    timer: 3000
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
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a></td>
                        </td>
                    </tr>
                `;

                //append to post data
                $(`#index_${response.data.id}`).replaceWith(post);

                //close modal
                $('#modal-edit').modal('hide');


            },
            error:function(error){

                if(error.responseJSON.nama[0]) {

                    //show alert
                    $('#alert-nama-edit').removeClass('d-none');
                    $('#alert-nama-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-nama-edit').html(error.responseJSON.nama[0]);
                }

                if(error.responseJSON.nip[0]) {

                    //show alert
                    $('#alert-nip-edit').removeClass('d-none');
                    $('#alert-nip-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-nip-edit').html(error.responseJSON.nip[0]);
                }

                if(error.responseJSON.jabatan[0]) {

                    //show alert
                    $('#alert-jabatan-edit').removeClass('d-none');
                    $('#alert-jabatan-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-jabatan-edit').html(error.responseJSON.jabatan[0]);
                }

                if(error.responseJSON.id_kelas[0]) {

                    //show alert
                    $('#alert-kelas-edit').removeClass('d-none');
                    $('#alert-kelas-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-kelas-edit').html(error.responseJSON.id_kelas[0]);
                }

            }

        });

    });

</script>
