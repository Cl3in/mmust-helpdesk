@if (Auth::user()->role == 'admin')   
<a href="javascript:void(0)" data-toggle="tooltip" onClick="viewFunc({{ $id }})" data-original-title="Edit" class="edit btn btn-primary edit">
View
</a>	
@endif

@if (Auth::user()->role == 'student' || Auth::user()->role == 'staff')    
<a href="javascript:void(0)" data-toggle="tooltip" onClick="editFunc({{ $id }})" data-original-title="Edit" class="edit btn btn-info edit">
Edit
</a>
<a href="javascript:void(0);" id="delete-ticket" onClick="deleteFunc({{ $id }})" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">
Delete
</a>
@endif
