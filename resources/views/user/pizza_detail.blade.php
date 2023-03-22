@extends('user.layouts.common_layout')

@section('content')
<div class=" row ms-2  my-5 display-flex justify-content-center">
    <div class="col-4">
        <img src="{{asset('uploads/'.$data->image)}}" width="100%" alt="">  <br>
        <a href="{{route('user#orderPizza')}}">
            <button class="btn btn-primary float-end mt-2 col-12"> <i class="fas fa-shopping-cart"></i> Order</button>
        </a>
        <a href="{{route('user#index')}}">
            <button class="btn bg-dark text-white" style="margin-top:20px;">
                <i class="fas fa-backspace"></i>Back
            </button>
        </a>

    </div>
    <div class="col-7">
        <h5>Name</h5>
        <small>{{$data->pizza_name}}</small><hr>
        <h5>Price</h5>
        <small>{{$data->price}}</small>Kyats<hr>
        <h5>Price</h5>
        <small>{{$data->price}}</small>Kyats<hr>
        <h5>Discount Price</h5>
        <small>{{$data->discount_price}}</small>Kyats<hr>
        <h5>Buy One Get One</h5>
        <small>
        @if ($data->buy_one_get_one_status == 0)
            NO

        @else
            YES
        @endif
        </small><hr>

        <h5>Waiting Time</h5>
        <small>{{$data->waiting_time}}</small>Minutes<hr>

        <h5>Description</h5>
        <small>{{$data->description}}</small>
        <br><br>
        <div class="">
            <h5 class="text-danger">Total Price</h5>
            <h3 class="text-success">{{$data->price - $data->discount_price}}Kyats</h3>
        </div>
    </div>
</div>


@endsection
