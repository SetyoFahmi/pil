<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jumlah_halaman = 2;
        $mahasiswa = Mahasiswa::orderBy('npm', 'asc')->paginate(3);
        $no = 1;
        return view('mahasiswa.index', compact('mahasiswa', 'no'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'npm' => 'required|numeric|unique:mahasiswa,npm',
            'nama_mahasiswa' => 'required',
            'jk' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required'
        ], [
            'npm.required' => 'NPM tidak boleh kosong!',
            'npm.numeric' => 'NPM harus diisi dalam bentuk angka',
            'npm.unique' => 'NPM sudah ada sebelumnya',
            'nama_mahasiswa.required' => 'Nama Mahasiswa tidak boleh kosong!',
            'jk.required' => 'Jenis Kelamin tidak boleh kosong!',
            'tgl_lahir.required' => 'Tanggal Lahir tidak boleh kosong!',
            'alamat.required' => 'Alamat tidak boleh kosong!'
        ]);

        $data = [
            'npm' => $request->npm,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'jk' => $request->jk,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat
        ];

        Mahasiswa::create($data);
        return redirect('/mahasiswa')->with('success', 'Data Berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Mahasiswa::findOrFail($id);
        return view('mahasiswa.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'npm' => 'required|numeric|unique:mahasiswa,npm,' . $id,
            'nama_mahasiswa' => 'required',
            'jk' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required'
        ], [
            'npm.required' => 'NPM tidak boleh kosong!',
            'npm.numeric' => 'NPM harus diisi dalam bentuk angka',
            'npm.unique' => 'NPM sudah ada sebelumnya',
            'nama_mahasiswa.required' => 'Nama Mahasiswa tidak boleh kosong!',
            'jk.required' => 'Jenis Kelamin tidak boleh kosong!',
            'tgl_lahir.required' => 'Tanggal Lahir tidak boleh kosong!',
            'alamat.required' => 'Alamat tidak boleh kosong!'
        ]);

        $data = [
            'npm' => $request->npm,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'jk' => $request->jk,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat
        ];

        Mahasiswa::where('id', $id)->update($data);
        return redirect('/mahasiswa')->with('success', 'Data Berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus mahasiswa
        $mahasiswa = Mahasiswa::find($id);

        if ($mahasiswa) {
            $mahasiswa->delete();
            return redirect('/mahasiswa')->with('success', 'Data berhasil dihapus!');
        } else {
            return redirect('/mahasiswa')->with('error', 'Data tidak ditemukan!');
        }
    }
}
