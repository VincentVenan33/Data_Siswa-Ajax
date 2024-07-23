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
                                    <label for="filterKelas">Filter by Kelas:</label>
                                    <select id="filterKelas" class="form-control" style="width: 100%;">
                                        <option selected="true" disabled="disabled">Pilih Kelas</option>
                                        @foreach(['1A - IPA', '1B - IPA', '1C - IPA', '1A - IPS', '1B - IPS', '1C - IPS', '1A - BAHASA', '1B - BAHASA', '1C - BAHASA', '2A - IPA', '2B - IPA', '2C - IPA', '2A - IPS', '2B - IPS', '2C - IPS', '2A - BAHASA', '2B - BAHASA', '2C - BAHASA', '3A - IPA', '3B - IPA', '3C - IPA', '3A - IPS', '3B - IPS', '3C - IPS', '3A - BAHASA', '3B - BAHASA', '3C - BAHASA'] as $kelas)
                                            <option value="{{ $kelas }}">{{ $kelas }}</option>
                                        @endforeach
                                    </select>
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
                        <nav aria-label="Table Paging" class="mb-0 text-muted">
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
        document.addEventListener('DOMContentLoaded', function () {
            // Handler untuk filter kelas
            $('#filterKelas').change(function (e) {
                e.preventDefault();
                fetchFilteredData($(this).val());
            });

            // Handler untuk tombol "All Data"
            $('#btnAllData').click(function (e) {
                e.preventDefault();
                // Set filterKelas ke nilai default
                $('#filterKelas').val('Pilih Kelas');
                fetchAllData();
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
                    success: function (response) {
                        console.log("AJAX Response:", response); // Debugging

                        // Kosongkan baris tabel yang ada
                        $('#dataTable tbody').empty();
                        $('#pagination').empty();

                        // Perbarui baris tabel
                        if (response.data.length > 0) {
                            $.each(response.data, function (index, item) {
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
                            // Tampilkan pesan jika tidak ada data
                            var row = '<tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>';
                            $('#dataTable tbody').append(row);
                        }

                        // Perbarui paginasi (jika ada)
                        if (response.pagination) {
                            $('#pagination').html(response.pagination);
                        }
                    },
                    error: function (xhr, status, error) {
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
                    success: function (response) {
                        console.log("AJAX Response:", response); // Debugging

                        // Kosongkan baris tabel yang ada
                        $('#dataTable tbody').empty();
                        $('#pagination').empty();

                        // Perbarui baris tabel
                        if (response.data.length > 0) {
                            $.each(response.data, function (index, item) {
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
                            // Tampilkan pesan jika tidak ada data
                            var row = '<tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>';
                            $('#dataTable tbody').append(row);
                        }

                        // Perbarui paginasi (jika ada)
                        if (response.pagination) {
                            $('#pagination').html(response.pagination);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            }
        });
    </script>

@endsection
</body>
