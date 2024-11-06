<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenjualanModel;

class PenjualanController extends Controller
{
    // Mengambil semua data penjualan
    public function index()
    {
        return PenjualanModel::all();
    }

    // Menyimpan data penjualan baru
    public function store(Request $request)
    {
        $penjualan = PenjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'image' => $request->image->hashName()
        ]);

        return response()->json($penjualan, 201);
    }

    // Menampilkan detail data penjualan berdasarkan ID
    public function show(PenjualanModel $penjualan)
    {
        return response()->json($penjualan);
    }

    // Memperbarui data penjualan
    public function update(Request $request, PenjualanModel $penjualan)
    {
        $penjualan->update($request->all());
        return response()->json($penjualan);
    }

    // Menghapus data penjualan
    public function destroy(PenjualanModel $penjualan)
    {
        $penjualan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data penjualan berhasil dihapus',
        ]);
    }
}
