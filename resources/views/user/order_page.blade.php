@extends('user.layouts.common_layout')

@section('content')
<div class=" row ms-2  my-5 display-flex justify-content-center">
    <div class="col-4">
        <img src="{{asset('uploads/'.$data->image)}}" width="100%" alt="">  <br>
        <a href="{{route('user#orderPizza')}}">
            <button class="btn btn-primary float-end mt-2 col-12"> <i class="fas fa-shopping-cart"></i> Order</button>
        </a>
        <a href="{{route('user#moreDetail',$data->pizza_id)}}">
            <button class="btn bg-dark text-white" style="margin-top:20px;">
                <i class="fas fa-backspace"></i>Back
            </button>
        </a>

    </div>
    <div class="col-7">
        @if (Session::has('waitTime'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            Your Order is now success!! Please wait for {{Session::get('waitTime')}} Minutes..
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        <h5>Name</h5>
        <small>{{$data->pizza_name}}</small><hr>
        <h5>Price</h5>
        <small>{{$data->price - $data->discount_price}}</small>Kyats<hr>

        <h5>Waiting Time</h5>
        <small>{{$data->waiting_time}}</small>Minutes<hr>
        <form action="{{route('user#placeOrder')}}" method="POST">
            @csrf
            <h5>Pizza Count</h5>
            <input type="number" name="pizzaCount" placeholder="Enter number of pizzas to order" min="1" max="10" class="form-control" id="">
            <p class="text-danger">
                @if ($errors->has('pizzaCount'))
                    {{$errors->first('pizzaCount',"At least one Pizza is needed to place your order.")}}
                @endif
            </p>
            <hr>

            <h5>Pizza Count</h5>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="paymentType" id="inlineRadio1" value="1">
                <label for="inlineRadio1">Credit Card</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="paymentType" id="inlineRadio2" value="1">
                <label for="inlineRadio1">Cash</label>
            </div>
            <p class="text-danger">
                @if ($errors->has('paymentType'))
                    {{$errors->first('paymentType',"Select a Payment Method")}}
                @endif
            </p>
            <hr>
            <button type="submit" class="btn btn-primary  mt-2 col-12"> <i class="fas fa-shopping-cart"></i> Place Order</button>
        </form>

    </div>
</div>


@endsection
