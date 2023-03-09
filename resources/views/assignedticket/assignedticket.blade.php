@extends('layouts.master')

@section('title', 'Assigned Tickets')

@section('content')
<div class="container mt-2">
<div class="row">
<div class="col-lg-12 margin-tb">
<div class="float-left">
    <ol class="breadcrumb float-sm-right">
      @if (Auth::user()->role == 'admin')
      <li class="breadcrumb-item"><a href="{{url('admin_dashboard')}}">Home</a></li>
      @elseif(Auth::user()->role == 'technician')
      <li class="breadcrumb-item"><a href="{{url('technician_dashboard')}}">Home</a></li> 
      @else
      <li class="breadcrumb-item"><a href="{{url('student_dashboard')}}">Home</a></li> 
      @endif
      <li class="breadcrumb-item active">@yield('title')</li>
    </ol>
</div>
<div class="float-right mb-2">
<!-- <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Assign Ticket</a> -->
</div>
</div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
<p>{{ $message }}</p>
</div>
@endif
<div class="card-body">
<table class="table table-bordered" id="assignedticket-datatable">
<thead>
<tr>
<th>Id</th>
<th>Ticket</th>
<th>Remarks</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
</table>
</div>
</div>
<!-- boostrap assignedticket model -->
<div class="modal fade" id="assignedticket-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="AssignedTicketModal"></h4>
</div>
<div class="modal-body">
<form action="javascript:void(0)" id="AssignedTicketForm" name="AssignedTicketForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" id="id"> 
<div class="form-group">
<label for="ticket_id" class="col-sm-2 control-label">Ticket</label>
<div class="col-sm-12">
    <select ticket="ticket_id" id="ticket_id" name="ticket_id" class="form-control" maxlength="50" required="">
    <option value="0">Select ticket</option>
    @foreach ($tickets as $ticket)
    <option value="{{$ticket->id}}">{{$ticket->subject}} </option>            
    @endforeach
    </select>
</div>
</div>
<div class="form-group">
<label for="response" class="col-sm-6 control-label"> Response</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="response" name="response" placeholder="Enter Response"
 maxlength="2250" required="">
</div>
</div> 
<div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn btn-primary" id="btn-save">Save changes
</button>
</div>
</form>
</div>
<div class="modal-footer">
</div>
</div>
</div>
</div>
<!-- end bootstrap model -->
<script type="text/javascript">
$(document).ready( function () {
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$('#assignedticket-datatable').DataTable({
processing: true,
serverSide: true,
ajax: "{{ url('assignedticket-datatable') }}",
columns: [
{ data: 'id', name: 'id' },
{ data: 'ticket', name: 'ticket.subject' },
{ data: 'remarks', name: 'remarks' },
{ data: 'status', name: 'status' },
{data: 'action', name: 'action', orderable: false},
],
order: [[0, 'desc']]
});
});
function add(){
$('#AssignedTicket').trigger("reset");
$('#AssignedTicketModal').html("Add Ticket");
$('#assignedticket-modal').modal('show');
$('#id').val('');
}   
function editFunc(id){
$.ajax({
type:"POST",
url: "{{ url('edit-assignedticket') }}",
data: { id: id },
dataType: 'json',
success: function(res){
$('#AssignedTicketModal').html("Respond to Ticket");
$('#assignedticket-modal').modal('show');
$('#id').val(res.id);
$('#ticket_id').val(res.ticket_id);
$('#technician_id').val(res.technician_id);
$('#remarks').val(res.remarks);
$('#response').val(res.response);

}
});
}  
function deleteFunc(id){
if (confirm("Delete Record?") == true) {
var id = id;
// ajax
$.ajax({
type:"POST",
url: "{{ url('delete-assignedticket') }}",
data: { id: id },
dataType: 'json',
success: function(res){
var oTable = $('#assignedticket-datatable').dataTable();
oTable.fnDraw(false);
}
});
}
}
$('#AssignedTicketForm').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('store-assignedticket')}}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: (data) => {
$("#assignedticket-modal").modal('hide');
var oTable = $('#assignedticket-datatable').dataTable();
oTable.fnDraw(false);
$("#btn-save").html('Submit');
$("#btn-save"). attr("disabled", false);
},
error: function(data){
console.log(data);
}
});
});
</script>
@endsection