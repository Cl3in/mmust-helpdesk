@extends('layouts.master')

@section('title', 'Students')

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
<a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create Student</a>
</div>
</div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
<p>{{ $message }}</p>
</div>
@endif
<div class="card-body">
<table class="table table-bordered" id="student-datatable">
<thead>
<tr>
<th>Id</th>
<th>First name</th>
<th>Last name</th>
<th>Email</th>
<th>Created at</th>
<th>Action</th>
</tr>
</thead>
</table>
</div>
</div>
<!-- boostrap student model -->
<div class="modal fade" id="student-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="StudentModal"></h4>
</div>
<div class="modal-body">
<form action="javascript:void(0)" id="StudentForm" name="StudentForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" id="id">
<div class="form-group">
<label for="first_name" class="col-sm-2 control-label">First Name</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" maxlength="50" required="">
</div>
</div>  
<div class="form-group">
<label for="last_name" class="col-sm-2 control-label">Last Name</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" maxlength="50" required="">
</div>
</div> 
<div class="form-group">
<label for="email" class="col-sm-2 control-label">Email</label>
<div class="col-sm-12">
<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" maxlength="50" required="">
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
$('#student-datatable').DataTable({
processing: true,
serverSide: true,
ajax: "{{ url('student-datatable') }}",
columns: [
{ data: 'id', name: 'id' },
{ data: 'first_name', name: 'first_name' },
{ data: 'last_name', name: 'last_name' },
{ data: 'email', name: 'email' },
{ data: 'created_at', name: 'created_at' },
{data: 'action', name: 'action', orderable: false},
],
order: [[0, 'desc']]
});
});
function add(){
$('#StudentForm').trigger("reset");
$('#StudentModal').html("Add Student");
$('#student-modal').modal('show');
$('#id').val('');
}   
function editFunc(id){
$.ajax({
type:"POST",
url: "{{ url('edit-student') }}",
data: { id: id },
dataType: 'json',
success: function(res){
$('#StudentModal').html("Edit Student");
$('#student-modal').modal('show');
$('#id').val(res.id);
$('#first_name').val(res.first_name);
$('#last_name').val(res.last_name);
$('#email').val(res.email);
}
});
}  
function deleteFunc(id){
if (confirm("Delete Record?") == true) {
var id = id;
// ajax
$.ajax({
type:"POST",
url: "{{ url('delete-student') }}",
data: { id: id },
dataType: 'json',
success: function(res){
var oTable = $('#student-datatable').dataTable();
oTable.fnDraw(false);
}
});
}
}
$('#StudentForm').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('store-student')}}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: (data) => {
$("#student-modal").modal('hide');
var oTable = $('#student-datatable').dataTable();
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