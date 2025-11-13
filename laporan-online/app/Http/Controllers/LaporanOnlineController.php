<?php

namespace App\Http\Controllers;

use App\Models\LaporanOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanOnlineController extends Controller
{
    public function index()
    {
        $laporans = LaporanOnline::latest()->get();
        return response()->json(['status' => true, 'data' => $laporans]);
    }

    public function show($id)
    {
        $laporan = LaporanOnline::find($id);
        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['status' => true, 'data' => $laporan]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto')) {
            $fileName = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->storeAs('public/foto', $fileName);
            $data['foto'] = $fileName;
        }

        $laporan = LaporanOnline::create($data);
        return response()->json(['status' => true, 'message' => 'Laporan berhasil ditambahkan', 'data' => $laporan]);
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanOnline::find($id);
        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'alamat' => 'sometimes|required|string|max:255',
            'deskripsi' => 'sometimes|required|string',
            'tanggal' => 'sometimes|required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'sometimes|required|string|max:255',
        ]);

        $data = $request->except(['_method']);
        if ($request->hasFile('foto')) {
            if ($laporan->foto && Storage::exists('public/foto/' . $laporan->foto)) {
                Storage::delete('public/foto/' . $laporan->foto);
            }
            $fileName = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->storeAs('public/foto', $fileName);
            $data['foto'] = $fileName;
        }

        $laporan->update($data);
        return response()->json(['status' => true, 'message' => 'Laporan berhasil diperbarui', 'data' => $laporan]);
    }

    public function destroy($id)
    {
        $laporan = LaporanOnline::find($id);
        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        if ($laporan->foto && Storage::exists('public/foto/' . $laporan->foto)) {
            Storage::delete('public/foto/' . $laporan->foto);
        }
        $laporan->delete();
        return response()->json(['status' => true, 'message' => 'Laporan berhasil dihapus']);
    }
}
