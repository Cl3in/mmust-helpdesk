@extends('layouts.master')

@section('title', 'Closed Tickets')

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
<!-- <div class="float-right mb-2">
<a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create Ticket</a>
</div> -->
</div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
<p>{{ $message }}</p>
</div>
@endif
<div class="card-body">
<table class="table table-bordered" id="technicianclosedticket-datatable">
<thead>
<tr>
<th>Id</th>
<th>Subject</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
</table>
</div>
</div>
<!-- boostrap closedticket model -->
<div class="modal fade" id="closedticket-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="ClosedTicketModal"></h4>
</div>
<div class="modal-body">
<form action="javascript:void(0)" id="ClosedTicketForm" name="ClosedTicketForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" id="id">
<div class="form-group">
<label for="subject" class="col-sm-6 control-label"> Subject</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject" maxlength="2250" required="">
</div>
</div> 
<div class="form-group">
<label for="department_id" class="col-sm-2 control-label">Department</label>
<div class="col-sm-12">
    <select department="department_id" id="department_id" name="department_id" class="form-control" maxlength="50" required="">
    <option value="0">Select department</option>
    @foreach ($departments as $department)
    <option value="{{$department->id}}">{{$department->name}} </option>            
    @endforeach
    </select>
</div>
</div>
<div class="form-group">
<label for="body" class="col-sm-6 control-label"> Body</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="body" name="body" placeholder="Enter Body" maxlength="2250" required="">
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
$('#technicianclosedticket-datatable').DataTable({
processing: true,
serverSide: true,
ajax: "{{ url('technicianclosedticket-datatable') }}",
columns: [
{ data: 'id', name: 'id' },
{ data: 'subject', name: 'subject.name' },
{ data: 'status', name: 'status' },
{data: 'action', name: 'action', orderable: false},
],
order: [[0, 'desc']]
});
});
$('#ClosedTicketForm').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('store-closedticket')}}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: (data) => {
$("#closedticket-modal").modal('hide');
var oTable = $('#technicianclosedticket-datatable').dataTable();
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