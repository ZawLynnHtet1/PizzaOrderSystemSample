<?php

namespace App\Http\Controllers;

use auth;
use Carbon\Carbon;
use App\Models\order;
use App\Models\pizza;
use App\Models\contact;
use App\Models\category;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //redirect user home page
    public function index(){

        $data = pizza::where('publish_status',1)->paginate(3);
        $status = count($data)==0 ? 0:1;
        $category = category::get();
        return view('user.home')->with(['data'=>$data, 'category'=>$category, 'status'=>$status]);
    }


    public function userContact(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->with(['errorMessage'=> "Need to Fill all fields to Change Password!!"])
                        ->withInput();
        }
        $data = $this->userDataRequest($request);
        contact::create($data);

        return back()->with(['contactSuccess'=>"Your Contact Message Have Sent!!"]);

    }

    //category link user press search
    public function categoryLink($id){
        $data = pizza::where('category_id',$id)->paginate(3);

        $status = count($data)==0 ? 0:1;

        $category = category::get();
        return view('user.home')->with(['data'=>$data, 'category'=>$category, 'status'=>$status]);
    }


    //user search pizza in user interface

    public function searchPizza(Request $request){
        $searchKey = $request->searchData;

        $data = pizza::orWhere('pizza_name','like','%'.$searchKey.'%')
                        ->paginate(3);
        $data->appends($request->all());

        $status = count($data)==0 ? 0:1;

        $category = category::get();
        return view('user.home')->with(['data'=>$data, 'category'=>$category, 'status'=>$status]);
    }

    //user price min-max date time search
    public function minMaxDateTime(Request $request){
        $min = $request->minPrice;
        $max = $request->maxPrice;
        $startDate = $request->startDate;
        $endDate = $request->endDate;



        $query = pizza::select('*');

        if(!is_null($startDate) && is_null($endDate)){

            $query = $query->whereDate('created_at','>=',$startDate);

        }else if(is_null($startDate) && !is_null($endDate)){

            $query = $query->whereDate('created_at','<=',$endDate);

        }else if(!is_null($startDate) && !is_null($endDate)){

           $query =  $query->whereDate('created_at','>=',$startDate)
                    ->whereDate('created_at','<=',$endDate);

        };

        if(!is_null($min) && is_null($max) ){

            $query = $query->where('price','>=',$min);

        }elseif(is_null($min) && !is_null($max)){

            $query = $query->where('price','<=',$max);

        }elseif(is_null($min) && is_null($max)){

            $query = $query->where('price','>=',$min)
                    ->where('price','<=',$max);

        }

        $query = $query->paginate(5);
        $query->appends($request->all());

        $status = count($query) == 0 ? 0:1;

        $category = category::get();
        return view('user.home')->with(['data'=>$query, 'category'=>$category, 'status'=>$status]);

    }

    //pizza more detail

    public function moreDetail($id){
        $data = pizza::where('pizza_id',$id)->first();
        Session::put('PIZZA_DATA',$data);
        return view('user.pizza_detail')->with(['data'=>$data]);
    }

    //user pizza order page
    public function orderPizza(){
        $pizzaSessionData = Session::get('PIZZA_DATA');

        return view('user.order_page')->with(['data'=>$pizzaSessionData]);
    }


    //place order
    public function placeOrder(Request $request){
        $pizzaSessionData = Session::get('PIZZA_DATA');
        $count = $request->pizzaCount;
        $userId = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'paymentType' => 'required',
            'pizzaCount' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = $this->getOrderData($request,$pizzaSessionData,$userId);




        for($i=0;$i<$count;$i++){
            order::create($data);
        };

        $waitingTime = $pizzaSessionData['waiting_time'] * $count;

        return back()->with(['waitTime'=>$waitingTime]);


    }

    private function userDataRequest($request){
        return [
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'message'=>$request->message,
        ];
    }


    //to write order data to DB
    private function getOrderData($request,$pizzaSessionData,$userId){
        return [
            'customer_id' => auth()->user()->id,
            'pizza_id' => $pizzaSessionData['pizza_id'],
            'carrier_id' => 0 ,
            'payment_status' => $request->paymentType,
            'order_time' =>Carbon::now(),
        ];
    }
}
