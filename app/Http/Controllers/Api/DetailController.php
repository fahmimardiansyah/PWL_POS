<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailModel;

class DetailController extends Controller
{
    // Mengambil semua data detail penjualan
    public function index()
    {
        return DetailModel::all();
    }

    // Menyimpan data detail penjualan baru
    public function store(Request $request)
    {
        $detail = DetailModel::create([
            'penjualan_id' => $request->penjualan_id,
            'barang_id' => $request->barang_id,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah
        ]);

        return response()->json($detail, 201);
    }

    // Menampilkan detail penjualan berdasarkan ID
    public function show(DetailModel $detail)
    {
        return response()->json($detail);
    }

    // Memperbarui data detail penjualan
    public function update(Request $request, DetailModel $detail)
    {
        $detail->update($request->all());
        return response()->json($detail);
    }

    // Menghapus data detail penjualan
    public function destroy(DetailModel $detail)
    {
        $detail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data detail penjualan berhasil dihapus',
        ]);
    }
}

