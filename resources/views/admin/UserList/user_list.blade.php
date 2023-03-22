@extends('admin.layouts.common_app')
@section('content')

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


        @if (Session::has('deleteSuccess'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        {{Session::get('deleteSuccess')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="row mt-4">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                    <h3 class="card-title">
                       <div class="mt-1">
                        <a href="{{ route('admin#userListPage') }}">
                            <button class="btn btn-sm btn-outline-dark active">User List</button>
                        </a>
                        <a href="{{ route('admin#adminListPage') }}">
                            <button class="btn btn-sm btn-outline-dark">Admin List</button>
                        </a>
                       </div>
                    </h3>

                    <div class="card-tools">

                                <form action="{{route('admin#userListSearch')}}" method="GET">
                                    @csrf
                                    <div class="input-group input-group-sm mt-1" style="width: 150px;">
                                        <input type="text" name="search" class="form-control float-right" placeholder="Search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                    </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Address</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($user as $item)

                        <tr>

                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->address}}</td>

                            <td>

                            <a href="{{route('admin#userDelete',$item->id)}}"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
                            </td>

                        </tr>

                    @endforeach

                  </tbody>
                </table>
                <div class="mt-3 ms-3">{{$user->links()}}</div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


@endsection
