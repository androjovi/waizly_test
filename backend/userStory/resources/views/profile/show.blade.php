@extends('layouts.scaffold')

@section('main')

    @include('partials.messages')
    <h2 class="mt-2">Edit profile</h2>
    <div class="row mt-3">
        
        <div class="col-md-3" style="border-color:red;">
            <form class="" action="{{ route('profile.updatePhotoProfile') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <img src="{{ url('storage/images/'. (strlen(auth()->user()->profile_picture) > 0 ? auth()->user()->profile_picture : 'blank-profile-picture.png') ) }}" class="rounded" width=90% hieght=100%>
                <input type="file" class="mx-auto d-block mt-3" name="image">
                <button class="btn btn-sm btn-primary mx-auto d-block mt-1">Change photo</button>
            </form>
        </div>
        <div class="col-md-9">
            <form  action="{{ route('profile.updateProfileDetail') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Your Name" value="{{ auth()->user()->name }}">
                </div>
                <div class="form-group">
                    <label>Email</label> <br>
                    <span> {{ auth()->user()->email }}</span>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="password" name="old_password" class="form-control" placeholder="Old Password">
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="new_password" class="form-control" placeholder="New Password">
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    <div>

@stop