<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illmuniate\Support\Facades\Validator;
use App\Model\Driver;
use Illmuniate\Validation\Rule;
use Illmuinate\Support\Facades\DB;

class DriverController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $drivers = Driver::all();

        if (count($drivers) > 0) 
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $drivers
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
        $lastDriverId = DB::table('drivers')->latest()->first();
        
        if (is_null($lastDriverId))
        {
            $lastDriverId = 0;
        }

        $driverId = $lastDriverId + 1;
        $storeData['id_driver'] = 'DRV'.$driverRegDate.'-'.$driverId;
        $storeData['status_driver'] = 'Aktif';
        $storeData['password'] = bcrypt($storeData['tgl_lahir']);

        $validate = Validator::make($storeData, [
            'id_driver' => 'required | unique:drivers',
            'nama_driver' => 'required',
            'alamat' => 'required',
            'tgl_lahir' => 'required | date',
            'jenis_kelamin' => 'required',
            'email' => 'required | email:rfc,dns | unique:drivers',
            'no_telp' => 'required | unique:drivers',
            'bahasa' => 'required',
            'status_driver' => 'required',
            'password' => 'required',
            'tarif_driver' => 'required | numeric',
            'rerata_rating' => 'required | numeric',
            'url_sim' => 'required',
            'url_surat_bebas_napza' => 'required',
            'url_surat_kesehata_jiwa' => 'required',
            'url_surat_kesehatan_jasmani' => 'required',
            'url_skck' => 'required',
            'url_foto' => 'required'
        ]);

        if ($validate->fails()) 
        {
            return response([
                'message' => 'Validation Error',
                'data' => null
            ], 400);
        }

        $drivers = Driver::create($storeData);

        return response([
            'message' => 'Add Data Success',
            'data' => $drivers
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
        $driver = Driver::where('id_driver', $id)->first();

        if (!is_null($drivers)) 
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $drivers
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
        $driver = Driver::where('id_driver', $id)->get();

        if (is_null($drivers)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_driver' => ['required', Rule::unique('driver')->ignore($driver)],
            'nama_driver' => 'required',
            'alamat' => 'required',
            'tgl_lahir' => 'required | date',
            'jenis_kelamin' => 'required',
            'email' => ['required', 'email:rfc,dns', Rule::unique('driver')->ignore($driver)],
            'no_telp' => ['required', Rule::unique('driver')->ignore($driver)],
            'bahasa' => 'required',
            'status_driver' => 'required',
            'password' => 'required',
            'tarif_driver' => 'required | numeric',
            'rerata_rating' => 'required | numeric',
            'url_sim' => 'required',
            'url_surat_bebas_napza' => 'required',
            'url_surat_kesehata_jiwa' => 'required',
            'url_surat_kesehatan_jasmani' => 'required',
            'url_skck' => 'required',
            'url_foto' => 'required'
        ]);

        if ($validate->fails()) 
        {
            return response([
                'message' => 'Error'
            ], 400);
        }

        $drivers->nama_driver = $updateData['nama_driver'];
        $drivers->alamat = $updateData['alamat'];
        $drivers->tgl_lahir = $updateData['tgl_lahir'];
        $drivers->jenis_kelamin = $updateData['jenis_kelamin'];
        $drivers->email = $updateData['email'];
        $drivers->no_telp = $updateData['no_telp'];
        $drivers->bahasa = $updateData['bahasa'];
        $drivers->status_driver = $updateData['status_driver'];
        $drivers->password = $updateData['password'];
        $drivers->tarif_driver = $updateData['tarif_driver'];
        $drivers->rerata_rating = $updateData['rerata_rating'];
        $drivers->url_sim = $updateData['url_sim'];
        $drivers->url_surat_bebas_napza = $updateData['url_surat_bebas_napza'];
        $drivers->url_surat_kesehata_jiwa = $updateData['url_surat_kesehata_jiwa'];
        $drivers->url_surat_kesehatan_jasmani = $updateData['url_surat_kesehatan_jasmani'];
        $drivers->url_skck = $updateData['url_skck'];
        $drivers->url_foto = $updateData['url_foto'];

        if ($drivers->save()) 
        {
            return response([
                'message' => 'Update Success',
                'data' => $drivers
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
        $drivers = Driver::where('id_driver', $id)->get();

        if (is_null($drivers)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $drivers->status_driver = 'Non Aktif';

        if($drivers->save())
        {
            return response([
                'message' => 'Delete Success',
                'data' => $drivers
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data' => null
        ], 400);
    }

    public function showAvailable() 
    {
        $drivers = Driver::where('status_driver', 'Available')->get();

        if (is_null($drivers)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        return response([
            'message' => 'Retrieve Success',
            'data' => $drivers
        ], 200);
    }
}
