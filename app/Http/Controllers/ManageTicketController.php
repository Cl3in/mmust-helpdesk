<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManageTicket;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Department;

class ManageTicketController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(ManageTicket::select('*'))
            ->addColumn('action', 'manageticket.manageticket-action')
            ->addColumn('ticket', function($row){
                return $row->ticket->subject;
            })
            ->addColumn('technician', function($row){
                $firstname = $row->technician->first_name;
                $lastname = $row->technician->last_name;
                return $firstname.' '.$lastname;
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
        $tickets = Ticket::where('status', 0)->get();
        $technicians = User::where('role','technician')->get();

        return view('manageticket.manageticket',compact('tickets','technicians'));
    }
      
      
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
 
        $manageticketId = $request->id;
 
        $manageticket   =   ManageTicket::updateOrCreate(
                    [
                     'id' => $manageticketId
                    ],
                    [
                    'ticket_id' => $request->ticket_id, 
                    'technician_id' => $request->technician_id,
                    'remarks' => $request->remarks,

                    ]);   
            $id = $request->ticket_id;
            $ticket = Ticket::findOrFail($id);
            
            if($ticket){
                $ticket->update(array('status' => 1));
                $ticket->save();
            }
                         
        return Response()->json($manageticket);
 
    }
      
      
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\manageticket  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $manageticket  = ManageTicket::where($where)->first();
      
        return Response()->json($manageticket);
    }
      
      
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\manageticket  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $manageticket = ManageTicket::where('id',$request->id)->delete();
      
        return Response()->json($manageticket);
    }

    public function adminPendingTicket()
    {
  
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(ManageTicket::select('*')
            ->where('status', '=', 0)->get())
            ->addColumn('action', 'admin.pendingticket-action')
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
        return view('admin.pendingtickets')->with('departments',$departments);
    }

    public function adminClosedTicket()
    {
  
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(Ticket::select('*')
            ->where('status', '=', 1)->get())
            ->addColumn('action', 'admin.closedticket-action')
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
        return view('admin.closedtickets')->with('departments',$departments);
    }

    public function technicianPendingTicket()
    {
  
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(ManageTicket::select('*')->where('technician_id','=', $user->id)
            ->where('status', '=', 0)->get())
            ->addColumn('action', 'technician.pendingticket-action')
            ->addColumn('ticket', function($row){
                return $row->ticket->subject;
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
        $tickets = Ticket::all();
        return view('technician.pendingtickets', compact(
            'departments', 'tickets'
        ));
    }

    public function technicianClosedTicket()
    {
  
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(ManageTicket::select('*')->where('technician_id','=', $user->id)
            ->where('status', '=', 1)->get())
            ->addColumn('action', 'technician.closedticket-action')
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
        return view('technician.closedtickets')->with('departments',$departments);
    }

}
