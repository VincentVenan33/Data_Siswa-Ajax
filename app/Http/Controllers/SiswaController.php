<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts from Models
        $siswa = Siswa::with('kelas')
        ->join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
        ->select('siswas.*', 'kelas.nama as kelas_nama', 'kelas.jurusan as kelas_jurusan')
        ->orderBy('kelas.nama')
        ->orderBy('kelas.jurusan')
        ->paginate(10);
        $data = [
            'title' => "Data Siswa",
            'users' => $siswa
        ];
        //return view with data
        return view('pages/siswa', compact('siswa'), $data);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'     => 'required',
            'noinduk'   => 'required',
            'nisn'   => 'required',
            'id_kelas'   => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Siswa::create([
            'nama'     => $request->nama,
            'noinduk'   => $request->noinduk,
            'nisn'   => $request->nisn,
            'id_kelas'   => $request->id_kelas
        ]);

        $post->load('kelas');

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $post
        ]);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(Siswa $siswa)
    {
        //return response
        $siswa->load('kelas');

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Siswa',
            'data'    => $siswa
        ]);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Siswa $siswa)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'     => 'required',
            'noinduk'   => 'required',
            'nisn'   => 'required',
            'id_kelas'   => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $siswa->update([
            'nama'     => $request->nama,
            'noinduk'   => $request->noinduk,
            'id_kelas'   => $request->id_kelas
        ]);

        $siswa->load('kelas');

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $siswa
        ]);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //delete post by ID
        Siswa::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Siswa Berhasil Dihapus!.',
        ]);
    }
}