<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index() {
        $laporans = Laporan::all();
        return view('laporan.index', compact('laporans'));
    }

    public function create() {
        return view('laporan.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $fileName = time().'_'.$request->foto->getClientOriginalName();
            $request->foto->storeAs('public/foto', $fileName);
            $data['foto'] = $fileName;
        }

        Laporan::create($data);
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan');
    }

    public function edit($id) {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.edit', compact('laporan'));
    }

    public function update(Request $request, $id) {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada
            if ($laporan->foto && Storage::exists('public/foto/'.$laporan->foto)) {
                Storage::delete('public/foto/'.$laporan->foto);
            }
            $fileName = time().'_'.$request->foto->getClientOriginalName();
            $request->foto->storeAs('public/foto', $fileName);
            $data['foto'] = $fileName;
        }

        $laporan->update($data);
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui');
    }

    public function destroy($id) {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->foto && Storage::exists('public/foto/'.$laporan->foto)) {
            Storage::delete('public/foto/'.$laporan->foto);
        }

        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus');
    }
}
