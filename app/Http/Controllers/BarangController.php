<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Barang::all();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postBarang(Request $request)
    {
        $userLogin = auth()->user();
        if($userLogin['role'] !== 'admin'){
            return response()->json([
                'status' => 404,
                'message' => "Anda bukan admin"
            ], 404);
        }
        $data = new Barang();
        $data->nama_barang = $request->input('nama_barang');
        $data->harga = $request->input('harga');
        $data->lokasi = $request->input('lokasi');
        $data->stok = $request->input('stok');
        $data->jenis = $request->input('jenis');
        $data->ukuran = $request->input('ukuran');
        $data->save();

        return response()->json([
            'status' => 201, 
            'data' => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getById($id)
    {
        $data = Barang::find($id);
        if ($data) {
            return response()->json([
                'status' => 200, 
                'message' => "Success get data",
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message'=> 'id ' . $id . ' tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBarang(Request $request, $id)
    {
        $userLogin = auth()->user();
        if($userLogin['role'] !== 'admin'){
            return response()->json([
                'status' => 404,
                'message' => "Anda bukan admin"
            ], 404);
        }
        $data = new Barang();
        $data = Barang::find($id);
        $data->nama_barang = $request->input('nama_barang') ? $request->input('nama_barang') : $data->nama_barang;
        $data->harga = $request->input('harga') ? $request->input('harga') : $data->harga;
        $data->lokasi = $request->input('lokasi') ? $request->input('lokasi') :  $data->lokasi;
        $data->stok = $request->input('stok') ? $request->input('stok') : $data->stok;
        $data->jenis = $request->input('jenis') ? $request->input('jenis') :  $data->jenis;
        $data->ukuran = $request->input('ukuran') ? $request->input('ukuran') : $data->ukuran;
        $data->save();

        return response()->json([
            'status' => 201, 
            'data' => $data
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteBarang($id)
    {
        $userLogin = auth()->user();
        if($userLogin['role'] !== 'admin'){
            return response()->json([
                'status' => 404,
                'message' => "Anda bukan admin"
            ], 404);
        }
        $data = Barang::where('id', $id)->first();
        if($data){
            $data->delete();
            return response()->json([
                'status' => 200, 
                'message'=> 'id ' . $id . ' berhasil di hapus',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'id' . $id . ' tidak ditemukan'
            ], 404);
        }
    }
}