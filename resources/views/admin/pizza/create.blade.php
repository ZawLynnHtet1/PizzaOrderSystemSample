@extends('admin.layouts.common_app')


@section('content')
<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-8 offset-3 mt-5">
            <div class="col-md-9">
                <a href="{{route('admin#pizza')}}" class="text-decoration-none text-black"><div class="mb-2"><i class="fa-solid fa-arrow-left"></i>Back</div></a>

              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">Add New Pizza</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" method="POST" action="{{route('admin#addNewPizza')}}" enctype="multipart/form-data" >
                          @csrf
                        <div class="form-group row">
                          <label for="name" class="col-sm-3 col-form-label">Pizza Name</label>
                          <div class="col-sm-9">
                                <input type="text" class="form-control"  name="name" placeholder="Enter Pizza Name">
                                <p class="text-danger">
                                    @if ($errors->has('name'))
                                        {{$errors->first('name')}}
                                    @endif
                                </p>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="image" class="col-sm-3 col-form-label">Image</label>
                          <div class="col-sm-9">
                                <input type="file" class="form-control"  name="image" placeholder="Upload Pizza Photo">
                                <p class="text-danger">
                                    @if ($errors->has('image'))
                                        {{$errors->first('image')}}
                                    @endif
                                </p>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="price" class="col-sm-3 col-form-label">Price</label>
                          <div class="col-sm-9">
                                <input type="number" class="form-control"  name="price" placeholder="How much Price?">
                                <p class="text-danger">
                                    @if ($errors->has('price'))
                                        {{$errors->first('price')}}
                                    @endif
                                </p>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="publish" class="col-sm-3 col-form-label">Publish Status</label>
                          <div class="col-sm-9">
                                <select name="publish" class="form-control" id="">
                                    <option value="">Choose Option</option>
                                  <option value="1">Publish</option>
                                  <option value="0">Unpublish</option>
                                </select>
                                <p class="text-danger">
                                    @if ($errors->has('publish'))
                                        {{$errors->first('publish')}}
                                    @endif
                                </p>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="category" class="col-sm-3 col-form-label">Category ID</label>
                          <div class="col-sm-9">
                                <select name="category" class="form-control" id="">
                                    <option value="">Choose Category</option>
                                  @foreach ($category as $item)
                                      <option value="{{$item->category_id}}">{{$item->category_name}}</option>
                                  @endforeach
                                </select>
                                <p class="text-danger">
                                    @if ($errors->has('category'))
                                        {{$errors->first('category')}}
                                    @endif
                                </p>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="discount" class="col-sm-3 col-form-label">Discount Price</label>
                          <div class="col-sm-9">
                                <input type="number" class="form-control"  name="discount" placeholder="Any Discount?">
                                <p class="text-danger">
                                    @if ($errors->has('name'))
                                        {{$errors->first('name')}}
                                    @endif
                                </p>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="buy1get1" class="col-sm-3 col-form-label">Buy 1 Get 1</label>
                          <div class="col-sm-9 mt-2">
                                <input type="radio" name="buy1get1" value="1" class="form-input-check">Yes
                                <input type="radio" name="buy1get1" value="0" class="form-input-check">No
                                <p class="text-danger">
                                    @if ($errors->has('buy1get1'))
                                        {{$errors->first('buy1get1',"Need To Select Yes or No.")}}
                                    @endif
                                </p>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="waitingTime" class="col-sm-3 col-form-label">Waiting Time</label>
                          <div class="col-sm-9">
                                <input type="number" class="form-control"  name="waitingTime" placeholder="Time to Wait">
                                <p class="text-danger">
                                    @if ($errors->has('waitingTime'))
                                        {{$errors->first('waitingTime')}}
                                    @endif
                                </p>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="description" class="col-sm-3 col-form-label">Description</label>
                          <div class="col-sm-9">
                                <textarea name="description" class="form-control"  rows="3"></textarea>
                                <p class="text-danger">
                                    @if ($errors->has('description'))
                                        {{$errors->first('description')}}
                                    @endif
                                </p>
                          </div>
                        </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn bg-dark text-white float-end">Add</button>
                          </div>
                        </div>
                      </form>

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
