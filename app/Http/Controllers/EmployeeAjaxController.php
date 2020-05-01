<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Validation\Validator;

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
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editemp">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteemp">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            //return response()->json(['status'=>'AJAX request']);
        }
        //  return response()->json(['status'=>'HTTP request']);
        return view('employeeAjax',compact('employees'));
    }

    public function store(Request $request)
    {
//        Employee::updateOrCreate(['id' => $request->eid],
//            ['fname' => $request->fname, 'lname' => $request->lname,'dob' => $request->dob,'address' => $request->address,'city' => $request->city,'contactnumber'=> $request->contactnumber,'email'=> $request->email,'password'=> $request->password,'confirmpassword'=>$request->cmpassword]);
//
//        return response()->json(['success'=>'Employee saved successfully.']);

//         $validator = Validator::make($request->all(),[
//            'fname'=>'required'
//         ],[
//             'fname.required'=>'First name must be required'
//         ]);
//         $validator->validate();
//         dd('Form Submitted');

        $validatedData = $request->validate([
            'fname' => 'required|max:255',
            'lname' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'city' => 'required',
            'contactnumber' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'confirmpassword' => 'required|same:password',
        ]);
        Employee::create($validatedData);

        return response()->json('Form is successfully validated and data has been saved');

    }
    public function edit($id)
    {
        $employee = Employee::find($id);
        return response()->json($employee);
    }
    public function destroy($id)
    {
        Employee::find($id)->delete();

        return response()->json(['success'=>'Employee deleted successfully.']);
    }
}
