<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanApiController extends Controller
{
    // GET /api/laporans
    public function index()
    {
        return response()->json(Laporan::all(), 200);
    }

    // POST /api/laporans
    public function store(Request $request)
    {
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

        $laporan = Laporan::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Laporan berhasil ditambahkan',
            'data' => $laporan
        ], 201);
    }

    // GET /api/laporans/{id}
    public function show($id)
    {
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['status' => true, 'data' => $laporan], 200);
    }

    // PUT /api/laporans/{id}
    public function update(Request $request, $id)
    {
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

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
            'message' => 'Laporan berhasil diperbarui',
            'data' => $laporan
        ], 200);
    }

    // DELETE /api/laporans/{id}
    public function destroy($id)
    {
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        if ($laporan->foto && Storage::exists('public/foto/'.$laporan->foto)) {
            Storage::delete('public/foto/'.$laporan->foto);
        }

        $laporan->delete();

        return response()->json(['status' => true, 'message' => 'Laporan berhasil dihapus'], 200);
    }
}
