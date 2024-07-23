<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
{
    $data = Siswa::select(
        'siswas.nama',
        'siswas.noinduk',
        'siswas.nisn',
        DB::raw("CONCAT(kelas.nama, ' - ', kelas.jurusan) AS nama_jurusan"),
        'gurus.nama AS nama_guru',
        'gurus.nip',
        'gurus.jabatan'
    )
    ->join('kelas', 'kelas.id', '=', 'siswas.id_kelas')
    ->join('gurus', 'gurus.id_kelas', '=', 'kelas.id')
    ->orderByRaw("CAST(SUBSTRING_INDEX(kelas.nama, '-', 1) AS UNSIGNED), kelas.jurusan, kelas.nama")
    ->paginate(10);

    return view('pages.home', [
        'title' => 'Data Sekolah',
        'data' => $data]);
}

public function filterData(Request $request)
{
    $query = Siswa::select(
        'siswas.nama',
        'siswas.noinduk',
        'siswas.nisn',
        DB::raw("CONCAT(kelas.nama, ' - ', kelas.jurusan) AS nama_jurusan"),
        'gurus.nama AS nama_guru',
        'gurus.nip',
        'gurus.jabatan'
    )
    ->join('kelas', 'kelas.id', '=', 'siswas.id_kelas')
    ->join('gurus', 'gurus.id_kelas', '=', 'kelas.id');

    if ($request->has('kelas') && $request->kelas !== '') {
        $query->where(DB::raw("CONCAT(kelas.nama, ' - ', kelas.jurusan)"), $request->kelas);
    }

    $data = $query->orderByRaw("CAST(SUBSTRING_INDEX(kelas.nama, '-', 1) AS UNSIGNED), kelas.jurusan, kelas.nama")
                 ->paginate(10);

    return response()->json([
        'data' => $data->items(),
        'pagination' => $data->links()->toHtml(),
    ]);
}

public function alldata(Request $request)
{
    $data = Siswa::select(
        'siswas.nama',
        'siswas.noinduk',
        'siswas.nisn',
        DB::raw("CONCAT(kelas.nama, ' - ', kelas.jurusan) AS nama_jurusan"),
        'gurus.nama AS nama_guru',
        'gurus.nip',
        'gurus.jabatan'
    )
    ->join('kelas', 'kelas.id', '=', 'siswas.id_kelas')
    ->join('gurus', 'gurus.id_kelas', '=', 'kelas.id')
    ->orderByRaw("CAST(SUBSTRING_INDEX(kelas.nama, '-', 1) AS UNSIGNED), kelas.jurusan, kelas.nama")
    ->paginate(10);

    return response()->json([
        'data' => $data->items(),
        'pagination' => $data->links()->toHtml(),
    ]);
}

}