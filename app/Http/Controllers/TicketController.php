<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class TicketController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Ticket::select('*'))
            ->addColumn('action', 'tickets.ticket-action')
            ->addColumn('department', function($row){
                return $row->department->name;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        $departments = Department::all();
        $technicians = User::where('role', 'technician')->get();
        $tickets = Ticket::all();
        return view('tickets.tickets', compact('departments', 'technicians','tickets'));
    }

    public function myTicket()
    {
  
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(Ticket::select('*')->where('student_id','=', $user->id)->get())
            ->addColumn('action', 'tickets.ticket-action')
            ->addColumn('status', function($row){
                if($row->status == 0) {
                    return 'Pending';
                }
                else return 'Closed';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        $departments = Department::all();
        return view('tickets.mytickets')->with('departments',$departments);
    }  
      
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
 
        $ticketId = $request->id;
 
        $ticket   =   Ticket::updateOrCreate(
                    [
                     'id' => $ticketId
                    ],
                    [
                    'subject' => $request->subject,
                    'department_id' => $request->department_id,
                    'body' => $request->body,
                    'student_id' => Auth::user()->id,
                    'status' => 0,

                    ]);    
                         
        return Response()->json($ticket);
 
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
        $ticket = Ticket::where($where)->first();
      
        return Response()->json($ticket);
    }
      
      
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ticket = Ticket::where('id',$request->id)->delete();
      
        return Response()->json($ticket);
    }

    public function myPendingTicket()
    {
  
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(Ticket::select('*')->where('student_id','=', $user->id)
            ->where('status', '=', 0)->get())
            ->addColumn('action', 'tickets.mypendingticket-action')
            ->addColumn('status', function($row){
                if($row->status == 0) {
                    return 'Pending';
                }
                else return 'Closed';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        $departments = Department::all();
        return view('tickets.mypendingtickets')->with('departments',$departments);
    }

    public function myClosedTicket()
    {
  
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(Ticket::select('*')->where('student_id','=', $user->id)
            ->where('status', '=', 1)->get())
            ->addColumn('action', 'tickets.myclosedticket-action')
            ->addColumn('status', function($row){
                if($row->status == 0) {
                    return 'Pending';
                }
                else return 'Closed';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        $departments = Department::all();
        return view('tickets.myclosedtickets')->with('departments',$departments);
    }
    
}
