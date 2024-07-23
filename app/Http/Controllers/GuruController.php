<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts from Models
        $guru = guru::with('kelas')
        ->join('kelas', 'gurus.id_kelas', '=', 'kelas.id')
        ->select('gurus.*', 'kelas.nama as kelas_nama', 'kelas.jurusan as kelas_jurusan')
        ->orderBy('kelas.nama')
        ->orderBy('kelas.jurusan')
        ->paginate(10);
        $data = [
            'title' => "Data Guru",
            'users' => $guru
        ];
        //return view with data
        return view('pages/guru', compact('guru'), $data);
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
            'nip'   => 'required',
            'jabatan'   => 'required',
            'id_kelas'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Guru::create([
            'nama'     => $request->nama,
            'nip'   => $request->nip,
            'jabatan'   => $request->jabatan,
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
    public function show(Guru $guru)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Guru',
            'data'    => $guru
        ]);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Guru $guru)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'     => 'required',
            'nip'   => 'required',
            'jabatan'   => 'required',
            'id_kelas'   => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $guru->update([
            'nama'     => $request->nama,
            'nip'   => $request->nip,
            'jabatan'   => $request->jabatan,
            'id_kelas'   => $request->id_kelas
        ]);

        $guru->load('kelas');

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $guru
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
        Guru::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Guru Berhasil Dihapus!.',
        ]);
    }
}