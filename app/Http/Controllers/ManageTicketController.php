<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManageTicket;
use App\Models\Ticket;
use App\Models\User;


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
                else return 'closed';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        $tickets = Ticket::all();
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

}
