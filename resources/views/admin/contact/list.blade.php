@extends('admin.layouts.common_app')
@section('content')

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                    <h3 class="card-title mt-1">
                            User Contact Data
                    </h3>
                    <span class="fs-5 ml-5">Total - {{$conData->total()}}</span>
                    <div class="card-tools">

                                <form action="{{route('admin#contactSearch')}}" method="GET">
                                    @csrf
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="search" value="{{old('search')}}" class="form-control float-right" placeholder="Search">
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
                      <th>Message</th>
                    </tr>
                  </thead>
                  <tbody>
                        @if ($status == 1)
                        @foreach ($conData as $item)
                        <tr>
                            <td>{{$item->contact_id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->message}}</td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="4"><small class="text-primary">There is no user contact data...</small></td>
                            </tr>
                        @endif

                  </tbody>
                </table>
                <div class="mt-3 ms-3">{{$conData->links()}}</div>
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
