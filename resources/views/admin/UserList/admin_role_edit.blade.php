@extends('admin.layouts.common_app')


@section('content')
<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">


            {{-- <div class="">
                @if (Session::has('updateSuccess'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{Session::get('updateSuccess')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="">
                @if (Session::has('errorMessage'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{Session::get('errorMessage')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="">
                @if (Session::has('lengthError'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{Session::get('lengthError')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="">
                @if (Session::has('matchError'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{Session::get('matchError')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="">
                @if (Session::has('oldError'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{Session::get('oldError')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="">
                @if (Session::has('passUpdated'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{Session::get('passUpdated')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div> --}}


          <div class="col-8 offset-3 mt-5">
            <div class="col-md-10">
                <a href="{{route('admin#adminListPage')}}" class="text-decoration-none text-black"><div class="mb-2"><i class="fa-solid fa-arrow-left"></i>Back</div></a>

              <div class="card">

                <div class="card-header p-2">
                  <legend class="text-center">Admin Profile</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" action="{{route('admin#updateAdminDataAnother',$user->id)}}" method="POST">
                        @csrf
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" value="{{old('name',$user->name)}}" id="inputName" placeholder="Name">

                            <p class="text-danger">
                                @if ($errors->has('name'))
                                    {{$errors->first('name','No name??Not today it ain\'t GOT.')}}
                                @endif
                            </p>

                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" value="{{old('email',$user->email)}}" id="inputEmail" placeholder="Email">

                            <p class="text-danger">
                                @if ($errors->has('email'))
                                    {{$errors->first('email','Email can not leave empty.')}}
                                @endif
                            </p>

                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                          <div class="col-sm-10">
                            <input type="number" name="phone" class="form-control" value="{{old('phone',$user->phone)}}" id="inputPhone" placeholder="Phone">
                                <p class="text-danger">
                                    @if ($errors->has('phone'))
                                        {{$errors->first('phone','Use Phone Dude that makes better..')}}
                                    @endif
                                </p>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                          <div class="col-sm-10">
                            <input type="text" name="address" class="form-control" value="{{old('address',$user->address)}}" id="inputAddress" placeholder="Address">

                                <p class="text-danger">
                                    @if ($errors->has('address'))
                                        {{$errors->first('address','You have to stay somewhere,right??,Just fill it out.')}}
                                    @endif
                                </p>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputAddress" class="col-sm-2 col-form-label">Role</label>
                          <div class="col-sm-10">
                            <input type="text" name="role" class="form-control" value="{{old('role',$user->role)}}" id="" placeholder="role">

                                <p class="text-danger">
                                    @if ($errors->has('role'))
                                        {{$errors->first('role','Type:(admin or user) to change the Role')}}
                                    @endif
                                </p>
                          </div>
                        </div>

                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            {{-- <a href="">Change Password</a> --}}
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn bg-dark text-white float-start">Update</button>
                          </div>
                        </div>
                      </form>
                      <!-- Button trigger modal -->
                      {{-- <p  class="text-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Change Password
                    </p> --}}

                    <!-- Modal -->
                      {{-- <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                        <form action="{{ route('admin#updatePassword',$user->id) }}" method="POST">
                                            @csrf
                                            <div class="my-2">
                                                <label for="oldPassword">Old Password</label>
                                                <input type="password" name="oldPassword" class="form-control">
                                                <p class="text-danger">
                                                    @if ($errors->has('oldPassword'))
                                                        {{$errors->first('oldPassword','Enter Your Old Password')}}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="my-2">
                                                <label for="newPassword">New Password</label>
                                                <input type="password" name="newPassword" class="form-control">
                                                <p class="text-danger">
                                                    @if ($errors->has('newPassword'))
                                                        {{$errors->first('newPassword','Enter New Password')}}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="my-2">
                                                <label for="confirmPassword">Confirm Password</label>
                                                <input type="password" name="confirmPassword" class="form-control">
                                                <p class="text-danger">
                                                    @if ($errors->has('confirmPassword'))
                                                        {{$errors->first('confirmPassword','Confirm Your New Password')}}
                                                    @endif
                                                </p>
                                            </div>


                                </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="submitPas"  class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                        </div>
                        </div>
                    </div> --}}
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


@endsection
