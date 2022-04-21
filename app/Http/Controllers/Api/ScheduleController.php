<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $schedules = Schedule::all();

        if(count($schedules) > 0)
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $schedules
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
            'shift' => ['required', 'numeric'],
            'hari' => ['required', 'string']
        ]);

        if ($validate->fails()) 
        {
            return response([
                'message' => 'Validation Failed',
                'data' => $validate->errors()
            ], 400);
        }

        $schedules = Schedule::create($storeData);
        return response([
            'message' => 'Add Data Success',
            'data' => $schedules
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
        $schedules = Schedule::where('id_jadwal', $id)->get();

        if(!is_null($schedules))
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $schedules
            ], 200);
        }

        return response ([
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
        $schedules = Schedule::find($id);

        if (is_null($schedules)) {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'shift' => ['required', 'numeric'],
            'hari' => ['required', 'string']
        ]);

        if ($validate->fails()) {
            return response([
                'message' => 'Validation Failed',
                'data' => $validate->errors()
            ], 400);
        }

        $schedules->shift = $updateData['shift'];
        $schedules->hari = $updateData['hari'];

        if ($schedules->save()) 
        {
            return response([
                'message' => 'Update Success',
                'data' => $schedules
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
        $schedules = Schedule::find($id);

        if(is_null($schedules))
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        if($schedules->delete())
        {
            return response([
                'message' => 'Delete Success',
                'data' => $schedules
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data' => null
        ], 400);
    }
}
