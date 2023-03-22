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
                  <legend class="text-center">Pizza Info</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane d-flex justify-content-center" id="activity">
                        <div class="mt-2 ms-2 text-center">
                            <img src="{{asset('uploads/'.$info->image)}}" class="img-thumbnail rounded-circle" style="width:190px;height:190px"   alt="">
                        </div>
                        <div class="ms-4">
                            <div class="mt-3">
                                <b>Name :   </b><span>{{$info->pizza_name}}</span>
                            </div>
                            <div class="mt-3">
                                <b>Price :   </b><span>{{$info->price}}</span>
                            </div>
                            <div class="mt-3">
                                <b>Public Status :   </b>
                                <span>
                                    @if ($info->publish_status ==1)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </span>
                            </div>
                            <div class="mt-3">
                                <b>Category :   </b>
                                <span>
                                    @if ($info->publish_status ==1)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </span>
                            </div>

                            <div class="mt-3">
                                <b>Discount :   </b><span>{{$info->discount_price}}</span>
                            </div>
                            <div class="mt-3">
                                <b>Buy One Get One :   </b>
                                <span>
                                    @if ($info->buy_one_get_one_status ==1)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </span>
                            </div>
                            <div class="mt-3">
                                <b>Waiting Time :   </b><span>{{$info->waiting_time}}</span>
                            </div>
                            <div class="mt-3">
                                <b>Description :   </b><span>{{$info->description}}</span>
                            </div>
                        </div>
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
