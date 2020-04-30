<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use DataTables;

class EmployeeAjaxController extends Controller
{
    public function index(Request $request)
    {
        ///// ajax() method in Laravel,check request is ajax or not.
        if($request->ajax())
        {
            ////First way for get data of table
           // $data = DB::select('select * from employees');

            ////Second way for get data of table
            $empdata = Employee::latest()->get();

            //return $data;
            return DataTables::of($empdata)
                ->addIndexColumn()
                ->make(true);
            //return response()->json(['status'=>'AJAX request']);
        }
        //  return response()->json(['status'=>'HTTP request']);
        return view('employeeAjax',compact('employees'));
    }

    public function store(Request $request)
    {
        Employee::updateOrCreate(['id' => $request->eid],
            ['fname' => $request->fname, 'lname' => $request->lname,'dob' => $request->dob,'address' => $request->address,'city' => $request->city,'contactnumber'=> $request->contactnumber,'email'=> $request->email,'password'=> $request->password,'confirmpassword'=>$request->cmpassword]);

        return response()->json(['success'=>'Employee saved successfully.']);
    }
}
