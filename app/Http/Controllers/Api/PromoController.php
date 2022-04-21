<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Promo;
use Illuminate\Validation\Rule;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $promos = Promo::all();

        if(count($promos) > 0)
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $promos
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
        $validate = Validator::make($storeData, [
            'kode_promo' => 'required|unique:promo',
            'jenis_promo' => 'required',
            'keterangan' => 'required',
            'diskon' => 'required',
            'status_promo' => 'required'
        ]);

        if ($validate->fails()) 
        {
            return response([
                'message' => 'Validation Failed',
                'data' => $validate->errors()
            ], 400);
        }

        $promos = Promo::create($storeData);

        return response([
            'message' => 'Add Data Success',
            'data' => $promos
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $promos = Promo::find($id);

        if (!is_null($promos)) 
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $promos
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
        $promos = Promo::find($id);

        if (is_null($promos)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'kode_promo' => ['required', Rule::unique('promos')->ignore($promos)],
            'jenis_promo' => 'required',
            'keterangan' => 'required',
            'diskon' => 'required',
            'status_promo' => 'required'
        ]);

        if($validate->fails())
        {
            return response([
                'message' => 'Validation Failed',
                'data' => $validate->errors()
            ], 400);
        }

        $promos->kode_promo = $updateData['kode_promo'];
        $promos->jenis_promo = $updateData['jenis_promo'];
        $promos->keterangan = $updateData['keterangan'];
        $promos->diskon = $updateData['diskon'];
        $promos->status_promo = $updateData['status_promo'];
        
        if ($promos->save()) 
        {
            return response([
                'message' => 'Update Success',
                'data' => $promos
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
        $promos = Promo::find($id);

        if (is_null($promos)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $promos->status_promo = 'Tidak Aktif';

        if ($promos->save()) 
        {
            return response([
                'message' => 'Delete Success',
                'data' => $promos
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data' => null
        ], 400);
    }

    public function showActive() {
        $promos = Promo::where('status_promo', 'Aktif')->get();

        if(!is_null($promos))
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $promos
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
    }
}
