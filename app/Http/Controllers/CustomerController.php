<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Barang;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userLogin = auth()->user();
        if($userLogin['role'] !== 'admin'){
            return response()->json([
                'status' => 404,
                'message' => "Anda bukan admin"
            ], 404);
        }
        $data = Customer::all();
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
    public function postCustomer(Request $request)
    {
        $dataBarang = Barang::where('nama_barang', $request['nama_barang'])->first();
        $data = new Customer();
        $data->nama = $request->input('nama');
        $data->email = $request->input('email');
        $data->no_hp = $request->input('no_hp');
        $data->nama_barang = $request->input('nama_barang');
        $data->jenis = $request->input('jenis');
        $data->ukuran = $request->input('ukuran');
        $data->jml_dibayar = $dataBarang->harga;
        $data->save();

        $dataBarang->stok =  $dataBarang->stok - 1;
        $dataBarang->save();

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
        $data = Customer::find($id);
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
    public function updateCustomer(Request $request, $id)
    {
        $data = new Customer();
        $data = Customer::find($id);
        $data->nama = $request->input('nama') ? $request->input('nama') : $data->nama;
        $data->email = $request->input('email')  ? $request->input('email') :  $data->email;
        $data->no_hp = $request->input('no_hp') ?  $request->input('no_hp') :   $data->no_hp;
        $data->nama_barang = $request->input('nama_barang') ? $request->input('nama_barang') : $data->nama_barang;
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
    public function deleteCustomer($id)
    {
        $data = Customer::where('id', $id)->first();
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