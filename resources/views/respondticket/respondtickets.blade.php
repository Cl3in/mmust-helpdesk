@extends('layouts.master')

@section('title', 'Responded Tickets')

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
    @if (count($tickets) >=1)
    <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Respond to Ticket</a>
    @else        
    @endif
</div>
</div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
<p>{{ $message }}</p>
</div>
@endif
<div class="card-body">
<table class="table table-bordered" id="respondticket-datatable">
<thead>
<tr>
<th>Id</th>
<th>Ticket</th>
<th>Response</th>
<th>Action</th>
</tr>
</thead>
</table>
</div>
</div>
<!-- boostrap respondticket model -->
<div class="modal fade" id="respondticket-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="RespondTicketModal"></h4>
</div>
<div class="modal-body">
<form action="javascript:void(0)" id="RespondTicketForm" name="RespondTicketForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" id="id"> 
<div class="form-group">
<label for="ticket_id" class="col-sm-2 control-label">Ticket</label>
<div class="col-sm-12">
    <select ticket="ticket_id" id="ticket_id" name="ticket_id" class="form-control" maxlength="50" required="">
    <option value="0">Select ticket</option>
    @foreach ($tickets as $ticket)
    <option value="{{$ticket->id}}">{{$ticket->ticket->subject}} </option>            
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
$('#respondticket-datatable').DataTable({
processing: true,
serverSide: true,
ajax: "{{ url('respondticket-datatable') }}",
columns: [
{ data: 'id', name: 'id' },
{ data: 'ticket', name: 'ticket.subject' },
{ data: 'response', name: 'response' },
{data: 'action', name: 'action', orderable: false},
],
order: [[0, 'desc']]
});
});
function add(){
$('#RespondTicket').trigger("reset");
$('#RespondTicketModal').html("Add Response");
$('#respondticket-modal').modal('show');
$('#id').val('');
}   
function editFunc(id){
$.ajax({
type:"POST",
url: "{{ url('edit-respondticket') }}",
data: { id: id },
dataType: 'json',
success: function(res){
$('#RespondTicketModal').html("Edit Response");
$('#respondticket-modal').modal('show');
$('#id').val(res.id);
$('#ticket_id').val(res.ticket_id);
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
url: "{{ url('delete-respondticket') }}",
data: { id: id },
dataType: 'json',
success: function(res){
var oTable = $('#respondticket-datatable').dataTable();
oTable.fnDraw(false);
}
});
}
}
$('#RespondTicketForm').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('store-respondticket')}}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: (data) => {
$("#respondticket-modal").modal('hide');
$("#respondticket-modal").modal('reset');
var oTable = $('#respondticket-datatable').dataTable();
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