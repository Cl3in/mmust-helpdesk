@extends('layouts.master')


@section('content')
    <style>
    .widget-user-header{
        background-position: center center;
        background-size: cover;
        height: 250px;
    }
    </style>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info" style="background-image:url('./images/sunflower.jpg')">
                <h3 class="widget-user-username">{{$user->first_name}}</h3>
                <h5 class="widget-user-desc">{{$user->role}}</h5>
              </div>
              <div class="widget-user-image">
                <!-- <img class="img-circle elevation-2" :src="{{asset($user->profile_picture)}}" alt="User Avatar"> -->
              </div>
              <div class="">
                  <div class="alert alert-danger" role="alert" id="failedMessage" style="display: none"></div>
                   <div class="alert alert-success" role="alert" id="successMessage" style="display: none"></div>
              </div>
            </div>
            <!-- /.widget-user -->

            <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="activity">
                      <h3>Display User Activity</h3>
                  </div>

                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal">

                      <div class="form-group">
                        <label for="first_name" class="col-sm-2 control-label">First Name</label>
                        <div class="col-sm-12">
                          <input name="first_name" type="text" enabled value="{{$user->first_name}}" class="form-control" placeholder="First Name" id="first_name">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="last_name" class="col-sm-2 control-label">Last Name</label>
                        <div class="col-sm-12">
                          <input name="last_name" type="text" enabled value="{{$user->last_name}}" class="form-control" placeholder="Last Name" id="last_name">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                          <input name="email" type="email"  enabled value="{{$user->email}}" class="form-control" id="email" placeholder="Email Address">
                        </div>
                      </div>

<!-- 
                      <div class="form-group">
                        <label for="profile_photo" class="col-sm-8 control-label">Profile Photo</label>
                        <div class="col-sm-12">
                          <input type="file" name="profile_photo" class="form-input">
                        </div>  
                      </div> -->

                      <div class="form-group">
                        <label for="password" class="col-sm-12 control-label">Password
                          (leave empty if not changing)
                        </label>
                        <div class="col-sm-12">
                          <input name="password" type="password" class="form-control" name="password">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-12">
                          <button type="submit" class="btn btn-success">Update</button>
                        </div>
                      </div>

                    </form>

                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          </div>
        </div>
    </div>
@stop