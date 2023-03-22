<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    //user list page
    public function userListPage(){
        $data=User::where('role','user')->paginate(4);
        return view('admin.UserList.user_list')->with(['user'=>$data]);
    }
    //user list search
    public function userListSearch(Request $request){
        $returnDataAccept = $this->search('user',$request);

        return view('admin.UserList.user_list')->with(['user'=>$returnDataAccept]);
    }

    //user delete
    public function userDelete($id){
        $data =User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>"A user is now deleted successfully!!!"]);
    }
    //admin list page
    public function adminListPage(){
        $data=User::where('role','admin')->paginate(4);
        return view('admin.UserList.admin_list')->with(['admin'=>$data]);
    }

    //admin list search
    public function adminListSearch(Request $request){
        $returnDataAccept = $this->search('admin',$request);

        return view('admin.UserList.admin_list')->with(['admin'=>$returnDataAccept]);
    }

    //admin delete
    public function adminDelete($id){
        $data = User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>"An Admin Account is Now Deleted Successfully~~~"]);
    }

    //priate function for search user and admin account
    private function search($role,$request){

        $data = User::where('role',$role)
                        ->where(function($query) use($request){
                                $query
                                ->orWhere('name','like','%'.$request->search.'%')
                                ->orWhere('email','like','%'.$request->search.'%')
                                ->orWhere('address','like','%'.$request->search.'%')
                                ->orWhere('phone','like','%'.$request->search.'%');
                        })
                        ->paginate(4);

         $data->appends($request->all());
         return $data;
    }
}
