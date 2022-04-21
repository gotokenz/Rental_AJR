<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illmuniate\Support\Facades\Validator;
use App\Model\Car;
use Illmuniate\Validation\Rule;
use Illmuinate\Support\Facades\DB;

class CarController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cars = Car::all();

        if(count($cars) > 0)
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $cars
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
            'id_pemilik' => 'required',
            'nama_mobil' => 'required', 
            'tipe' => 'required', 
            'jenis_transmisi' => 'required', 
            'jenis_bahan_bakar' => 'required', 
            'warna' => 'required',
            'volume_bagasi' => 'required', 
            'fasilitas' => 'required', 
            'kapasitas_penumpang' => 'required | numeric', 
            'plat_nomor' => 'required', 
            'nomor_stnk' => 'required',
            'kategori_aset' => 'required', 
            'harga_sewa' => 'required | numeric', 
            'status_mobil' => 'required', 
            'tgl_servis' => 'required | date', 
            'mulai_kontrak' => 'required | date',
            'selesai_kontrak' => 'required | date', 
            'url_foto' => 'required',
        ]);

        if($validate->fails())
        {
            return response([
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        $cars = Car::create($storeData);

        return response([
            'message' => 'Add Data Success',
            'data' => $cars
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
        $cars = Car::find($id);

        if(!is_null($cars))
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $cars
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 400);
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
        $cars = Car::find($id);

        if (is_null($cars))
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }
        //
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_pemilik' => 'required',
            'nama_mobil' => 'required', 
            'tipe' => 'required', 
            'jenis_transmisi' => 'required', 
            'jenis_bahan_bakar' => 'required', 
            'warna' => 'required',
            'volume_bagasi' => 'required', 
            'fasilitas' => 'required', 
            'kapasitas_penumpang' => 'required | numeric', 
            'plat_nomor' => 'required', 
            'nomor_stnk' => 'required',
            'kategori_aset' => 'required', 
            'harga_sewa' => 'required | numeric', 
            'status_mobil' => 'required', 
            'tgl_servis' => 'required | date', 
            'mulai_kontrak' => 'required | date',
            'selesai_kontrak' => 'required | date', 
            'url_foto' => 'required',
        ]);

        if ($validate->fails())
        {
            return response([
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        $cars -> id_pemilik = $updateData['id_pemilik'];
        $cars -> nama_mobil = $updateData['nama_mobil'];
        $cars -> tipe = $updateData['tipe'];
        $cars -> jenis_transmisi = $updateData['jenis_transmisi'];
        $cars -> jenis_bahan_bakar = $updateData['jenis_bahan_bakar'];
        $cars -> warna = $updateData['warna'];
        $cars -> volume_bagasi = $updateData['volume_bagasi'];
        $cars -> fasilitas = $updateData['fasilitas'];
        $cars -> kapasitas_penumpang = $updateData['kapasitas_penumpang'];
        $cars -> plat_nomor = $updateData['plat_nomor'];
        $cars -> nomor_stnk = $updateData['nomor_stnk'];
        $cars -> kategori_aset = $updateData['kategori_aset'];
        $cars -> harga_sewa = $updateData['harga_sewa'];
        $cars -> status_mobil = $updateData['status_mobil'];
        $cars -> tgl_servis = $updateData['tgl_servis'];
        $cars -> mulai_kontrak = $updateData['mulai_kontrak'];
        $cars -> selesai_kontrak = $updateData['selesai_kontrak'];
        $cars -> url_foto = $updateData['url_foto'];

        if($cars->save())
        {
            return response([
                'message' => 'Update Success',
                'data' => $cars
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
        $cars = Car::find($id);

        if (is_null($cars)) 
        {
            $cars->delete();
            return response([
                'message' => 'Data Not Found',
                'data' => $cars
            ], 404);
        }

        if ($cars->delete()) 
        {
            return response([
                'message' => 'Delete Success',
                'data' => $cars
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data' => null
        ], 400);
    }

    public function showAvailable() {
        $cars = Car::where('status_mobil', 'Available')->get();

        if (!is_null($cars)) 
        {
            return response([
                'message' => 'Success',
                'data' => $cars
            ], 200);
        }

        return response([
            'message' => 'Mobil Not Found',
            'data' => null
        ], 400);
    }

    public function showPeriodeContract() 
    {
        $cars = Car::where('kategori_aset', 'Aset Mitra')
                    ->whereRaw('DATEDIFF(selesai_kontrak, now()) < ?', [120])
                    ->get();

        if (!is_null($cars)) 
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $cars
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
    }

    public function updatePeriodeContract($id, Request $request) 
    {
        $cars = Car::find($id);

        if (is_null($cars)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => $cars
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'mulai_kontrak' => 'required',
            'selesai_kontrak' => 'required',
        ]);

        if($validate->fails()){
            return response([
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        $cars->mulai_kontrak = $updateData['mulai_kontrak'];
        $cars->selesai_kontrak = $updateData['selesai_kontrak'];

        if($cars->save())
        {
            return response([
                'message' => 'Update Success',
                'data' => $cars
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data' => null
        ], 400);
    }
}
