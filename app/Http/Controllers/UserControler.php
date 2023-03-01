<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserControler extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(User::select('*'))
            ->addColumn('action', 'users.user-action')
            ->addColumn('status', function($row){
                if($row->status == 0){
                    return 'Pending';
                }
                else
                    return 'Closed';    
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('users.users');
    }

    public function store(Request $request)
    {  
 
        $userId = $request->id;
 
        $user   =   User::updateOrCreate(
                    [
                     'id' => $userId
                    ],
                    [
                    'first_name' => $request->first_name, 
                    'last_name' => $request->last_name, 
                    'email' => $request->email,
                    'role' => $request->role,
                    'password' => Hash::make('123456')
                    ]);    
                         
        return Response()->json($user);
 
    }

    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $user  = User::where($where)->first();
      
        return Response()->json($user);
    }

    public function destroy(Request $request)
    {
        $user = User::where('id',$request->id)->delete();
      
        return Response()->json($user);
    }

}
