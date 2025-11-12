<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaporanOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanApiController extends Controller
{
    // GET /api/laporan-online
    public function index()
    {
        return response()->json(LaporanOnline::all(), 200);
    }

    // POST /api/laporan-online
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'alamat', 'deskripsi', 'tanggal']);

        if ($request->hasFile('foto')) {
            $fileName = time().'_'.$request->foto->getClientOriginalName();
            $request->foto->storeAs('public/foto', $fileName);
            $data['foto'] = $fileName;
        }

        $laporan = LaporanOnline::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Laporan online berhasil dibuat',
            'data' => $laporan
        ], 201);
    }

    // GET /api/laporan-online/{id}
    public function show($id)
    {
        $laporan = LaporanOnline::find($id);

        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['status' => true, 'data' => $laporan], 200);
    }

    // PUT /api/laporan-online/{id}
    public function update(Request $request, $id)
    {
        $laporan = LaporanOnline::find($id);

        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama', 'alamat', 'deskripsi', 'tanggal']);

        if ($request->hasFile('foto')) {
            if ($laporan->foto && Storage::exists('public/foto/'.$laporan->foto)) {
                Storage::delete('public/foto/'.$laporan->foto);
            }
            $fileName = time().'_'.$request->foto->getClientOriginalName();
            $request->foto->storeAs('public/foto', $fileName);
            $data['foto'] = $fileName;
        }

        $laporan->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Laporan online berhasil diperbarui',
            'data' => $laporan
        ], 200);
    }

    // DELETE /api/laporan-online/{id}
    public function destroy($id)
    {
        $laporan = LaporanOnline::find($id);

        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        if ($laporan->foto && Storage::exists('public/foto/'.$laporan->foto)) {
            Storage::delete('public/foto/'.$laporan->foto);
        }

        $laporan->delete();

        return response()->json(['status' => true, 'message' => 'Laporan online berhasil dihapus'], 200);
    }
}
