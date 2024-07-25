@extends('layouts.app', [
'namePage' => 'Data Sekolah',
'class' => 'login-page sidebar-mini ',
'activePage' => 'home',
'backgroundImage' => asset('now') . "/img/bg14.jpg",
])
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DS || {{  $title }}</title>
    <style>
        body {
            background-color: lightgray !important;
        }
    </style>
</head>

@section('content')
<body>
    <div class="panel-header panel-header-sm"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-center">{{ $title }}</h4>
                <div class="card border-0 shadow-sm rounded-md mt-4">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="filterKelas" class="control-label">Filter Kelas</label>
                                    <select class="form-control" id="filterKelas"></select>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kelas"></div>
                                </div>
                                <div class="col-md-4">
                                    <button id="btnAllData" class="btn btn-success mt-4"><i class="now-ui-icons arrows-1_refresh-69"></i></button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>No. Induk</th>
                                    <th>NISN</th>
                                    <th>Nama Guru</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->noinduk }}</td>
                                    <td>{{ $item->nisn }}</td>
                                    <td>{{ $item->nama_guru }}</td>
                                    <td>{{ $item->nip }}</td>
                                    <td>{{ $item->jabatan }}</td>
                                    <td>{{ $item->nama_jurusan }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <nav aria-label="Table Paging" class="mb-0 text-muted" id="pagination-nav">
                            <ul class="pagination justify-content-center mb-0" id="pagination">
                                <li class="page-item{{ ($data->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $data->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $data->lastPage(); $i++)
                                    <li class="page-item{{ ($data->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item{{ ($data->currentPage() == $data->lastPage()) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $data->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
        // Load categories into the filter dropdown
        $.ajax({
            url: '/carikelas', // Menggunakan route yang telah didefinisikan
            type: 'GET',
            success: function(response) {
                let kelasDropdown = $('#filterKelas');
                kelasDropdown.empty(); // Clear existing options

                // Add default option
                kelasDropdown.append('<option selected="true" disabled="disabled">Pilih Kelas Buku</option>');

                // Populate dropdown with data from response
                response.data.forEach(function(kelas) {
                    let option = `<option value="${kelas.nama} - ${kelas.jurusan}">${kelas.nama} - ${kelas.jurusan}</option>`;
                    kelasDropdown.append(option);
                });
            },
            error: function(error) {
                console.error('Error fetching kelas data', error);
            }
        });
    // Handler untuk filter kelas
    $('#filterKelas').change(function(e) {
        e.preventDefault();
        fetchFilteredData($(this).val());
        $('#pagination-nav').hide();
    });

    // Handler untuk tombol "All Data"
    $('#btnAllData').click(function(e) {
        e.preventDefault();
        // Set filterKelas ke nilai default
        $('#filterKelas').val('Pilih Kelas');
        fetchAllData();
        $('#pagination-nav').show();
    });

    function fetchFilteredData(selectedKelas) {
    let token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
        url: '{{ route("filterData") }}',
        type: 'GET',
        cache: false,
        data: {
            kelas: selectedKelas,
            _token: token
        },
        success: function(response) {
            console.log("AJAX Response:", response); // Debugging

            $('#dataTable tbody').empty();

            if (response.data.length > 0) {
                $.each(response.data, function(index, item) {
                    var row = '<tr>' +
                                '<td>' + item.nama + '</td>' +
                                '<td>' + item.noinduk + '</td>' +
                                '<td>' + item.nisn + '</td>' +
                                '<td>' + item.nama_guru + '</td>' +
                                '<td>' + item.nip + '</td>' +
                                '<td>' + item.jabatan + '</td>' +
                                '<td>' + item.nama_jurusan + '</td>' +
                                '</tr>';
                    $('#dataTable tbody').append(row);
                });
            } else {
                var row = '<tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>';
                $('#dataTable tbody').append(row);
            }

            $('#pagination-nav').show(); // Show pagination after data is loaded
            $('#filterKelas').val('Pilih Kelas');
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
}

function fetchAllData() {
    let token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
        url: '{{ route("alldata") }}',
        type: 'GET',
        cache: false,
        data: {
            _token: token
        },
        success: function(response) {
            console.log("AJAX Response:", response); // Debugging

            // Empty existing table rows
            $('#dataTable tbody').empty();

            // Populate table with new data
            if (response.data.length > 0) {
                $.each(response.data, function(index, item) {
                    var row = '<tr>' +
                                '<td>' + item.nama + '</td>' +
                                '<td>' + item.noinduk + '</td>' +
                                '<td>' + item.nisn + '</td>' +
                                '<td>' + item.nama_guru + '</td>' +
                                '<td>' + item.nip + '</td>' +
                                '<td>' + item.jabatan + '</td>' +
                                '<td>' + item.nama_jurusan + '</td>' +
                                '</tr>';
                    $('#dataTable tbody').append(row);
                });
            } else {
                var row = '<tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>';
                $('#dataTable tbody').append(row);
            }

            // Update pagination
            $('#pagination').html(response.pagination);
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
}

});
    </script>

@endsection
</body>
