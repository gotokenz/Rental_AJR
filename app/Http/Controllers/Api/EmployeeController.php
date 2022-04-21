<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employees = Employee::all();

        if(count($employees) > 0)
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $employees
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
            'status_pegawai' => 'required',
            'id_role' => 'required',
            'nama_pegawai' => 'required',
            'alamat' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required | email:rfc,dns | unique:employees',
            'no_telp' => 'required | unique:employees',
            'password' => 'required',
            'url_foto' => 'required'
        ]);

        if($validate->fails())
        {
            return response([
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        $employees = Employee::create($storeData);

        return response ([
            'message' => 'Add Data Success',
            'data' => $employees
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
        $employees = Employee::find($id);

        if(!is_null($employees))
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $employees
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
        $employees = Employee::find($id);

        if (is_null($employees))
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'status_pegawai' => 'required',
            'id_role' => 'required',
            'nama' => 'required',
            'alamat_pegawai' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'email' => ['required', 'email:rfc,dns' , Rule::unique('employees')->ignore($employees)],
            'no_telp' => ['required', Rule::unique('employees')->ignore($employees)],
            'password' => 'required',
            'url_foto' => 'required'
        ]);

        if($validate->fails())
        {
            return response([
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        $employees->id_role = $updateData['id_role'];
        $employees->nama_pegawai = $updateData['nama_pegawai'];
        $employees->alamat = $updateData['alamat_pegawai'];
        $employees->tgl_lahir = $updateData['tgl_lahir'];
        $employees->jenis_kelamin = $updateData['jenis_kelamin'];
        $employees->email = $updateData['email'];
        $employees->no_telp = $updateData['no_telp'];
        $employees->password = $updateData['password'];
        $employees->url_foto = $updateData['url_foto'];  
        
        if ($employees->save())
        {
            return response([
                'message' => 'Update Success',
                'data' => $employees
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
        $employees = Employee::find($id);

        if (is_null($employees))
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $employees->status_akun = 'Tidak Aktif';

        if ($employees->save())
        {
            return response([
                'message' => 'Delete Success',
                'data' => $employees
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data' => null
        ], 400);
    }
}
