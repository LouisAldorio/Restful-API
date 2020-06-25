<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Employee;
use App\Http\Resources\employeeResources;
use App\Http\Requests\employeeStoreRequest as StoreRequest;
use App\Http\Requests\employeeUpdateRequest as UpdateRequest;

class employeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        return employeeResources::collection($employee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $employee = Employee::create([
              'name' => $request->name,
              'email' => $request->email
          ]);
        if(!$employee){
            return response()->json(['message' => 'failed to store data!','status' => '404']);
        }
        return new employeeResources($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::where('id',$id)->first();
        if(!$employee){
            return response()->json(['message' => 'ID not found!','status' => '404']);
        }
        return new employeeResources($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $employee = Employee::where('id',$id)->first();
        if(!$employee){
            return response()->json(['message' => 'ID not found!','status' => '404']);
        }
        $employee->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return new employeeResources($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::where('id',$id)->first();
        if(!$employee){
            return response()->json(['message' => 'ID not found!','status' => '404']);
        }
        $employee->delete();
        return response()->json(['message' => 'Data has been Deleted.','status' => '200']);
    }
}
