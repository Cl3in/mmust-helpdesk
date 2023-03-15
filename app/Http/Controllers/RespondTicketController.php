<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\RespondTicket;
use App\Models\ManageTicket;
use Illuminate\Support\Facades\Auth;

class RespondTicketController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(RespondTicket::select('*'))
            ->addColumn('action', 'respondticket.respondticket-action')
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
        $id = Auth::user()->id;
        $tickets = ManageTicket::where('status', 0)->where('technician_id', $id)->get();
        $user = Auth::user();
        $technicianpendingtickets = ManageTicket::where('technician_id', $user->id)->where('status', 0)->count();

        return view('respondticket.respondtickets',compact('tickets','technicianpendingtickets'));
    }

    public function store(Request $request)
    {  
 
        $respondticketId = $request->id;
 
        $respondticket   =   RespondTicket::updateOrCreate(
                    [
                     'id' => $respondticketId
                    ],
                    [
                    'ticket_id' => $request->ticket_id, 
                    'technician_id' => Auth::user()->id,
                    'response' => $request->response,

                    ]);   
            $id = $request->ticket_id;
            $ticket = ManageTicket::where('ticket_id', $id);
            
            if($ticket){
                $ticket->update(array('status' => 1));
                // $ticket->save();
            }
                         
        return Response()->json($respondticket);
 
    }
}
