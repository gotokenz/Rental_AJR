<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Detail_Schedule;

class Detail_ScheduleController extends Controller
{
    //
    public function index() 
    {
        $detail_schedules = Detail_Schedule::all();
        
        if(count($detail_schedules) > 0) 
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $detail_schedules
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function showByIdPegawai($id) 
    {
        $detail_schedules = Detail_Schedule::where('id_pegawai', $id)->get();
        
        if(!is_null($detail_schedules))
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $detail_schedules
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
    }

    public function showByIdJadwal($id) 
    {
        $detail_schedules = Detail_Schedule::where('id_jadwal', $id)->get();
        
        if(!is_null($detail_schedules)) 
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $detail_schedules
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request) 
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_jadwal' => 'required',
            'id_pegawai' => 'required',
        ]);

        if($validate->fails()) 
        {
            return response([
                'message' => 'Validation Failed',
                'data' => $validate->errors()
            ], 400);
        }

        return response([
            'message' => 'Add Data Success',
            'data' => $detail_schedule
        ], 200);
    }

    public function destroyByIdPegawai($id) 
    {
        $detail_schedule = Detail_Schedule::where('id_pegawai', $id)->delete();
        
        if(is_null($detail_schedule)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        if($detail_schedule->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data' => $detail_schedule
            ], 200);
        }

        return response ([
            'message' => 'Delete Failed',
            'data' => null
        ], 400);
    }

    public function destroyByIdJadwal($id)
    {
        $detail_schedule = Detail_Schedule::where('id_jadwal', $id)->delete();
        
        if(is_null($detail_schedule)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        if($detail_schedule->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data' => $detail_schedule
            ], 200);
        }

        return response ([
            'message' => 'Delete Failed',
            'data' => null
        ], 400);
    }

    public function updateByIdPegawai (Request $request, $id) 
    {
        $detail_schedule = Detail_Schedule::where('id_pegawai', $id)->get();
        
        if(is_null($detail_schedule)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_jadwal' => 'required',
            'id_pegawai' => 'required',
        ]);

        if($validate->fails()) 
        {
            return response([
                'message' => 'error',
                'data' => $validate->errors()
            ], 400);
        }

        $detail_schedule->id_jadwal = $updateData['id_jadwal'];
        $detail_schedule->id_pegawai = $updateData['id_pegawais'];

        if($detail_schedule->save())
        {
            return response([
                'message' => 'Update Success',
                'data' => $detail_schedule
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data' => null
        ], 400);
    }

    public function updateByIdJadwal (Request $request, $id) 
    {
        $detail_schedule = Detail_Schedule::where('id_jadwal', $id)->get();
        
        if(is_null($detail_schedule)) 
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_jadwal' => 'required',
            'id_pegawais' => 'required',
        ]);

        if($validate->fails()) 
        {
            return response([
                'message' => 'Validation Failed',
                'data' => $validate->errors()
            ], 400);
        }

        $detail_schedule->id_jadwal = $updateData['id_jadwal'];
        $detail_schedule->id_pegawai = $updateData['id_pegawais'];

        if($detail_schedule->save())
        {
            return response([
                'message' => 'Update Success',
                'data' => $detail_schedule
            ], 200);
        }

        return response([
            'message' => 'Update Failed',
            'data' => null
        ], 400);
    }

    public function checkValidationSchedules (Request $request) 
    {
        $checkData = $request->all();
        $checkShift = Detail_Schedule::where('id_pegawai', $checkData['id_pegawai'])->count();

        if($checkShift == 6) 
        {
            return response([
                'message' => 'You can only take 6 shift'
            ], 400);
        }

        return response([
            'message' => 'Add Data Success'
        ], 200);
    }
}