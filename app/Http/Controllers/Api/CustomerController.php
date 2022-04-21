<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illmuniate\Support\Facades\Validator;
use App\Model\Customer;
use Illmuniate\Validation\Rule;
use Illmuinate\Support\Facades\DB;

class CustomerController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = Customer::all();

        if (count($customers) > 0) 
        {
            return response([
                'message' => 'Success',
                'data' => $customers
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
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
        $lastCustomerId = DB::table('customers')->latest()->first();

        if (is_null($lastCustomerId))
        {
            $lastCustomerId = 0;
        }

        $customerId = $lastCustomerId + 1;
        $storeData['id_customer'] = 'CUS'.$customerRegDate.'-'.$customerId;
        $storeData['status_customer'] = 'Aktif';
        $storeData['password'] = bcrypt($storeData['tgl_lahir']);

        $validate = Validator::make($storeData,[
            'id_customer' => 'required | unique:customers',
            'nama_customer' => 'required', 
            'alamat' => 'required', 
            'tgl_lahir' => 'required | date', 
            'jenis_kelamin' => 'required',
            'email' => 'required|email|unique:customers', 
            'no_telp' => 'required | unique:customers', 
            'password' => 'required', 
            'url_sim' => 'required', 
            'url_kartu_identitas' => 'required',
            'status_customer' => 'required',
        ]);

        if ($validate->fails()) 
        {
            return response([
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        $customer = Customer::create($storeData);

        return response([
            'message' => 'Add Data Success',
            'data' => $customer
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
        $customer = Customer::where('id_customer', $id)->first();

        if(!is_null($customer))
        {
            return response([
                'message' => 'Retrieve Success',
                'data' => $customer
            ], 200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ], 404);
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
        $customer = Customer::where('id_customer', $id)->first();

        if(is_null($customer))
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_customer' => ['required', Rule::unique('customers')->ignore($customer)],
            'nama_customer' => 'required', 
            'alamat' => 'required', 
            'tgl_lahir' => 'required | date', 
            'jenis_kelamin' => 'required',
            'email' => ['required', 'email', Rule::unique('customers')->ignore($customer)],
            'no_telp' => ['required', Rule::unique('customers')->ignore($customer)],
            'password' => 'required', 
            'url_sim' => 'required', 
            'url_kartu_identitas' => 'required',
            'status_customer' => 'required',
        ]);

        if($validate -> fails())
        {
            return response([
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }

        $customer->nama_customer = $updateData['nama_customer'];
        $customer->alamat = $updateData['alamat'];
        $customer->tgl_lahir = $updateData['tgl_lahir'];
        $customer->jenis_kelamin = $updateData['jenis_kelamin'];
        $customer->email = $updateData['email'];
        $customer->no_telp = $updateData['no_telp'];
        $customer->password = bcrypt($updateData['password']);
        $customer->url_sim = $updateData['url_sim'];
        $customer->url_kartu_identitas = $updateData['url_kartu_identitas'];

        if($customer->save())
        {
            return response([
                'message' => 'Update Success',
                'data' => $customer
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
        $customer = Customer::where('id_customer', $id)->first();

        if(is_null($customer))
        {
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ], 404);
        }

        $customer->status_customer = 'Tidak Aktif';

        if($customer->save())
        {
            return response([
                'message' => 'Delete Success',
                'data' => $customer
            ], 200);
        }

        return response([
            'message' => 'Delete Failed',
            'data' => null
        ], 400);
    }
}
