<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $transactions = Transaction::all();

        if(count($transactions) > 0)
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $transactions
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
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
    public function store(Request $request)
    {
        //
        $storeData = $request->all();

        $orderDate = date('ymd');
        $idJenisSewa = 0;

        if ($storeData['jenis_sewa'] === 'Sewa Mobil & Driver')
        {
            $idJenisSewa = 1;
        }

        else if ($storeData['jenis_sewa'] === 'Sewa Mobil')
        {
            $idJenisSewa = 0;
        }

        $idLastSewa = DB::table('transactions')->latest()->first();
        if (is_null($idLastSewa))
        {
            $idLastSewa = 0;
        }

        $idSewa = $idLastSewa  + 1;
        $storeData['id_transaksi'] = 'TRN'.$orderDate.'0'.$idJenisSewa.'-'.$idSewa;

        $validate = Validator::make($storeData, [
            'id_transaksi' => 'required | unique:transactions',
            'id_pegawai' => 'required',
            'id_customer' => 'required',
            'id_driver' => 'required',
            'id_aset_mobil' => 'required',
            'id_promo' => 'required',
            'jenis_sewa' => 'required',
            'tgl_transaksi' => 'required | date',
            'tgl_mulai_sewa' => 'required | date',
            'tgl_selesai_sewa' => 'required | date',
            'tgl_pengembalian' => 'required | date',
            'total_harga_sewa' => 'required | numeric',
            'status_transaksi' => 'required',
            'tgl_bayar' => 'required | date',
            'metode_bayar' => 'required',
            'total_diskon' => 'required | numeric',
            'total_denda' => 'required | numeric',
            'total_harga' => 'required | numeric',
            'url_bukti_pembayaran' => 'required',
            'rating_driver' => 'required | numeric',
            'rating_perusahaan' => 'required | numeric'
        ]);

        if ($validate->fails())
        {
            return response([
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        $transactions = Transaction::create($storeData);

        return response([
            'message' => 'Add Data Success',
            'data' => $transactions
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showbyIdTransaction($id)
    {
        //
        $transactions = Transaction::where('id_transaction', $id)->get();

        if(!is_null($transactions))
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $transactions
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
    }

    public function showbyIdCustomer($id)
    {
        //
        $transactions = Transaction::where('id_customer', $id)->get();

        if(!is_null($transactions))
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $transactions
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
    }

    public function showbyIdDriver($id)
    {
        //
        $transactions = Transaction::where('id_driver', $id)->get();

        if(!is_null($transactions))
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $transactions
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
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
    public function update(Request $request, $id)
    {
        //
        $transactions = Transaction::where('id_transaksi', $id)->first();

        if (is_null($transactions))
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_transaksi' => ['required', Rule::unique('transactions')->ignore($transactions)],
            'id_pegawai' => 'required',
            'id_customer' => 'required',
            'id_driver' => 'required',
            'id_aset_mobil' => 'required',
            'id_promo' => 'required',
            'jenis_sewa' => 'required',
            'tgl_transaksi' => 'required | date',
            'tgl_mulai_sewa' => 'required | date',
            'tgl_selesai_sewa' => 'required | date',
            'tgl_pengembalian' => 'required | date',
            'total_harga_sewa' => 'required | numeric',
            'status_transaksi' => 'required',
            'tgl_bayar' => 'required | date',
            'metode_bayar' => 'required',
            'total_diskon' => 'required | numeric',
            'total_denda' => 'required | numeric',
            'total_harga' => 'required | numeric',
            'url_bukti_pembayaran' => 'required',
            'rating_driver' => 'required | numeric',
            'rating_perusahaan' => 'required | numeric'
        ]);

        if ($validate->fails())
        {
            return response([
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        $transactions->id_pegawai = $updateData['id_pegawai'];
        $transactions->id_customer = $updateData['id_customer'];
        $transactions->id_driver = $updateData['id_driver'];
        $transactions->id_aset_mobil = $updateData['id_aset_mobil'];
        $transactions->id_promo = $updateData['id_promo'];
        $transactions->jenis_sewa = $updateData['jenis_sewa'];
        $transactions->tgl_transaksi = $updateData['tgl_transaksi'];
        $transactions->tgl_mulai_sewa = $updateData['tgl_mulai_sewa'];
        $transactions->tgl_selesai_sewa = $updateData['tgl_selesai_sewa'];
        $transactions->tgl_pengembalian = $updateData['tgl_pengembalian'];
        $transactions->total_harga_sewa = $updateData['total_harga_sewa'];
        $transactions->status_transaksi = $updateData['status_transaksi'];
        $transactions->tgl_bayar = $updateData['tgl_bayar'];
        $transactions->metode_bayar = $updateData['metode_bayar'];
        $transactions->total_diskon = $updateData['total_diskon'];
        $transactions->total_denda = $updateData['total_denda'];
        $transactions->total_harga = $updateData['total_harga'];
        $transactions->url_bukti_pembayaran = $updateData['url_bukti_pembayaran'];
        $transactions->rating_driver = $updateData['rating_driver'];
        $transactions->rating_perusahaan = $updateData['rating_perusahaan'];

        if($transactions->save())
        {
            return response([
                'message' => 'Update Success',
                'data' => $transactions
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data' => null
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $transactions = Transaction::where('id_transaksi', $id)->get();

        if(is_null($transactions))
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        if($transactions->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data' => $transactions
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data' => null
        ], 400);
    }
}
