<?php

namespace App\Http\Controllers\Admin;

use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function orderList(){

       $data = order::select('orders.*','users.name as userName','pizzas.pizza_name as pizzaName',DB::raw('COUNT(orders.pizza_id) as count'))
                ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
                ->join('users','users.id','orders.customer_id')
                ->groupBy('orders.customer_id','orders.pizza_id')

                ->paginate(4);


        return view('admin.order.order_list')->with(['order'=>$data]);
    }

    //admin order search
    public function orderSearch(Request $request){
        $searchKey = $request->search;
        $searchData = order::select('pizzas.pizza_name as pizzaName','users.name as userName',DB::raw('COUNT(orders.order_id) as count'))
                            ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
                            ->join('users','users.id','orders.customer_id')
                            ->groupBy('orders.customer_id','orders.pizza_id');
        $searchData = $searchData->orWhere('users.name','like','%'.$searchKey.'%')
                                    ->orWhere('pizzas.pizza_name','like','%'.$searchKey.'%')
                                    ->paginate(5);

        $searchData->appends($request->all());

        return view('admin.order.order_list')->with(['order'=>$searchData]);
    }
}
