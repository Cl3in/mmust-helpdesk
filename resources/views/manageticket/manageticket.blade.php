@extends('layouts.master')

@section('title', 'Assign Tickets')

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
<a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Assign Ticket</a>
</div>
</div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
<p>{{ $message }}</p>
</div>
@endif
<div class="card-body">
<table class="table table-bordered" id="manageticket-datatable">
<thead>
<tr>
<th>Id</th>
<th>Ticket</th>
<th>Technician</th>
<th>Remarks</th>
<th>Status</th>
</tr>
</thead>
</table>
</div>
</div>
<!-- boostrap ticket model -->
<div class="modal fade" id="manageticket-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="ManageTicketModal"></h4>
</div>
<div class="modal-body">
<form action="javascript:void(0)" id="ManageTicketForm" name="ManageTicketForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
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
<label for="technician_id" class="col-sm-2 control-label">Technician</label>
<div class="col-sm-12">
    <select technician="technician_id" id="technician_id" name="technician_id" class="form-control" maxlength="50" required="">
    <option value="0">Select technician</option>
    @foreach ($technicians as $technician)
    <option value="{{$technician->id}}">{{$technician->first_name}} {{$technician->last_name}} </option>            
    @endforeach
    </select>
</div>
</div>
<div class="form-group">
<label for="remarks" class="col-sm-6 control-label"> Remarks</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks" maxlength="2250" required="">
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
$('#manageticket-datatable').DataTable({
processing: true,
serverSide: true,
ajax: "{{ url('manageticket-datatable') }}",
columns: [
{ data: 'id', name: 'id' },
{ data: 'ticket', name: 'ticket.subject' },
{ data: 'technician', name: 'technician.first_name' },
{ data: 'remarks', name: 'remarks' },
{ data: 'status', name: 'status' },
],
order: [[0, 'desc']]
});
});
function add(){
$('#ManageTicket').trigger("reset");
$('#ManageTicketModal').html("Add ManageTicket");
$('#manageticket-modal').modal('show');
$('#id').val('');
}   
function editFunc(id){
$.ajax({
type:"POST",
url: "{{ url('edit-ticket') }}",
data: { id: id },
dataType: 'json',
success: function(res){
$('#ManageTicketModal').html("Edit ManageTicket");
$('#manageticket-modal').modal('show');
$('#id').val(res.id);
$('#ticket_id').val(res.ticket_id);
$('#technician_id').val(res.technician_id);
$('#remarks').val(res.remarks);

}
});
}  
function deleteFunc(id){
if (confirm("Delete Record?") == true) {
var id = id;
// ajax
$.ajax({
type:"POST",
url: "{{ url('delete-manageticket') }}",
data: { id: id },
dataType: 'json',
success: function(res){
var oTable = $('#manageticket-datatable').dataTable();
oTable.fnDraw(false);
}
});
}
}
$('#ManageTicketForm').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('store-manageticket')}}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: (data) => {
$("#manageticket-modal").modal('hide');
var oTable = $('#manageticket-datatable').dataTable();
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