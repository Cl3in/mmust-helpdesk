@extends('layouts.master')

@section('title', 'My Tickets')

@section('content')
<div class="container mt-2">
  <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">@yield('title')</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Subject</th>
                      <th>Body</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($tickets as $ticket)
                    <tr>
                      <td>{{$ticket->id}}</td>
                      <td>{{$ticket->subject}}</td>
                      <td>{{$ticket->body}}</td>
                      @if ($ticket->status == 0)
                      <td><span class="badge badge-danger">Pending</span></td>                        
                      @else
                      <td><span class="badge badge-warning">Closed</span></td>
                      @endif
                      <td>
                         <!-- <a 
                        href="javascript:void(0)" 
                        id="show-file" 
                        data-url="{{ route('tickets.show', $ticket->id) }}">
                         <i class="fa fa-eye blue"></i></a> -->
                         <a href="javascript:void(0)" data-toggle="tooltip"  id="show-file" data-url="{{ route('tickets.show', $ticket->id) }}"
                        data-original-title="Edit" class="edit btn btn-primary edit">
                        View
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

                {!! $tickets->links() !!}

              </div>

              <!-- Modal -->
 
              <div class="modal fade" id="fileShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
              
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Show Ticket</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              
                    </div>
              
                    <div class="modal-body">
                      <p><strong>Ticket no:</strong> <span id="ticket-id"></span></p>
                      <p><strong>Subject:</strong> <span id="ticket-subject"></span></p>
                      <p><strong>Body:</strong> <span id="ticket-body"></span></p>
                      <p><strong>Response:</strong> <span id="ticket-response"></span></p>
                    </div>
              
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>


        <script type="text/javascript">
     
          $(document).ready(function () {
          
              /*------------------------------------------
              --------------------------------------------
              When click file on Show Button
              --------------------------------------------
              --------------------------------------------*/
              $('body').on('click', '#show-file', function () {
      
                var fileURL = $(this).data('url');
      
                  $.ajax({
                      url: fileURL,
                      type: 'GET',
                      dataType: 'json',
                      success: function(data) {
                          $('#fileShowModal').modal('show');
                          $('#ticket-id').text(data.id);
                          $('#ticket-subject').text(data.subject);
                          $('#ticket-body').text(data.body);
                          $('#ticket-response').text(data.response);
                      }
                  });
      
            });
              
          });
        
        </script>
</div>
@endsection