@extends('admin.layouts.common_app')
@section('content')

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row mt-4">

          <div class="col-8 offset-2 mt-5">
            <a href="{{route('admin#category')}}" class="text-decoration-none text-black"><div class="mb-2"><i class="fa-solid fa-arrow-left"></i>Back</div></a>

            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                  <h3 class="text-center">{{$itemList[0]->category_name}}</h3>
              </div>
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Pizza Name</th>
                      <th>Image</th>
                      <th>Price</th>
                      <th>Category Name</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($itemList as $item)
                    <tr>
                        <td>{{$item->pizza_id}}</td>
                        <td>{{$item->pizza_name}}</td>
                        <td><img src="{{asset('uploads/'.$item->image)}}" width="110px" height="100px" alt=""></td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->category_name}}</td>

                      </tr>
                    @endforeach

                  </tbody>
                </table>

              </div>
              <!-- /.card-body -->
              <div class="card-footer d-flex">
                <div class="mt-3 ms-3">{{$itemList->links()}}</div>
                <div class="mt-3 ms-3"><p class="bg-primary p-1">Total = {{$itemList->total()}}</p></div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


@endsection
