<?php

namespace App\Http\Controllers\API;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class APIController extends Controller
{
    //category list only get method api

    public function categoryList(){
        $data = category::get();

        $category = [

            'status'=> 'success',
            'data' => $data,

        ];
        return Response::json($category);
    }

    //category create with post

    public function categoryCreate(Request $request){

        $data = [
            'category_name' => $request->categoryName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ];

        category::create($data);

        $feedback = ['status'=> 200,'message'=> 'success'];

        return Response::json($feedback);

    }

    public function detail(Request $request){
        $id = $request->id;

        $data = category::where('category_id',$id)->first();

        if(!empty($data)){
            return Response::json(['status'=> 200, 'message'=> 'success', 'data'=>$data]);
        }else{
            return Response::json(['status'=> 200, 'message' => 'fail', 'data'=>$data]);
        }
    }

    public function delete($id){
        $data = category::where('category_id',$id)->first();

        if(empty($data)){
            return Response::json(['status'=>'fail','message'=>'no such id to delete']);
        }
        category::where('category_id',$id)->delete();
        return Response::json(['status'=>200,'message'=>'Data have been deleted']);
    }

    public function update(Request $request, $id){

        $data = [
            'category_name' => $request->categoryName,
            'updated_at' => Carbon::now(),
        ];

        $check = category::where('category_id',$id)->first();

        if(!empty($check)){
            category::where('category_id',$id)->update($data);
            return Response::json(['status'=>200, 'message'=> 'update success']);
        }else{
            return Response::json(['status'=>200,'message'=>'fail to update, no such id']);
        }
    }


}
