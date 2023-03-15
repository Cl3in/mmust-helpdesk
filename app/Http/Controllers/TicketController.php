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
            ->addColumn('status', function($row){
                if($row->status == 0) {
                    return 'Unassigned';
                }
                else return 'Assigned';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        $departments = Department::all();
        $technicians = User::where('role', 'technician')->get();
        $tickets = Ticket::all();
        $unassignedtickets = Ticket::where('status', 0)->count();
        return view('tickets.tickets', compact('departments', 'technicians',
        'tickets','unassignedtickets'));
    }

    public function myTicket()
    {
  
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(Ticket::select('*')->where('user_id','=', $user->id)->orderByDesc('created_at')->get())
            ->addColumn('action', 'tickets.ticket-action')
            ->addColumn('action', function($row){
                if($row->status == 0) {
                    return '<a href="javascript:void(0)" data-toggle="tooltip" onClick="editFunc({{ $id }})" data-original-title="Edit" class="edit btn btn-info edit">
                    Edit
                    </a>
                    <a href="javascript:void(0);" id="delete-assignedticket" onClick="deleteFunc({{ $id }})" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
                    Delete
                    </a>'; 
                }
                else return '<a href="javascript:void(0);" data-toggle="tooltip" onClick="viewFunc({{ $id }})" data-original-title="Edit" class="edit btn btn-info edit">
                View Response
                </a>';
            })  
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
        $user = Auth::user();
        $tickets = Ticket::select('*')->where('user_id','=', $user->id)->orderByDesc('created_at')->paginate(10);
        return view('tickets.mytickets',compact('tickets'))->with('departments',$departments);
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
                    'user_id' => Auth::user()->id,
                    'status' => 0,

                    ]);  
                    
                    $logfile = fopen("logs.txt","a+");
                    $firstname =Auth::user()->first_name;
                    $lastname =Auth::user()->last_name;
                    $time=now();
                    $subject = $request->subject;

                    fwrite($logfile,"\n$time\t$firstname\t$lastname created\tticket $subject");
                    fclose($logfile);
                       
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

        $logfile = fopen("logs.txt","a+");
        $firstname =Auth::user()->first_name;
        $lastname =Auth::user()->last_name;
        $time=now();
        $subject = $request->subject;

        fwrite($logfile,"\n$time\t$firstname\t$lastname updated\tticket $subject");
        fclose($logfile);
      
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

        $logfile = fopen("logs.txt","a+");
        $firstname =Auth::user()->first_name;
        $lastname =Auth::user()->last_name;
        $time=now();
        $subject = $request->subject;

        fwrite($logfile,"\n$time\t$firstname\t$lastname deleted\tticket $subject");
        fclose($logfile);
      
        return Response()->json($ticket);
    }

    public function myPendingTicket()
    {
  
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(Ticket::select('*')->where('user_id','=', $user->id)
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
            return datatables()->of(Ticket::select('*')->where('user_id','=', $user->id)
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

    public function show($id)
    {
        $ticket = Ticket::find($id);
  
        return response()->json($ticket);
    }    
}
