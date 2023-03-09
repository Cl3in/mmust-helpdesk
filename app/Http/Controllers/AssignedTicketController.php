<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManageTicket;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AssignedTicketController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(ManageTicket::select('*')->where('technician_id', $user->id))
            ->addColumn('action', 'assignedticket.assignedticket-action')
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
        $tickets = Ticket::all();
        $technicians = User::where('role','technician')->get();
        $unassignedtickets = Ticket::where('status', 0)->count();

        return view('assignedticket.assignedticket',compact('tickets','technicians', 'unassignedtickets'));
    }

    public function allAssigned()
    {
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(ManageTicket::select('*'))
            ->addColumn('action', 'assignedticket.allassignedticket-action')
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
        $tickets = Ticket::all();
        $technicians = User::where('role','technician')->get();

        return view('assignedticket.allassignedtickets',compact('tickets','technicians')); 
    }

    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $manageticket  = ManageTicket::where($where)->first();

        $manageticket->update(array([
            'status' => 1,
            'response' => $request->response
        ]
        ));
      
        return Response()->json($manageticket);
    }
}
