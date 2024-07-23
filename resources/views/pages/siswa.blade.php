{{-- <!doctype html>
<html lang="en"> --}}
    @extends('layouts.app', [
    'namePage' => 'Data Siswa',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'datasiswa',
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
        <div class="panel-header panel-header-sm">

        </div>
    <div class="container" >
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-center">{{  $title }}</h4>
                <div class="card border-0 shadow-sm rounded-md mt-4">
                    <div class="card-body">

                        <a href="javascript:void(0)" class="btn btn-success mb-2" id="btn-create-post">TAMBAH</a>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>No Induk</th>
                                    <th>NISN</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="table-posts">
                                @foreach($siswa as $ssw)
                                <tr id="index_{{ $ssw->id }}">
                                    <td>{{ $ssw->nama }}</td>
                                    <td>{{ $ssw->noinduk }}</td>
                                    <td>{{ $ssw->nisn }}</td>
                                    @if ($ssw->kelas)
                                        <td>{{ $ssw->kelas->nama }} - {{ $ssw->kelas->jurusan }}</td>
                                    @else
                                    <td>Kelas Tidak Ada</td>
                                @endif
                                    <td class="text-center">
                                        <a href="javascript:void(0)" id="btn-edit-post" data-id="{{ $ssw->id }}" class="btn btn-primary btn-sm">EDIT</a>
                                        <a href="javascript:void(0)" id="btn-delete-post" data-id="{{ $ssw->id }}" class="btn btn-danger btn-sm">DELETE</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <nav aria-label="Table Paging" class="mb-0 text-muted">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item{{ ($siswa->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $siswa->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $siswa->lastPage(); $i++)
                                    <li class="page-item{{ ($siswa->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $siswa->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item{{ ($siswa->currentPage() == $siswa->lastPage()) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $siswa->nextPageUrl() }}" aria-label="Next">
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
    @include('components.siswa.modal-create')
    @include('components.siswa.modal-edit')
    @include('components.siswa.delete-post')

    @endsection
</body>
{{--
</html> --}}

