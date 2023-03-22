<?php

namespace App\Http\Controllers\Admin;

use auth;
use Laracsv\Export;
use App\Models\User;

use App\Models\pizza;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    //redirect to admin category
    public function category(){
        if(session::has('CATEGORY_SEARCH')){
            session::forget('CATEGORY_SEARCH');
        }
        $data = category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
                ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
                ->groupBy('categories.category_id')
                ->paginate(5);
        return view('admin.category.ad_cat_list')->with(['category'=>$data]);
    }

    //redirect to admin add category
    public function addCategory(){
        return view('admin.category.ad_addCategory');
    }

    //redirect to admin create new category
    public function createCategory(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data =[
            'category_name' => $request->name,
        ];

        category::create($data);

        return redirect()->route('admin#category')->with(['addSuccess'=>"New Category Successfully Added"]);

    }

    //redirect to delete admin category
    public function deleteCategory($id){
        category::where('category_id','=',$id)->delete();
        return back()->with(['deleteSuccess'=>"Category is Successfully Deleted!!"]);
    }

    //redirect to edit admin category
    public function editCategory($id){
        $data = category::where('category_id',$id)->first();

        return view('admin.category.ad_updateCategory')->with(['category'=>$data]);

    }

    //redirect to final update category

    public function updateCategory(/*$id,*/Request $request){

        // $data =[
        //     'category_name'=>$request->name,
        // ];
        // category::where('category_id',$id)->update($data);

        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        //hidden text carry the id
            $data = [
                'category_id'=> $request->id,
                'category_name'=> $request->name,
            ];

            category::where('category_id',$data['category_id'])->update($data);


        return redirect()->route('admin#category')->with(['updateSuccess'=>"Category Updated"]);
    }

    //search category
    public function searchCategory(Request $request){
        // $data = category::where('category_name','like','%'.$request->search.'%')->paginate(5);

        $data = category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
        ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
        ->groupBy('categories.category_id')
        ->where('category_name','like','%'.$request->search.'%')
        ->paginate(5);

        Session::put('CATEGORY_SEARCH',$request->search);

        $data -> appends($request->all());
        return view('admin.category.ad_cat_list')->with(['category'=>$data]);
    }

    public function categoryItem($id){
        $data= pizza::select()
        ->join('categories','pizzas.category_id','categories.category_id')
        ->where('pizzas.category_id',$id)->paginate(2);
        return view('admin.category.categoryItem')->with(['itemList'=>$data]);
    }

    //download Category CSV
    public function downloadCSV(){
        // $category = category::get();

        if(Session::has('CATEGORY_SEARCH')){
            $category = category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
            ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
            ->groupBy('categories.category_id')
            ->where('category_name','like','%'.Session::get('CATEGORY_SEARCH').'%')
            ->get();

        }else{
            $category = category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
                                ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
                                ->groupBy('categories.category_id')
                                ->get();
        }



        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($category,[
            'category_id'=>'ID',
            'category_name'=>'Category Name',
            'count'=>'Product Count',
            'created_at'=>'Created Date',
            'updated_at'=>'Updated Date',
        ]);
        $csvReader = $csvExporter->getReader();
        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);
        $filename = 'categoryList.csv';

        return response((string)$csvReader)
                        ->header('Content-Type','text/csv; charset=UTF-8')
                        ->header('Content-Disposition','attachment;filename="'.$filename.'"');
    }

}

