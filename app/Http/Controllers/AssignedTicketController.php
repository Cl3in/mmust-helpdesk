<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ManageTicket;
use App\Models\RespondTicket;
use App\Models\Ticket;
use App\Models\User;

class AssignedTicketController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(ManageTicket::select('*')->where('technician_id', $user->id))
            ->addColumn('action', 'assignedticket.assignedticket-action')
            ->addColumn('action', function($row){
                if($row->status == 0) {
                    return '<a href="javascript:void(0)" data-toggle="tooltip" onClick="editFunc({{ $id }})" data-original-title="Edit" class="edit btn btn-info edit">
                    View
                    </a>'; 
                }
                else return '';
            })

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
        $user = Auth::user();
        $technicianpendingtickets = ManageTicket::where('technician_id', $user->id)->where('status', 0)->count();

        return view('assignedticket.assignedticket',compact('tickets','technicians',
         'unassignedtickets','technicianpendingtickets'));
    }

    public function allAssigned()
    {
        if(request()->ajax()) {
            $user = Auth::user();
            return datatables()->of(ManageTicket::select('*'))
            ->addColumn('action', 'assignedticket.allassignedticket-action')
            ->addColumn('action', function($row){
                if($row->status == 0) {
                    return '<a href="javascript:void(0)" data-toggle="tooltip" onClick="editFunc({{ $id }})" data-original-title="Edit" class="edit btn btn-info edit">
                    Edit
                    </a>
                    <a href="javascript:void(0);" id="delete-assignedticket" onClick="deleteFunc({{ $id }})" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
                    Delete
                    </a>'; 
                }
                else return '';
            })
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
        $unassignedtickets = Ticket::where('status', 0)->count();

        return view('assignedticket.allassignedtickets',compact('tickets',
        'technicians','unassignedtickets')); 
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

    public function store(Request $request)
    {
        $manageticket  = $request->id;

        $id = $request->id;
        $ticket = ManageTicket::findOrFail($id);
        
        if($ticket){
            $ticket->update(array([
                'status' => 1,
                'response' => $request->response
            ]));
            $ticket->save();
        }
        $respondticket = RespondTicket::create([
            'technician_id' => Auth::user()->id,
            'response' => $request->response,
            'ticket_id' => $request->id
        ]);
        $respondticket->save();

        return Response()->json($manageticket);
    }
}
