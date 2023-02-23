<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Department;


class TicketController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Ticket::select('*'))
            ->addColumn('action', 'tickets.tickets-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        $departments = Department::all();
        return view('tickets.tickets')->with('departments',$departments);
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
}
