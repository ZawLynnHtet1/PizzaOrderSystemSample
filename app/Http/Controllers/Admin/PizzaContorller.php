<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\pizza;
use App\Models\category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PizzaContorller extends Controller
{
        //redirect to admin pizza list
        public function pizza(){
            $data = pizza::paginate(2);
            if(count($data)==0){
                $emptyStatus = 0;
            }else{
                $emptyStatus=1;
            };
            if(Session::has('PIZZA_SEARCH')){
                Session::forget('PIZZA_SEARCH');
                // dd('there is a sesssion');
            }
            return view('admin.pizza.ad_pizza_list')->with(['pizza'=>$data, 'status'=>$emptyStatus]);
        }

        //redirect to add page not update yet
        public function addPizzaPage(){
            $category = category::get();
            return view('admin.pizza.create')->with(['category'=>$category]);
        }

        public function addNewPizza(Request $request){

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'image' => 'required',
                'price' => 'required',
                'publish' => 'required',
                'category' => 'required',
                'discount' => 'required',
                'buy1get1' => 'required',
                'waitingTime' => 'required',
                'description' => 'required',


            ]);

            if ($validator->fails()) {
                return back()
                            ->withErrors($validator)
                            ->withInput();
            }

            //store image in the public folder
            $file = $request->file('image');
            $fileName = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads',$fileName);


            $data = $this->requestNewPizza($request,$fileName);
            $add = pizza::create($data);
            return redirect()->route('admin#pizza')->with(['addSuccess'=>"HooYay!! New Pizza Added Successfully, Eat em all!!"]);
        }

        public function deletePizza($id){

                //for image delete in public folder
            $forImg = pizza::select('image')->where('pizza_id',$id)->first();

            $imgName = $forImg['image'];

            if(File::exists(public_path().'/uploads/'.$imgName)){
                File::delete(public_path().'/uploads/'.$imgName);
            }

                //image delete end


                //db delete
            $data = pizza::where('pizza_id',$id)->delete();

            return back()->with(['deleteSuccess'=>"The pizza is now deleted,have fun.."]);
        }



        public function infoPizza($id){

            $data = pizza::where('pizza_id',$id)->first();

            return view('admin.pizza.pizza_info')->with(['info'=>$data]);
        }


        public function editPizza($id){
            $category = category::get();
            $data=pizza::
                        select('pizzas.*','categories.category_id','category_name')
                        ->join('categories','pizzas.category_id','=','categories.category_id')
                        ->where('pizza_id',$id)
                        ->first();
            return view('admin.pizza.edit')->with(['category'=>$category, 'data'=>$data]);
        }


        public function updatePizza($id, Request $request){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required',
                'publish' => 'required',
                'category' => 'required',
                'discount' => 'required',
                'buy1get1' => 'required',
                'waitingTime' => 'required',
                'description' => 'required',


            ]);

            if ($validator->fails()) {
                return back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $data = $this->requestUpdateData($request);

            //is new image there or not??
            if(isset($data['image'])){

                //get old img name from model
                $img = pizza::select('image')->where('pizza_id',$id)->first();
                $imgName = $img->image;

                //delete old img in public folder
                    if(file::exists(public_path().'/uploads/'.$imgName)){
                        file::delete(public_path().'/uploads/'.$imgName);
                    }

                //move new img to public folder
                $newImg =$request->file('image');

                $newImgName = uniqid().'_'.$newImg->getClientOriginalName();

                $newImg->move(public_path().'/uploads/',$newImgName);

                //add the new img name to the database img name
                $data['image']=$newImgName;


                //final update image and contents to database with image case
                pizza::where('pizza_id',$id)->update($data);

                return redirect()->route('admin#pizza')->with(['updateSuccess'=>"Pizza Updated Successfully!!"]);


            }else{
               pizza::where('pizza_id',$id)->update($data);
               return redirect()->route('admin#pizza')->with(['updateSuccess'=>"Pizza Updated Successfully but not image yet!!!"]);
            }

        }

        public function searchPizza(Request $request){
            $searchKey = $request->table_search;
            $searchData = pizza::orWhere('pizza_name','like','%'.$searchKey.'%')
                                ->orWhere('price','like','%'.$searchKey.'%')
                                ->paginate(2);
            Session::put('PIZZA_SEARCH',$searchKey);
            $searchData->appends($request->all());
                if(count($searchData) == 0){
                    $emptyStatus = 0;
                }else{
                    $emptyStatus = 1;
                }
            return view('admin.pizza.ad_pizza_list')->with(['pizza'=>$searchData,'status'=>$emptyStatus]);
        }

        private function requestUpdateData($request){

            $arr= [
                'pizza_name' => $request->name,
                'price' => $request->price,
                'publish_status' => $request->publish,
                'category_id' => $request->category,
                'discount_price' => $request->discount,
                'buy_one_get_one_status' => $request->buy1get1,
                'waiting_time' => $request->waitingTime,
                'description' => $request->description,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];


            if(isset($request->image)){
                $arr['image']=$request->image;
            }

            return $arr;
        }

        public function downloadPizzaCSV(){
            if(Session::has('PIZZA_SEARCH')){
                $pizza = pizza::orWhere('pizza_name','like','%'.Session::get('PIZZA_SEARCH').'%')
                ->orWhere('price','like','%'.Session::get('PIZZA_SEARCH').'%')
                ->get();

            }else{
                $pizza = pizza::get();
            }



            $csvExporter = new \Laracsv\Export();
            $csvExporter->build($pizza,[
                'pizza_id'=>'ID',
                'pizza_name'=>'Pizza Name',
                // 'image'=>'Pizza Image',
                'price'=>'Pizza Price',
                'publish_status'=>'Publih Status',
                'category_id'=>'Category Id',
                'discount_price'=>'Discount Price',
                'buy_one_get_one_status'=>'Buy One Get One',
                'waiting_time'=>'Wait Time',
                'description'=>'Description',
                'created_at'=>'Created Date',
                'updated_at'=>'Updated Date',
            ]);
            $csvReader = $csvExporter->getReader();
            $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);
            $filename = 'pizzaList.csv';

            return response((string)$csvReader)
                            ->header('Content-Type','text/csv; charset=UTF-8')
                            ->header('Content-Disposition','attachment;filename="'.$filename.'"');
        }



        private function requestNewPizza($request,$fileName){
            return [
                'pizza_name' => $request->name,
                'image' => $fileName,
                'price' => $request->price,
                'publish_status' => $request->publish,
                'category_id' => $request->category,
                'discount_price' => $request->discount,
                'buy_one_get_one_status' => $request->buy1get1,
                'waiting_time' => $request->waitingTime,
                'description' => $request->description,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
}
