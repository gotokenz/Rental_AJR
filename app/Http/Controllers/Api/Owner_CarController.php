<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Owner_Car;
use Illuminate\Validation\Rule;

class Owner_CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $owner_cars = Owner_Car::all();

        if(count($owner_cars) > 0)
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $owner_cars
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
            'status_pemilik' => 'required',
            'nama_pemilik' => 'required',
            'no_ktp' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required | unique:owner_cars'
        ]);

        if ($validate->fails()) 
        {
            return response([
                'message' => 'error',
                'data' => $validate->errors()
            ], 400);
        }

        $owner_cars = Owner_Car::create($storeData);

        return response([
            'message' => 'success',
            'data' => $owner_cars
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
        $owner_cars = Owner_Car::find($id);

        if(!is_null ($owner_cars))
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $owner_cars
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
        $owner_cars = Owner_Car::find($id);

        if (is_null($owner_cars)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'status_pemilik' => 'required',
            'nama_pemilik' => 'required',
            'no_ktp' => 'required',
            'alamat' => 'required',
            'no_telp' => ['required', Rule::unique('owner_cars')->ignore($owner_cars)]
        ]);

        if ($validate->fails()) 
        {
            return response([
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        $owner_cars->nama_pemilik = $updateData['nama_pemilik'];
        $owner_cars->no_ktp = $updateData['no_ktp'];
        $owner_cars->alamat = $updateData['alamat'];
        $owner_cars->no_telp = $updateData['no_telp'];
        
        if ($owner_cars->save()) 
        {
            return response([
                'message' => 'Update Success',
                'data' => $owner_cars
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
        $owner_cars = Owner_Car::find($id);

        if (is_null($owner_cars)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $owner_cars->status_pemilik = 'Tidak Aktif';

        if($owner_cars->save())
        {
            return response([
                'message' => 'Delete Success',
                'data' => $owner_cars
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data' => null
        ], 400);
    }
}
