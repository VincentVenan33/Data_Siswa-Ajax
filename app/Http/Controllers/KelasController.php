<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule as ValidationRule;

class KelasController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts from Models
        $data = array();
        $kelas = Kelas::latest()->paginate(10);
        $data['title'] = "Data Kelas";
        $data['users'] = $kelas;
        //return view with data
        return view('pages/kelas', compact('kelas'), $data);
    }

        public function carikelas()
    {
        $kelas = Kelas::orderBy('nama', 'asc')->orderBy('jurusan', 'asc')->get();
        return response()->json(['data' => $kelas]);
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
            'jurusan'   => 'required',
            'jurusan'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $post = Kelas::create([
            'nama'     => $request->nama,
            'jurusan'   => $request->jurusan
        ]);

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
    public function show($id)
    {

            $kelas = Kelas::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Detail Data Kelas',
                'data' => $kelas,
            ]);
    }
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                ValidationRule::unique('kelas')->ignore($kelas->id),
            ],
            'jurusan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kelas->update($request->only('nama', 'jurusan'));

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diupdate!',
            'data' => $kelas
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
        Kelas::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Kelas Berhasil Dihapus!.',
        ]);
    }
}