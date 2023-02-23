<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Department::select('*'))
            ->addColumn('action', 'departments.department-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('departments.departments');
    }
      
      
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
 
        $departmentId = $request->id;
 
        $department   =   Department::updateOrCreate(
                    [
                     'id' => $departmentId
                    ],
                    [
                    'name' => $request->name,
                    ]);    
                         
        return Response()->json($department);
 
    }
      
      
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $department = Department::where($where)->first();
      
        return Response()->json($department);
    }
      
      
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $department = Department::where('id',$request->id)->delete();
      
        return Response()->json($department);
    }
}
