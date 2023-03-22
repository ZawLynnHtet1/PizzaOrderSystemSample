<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
     //redirect to admin profile page
     public function profile(){
        $id = auth()->user()->id;
        $userData = User::where('id','=',$id)->first();
        return view('admin.profile.admin_index')->with(['user'=>$userData]);
    }


    public function updateAdmin($id, Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $this->getAdminData($request);

        $update = User::where('id',$id)->update($data);
        return back()->with(['updateSuccess'=>"Admin Data is Now Updated!! HoooYayyy!!"]);
    }


    public function updatePassword($id, Request $request){
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->with(['errorMessage'=> "Need to Fill all fields to Change Password!!"])
                        ->withInput();
        }

        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $confirmPassword = $request->confirmPassword;

        $data= User::select('password')->where('id',$id)->first();
        $dbHashedPass =$data->password;

        if(Hash::check($oldPassword,$dbHashedPass)){

                if( strlen($newPassword)<8){
                    return back()->with(['lengthError'=>"New Password Length should be greater than 8 Characters."]);
                }elseif($newPassword !== $confirmPassword){

                    return back()->with(['matchError'=>"New Password and Confirm Password Do Not Match.Try Again."]);
                };

            $hashNewPass = Hash::make($newPassword);

            user::where('id',$id)->update([
                'password' => $hashNewPass,
            ]);

            return back()->with(['passUpdated'=>"Your Password is Successfully Updated!"]);

        }else{
           return back()->with(['oldError'=>"You Must Enter Correct Old Password to Proceed Changes,Try Again."]);
        };

    }

    //contanct user message view
    public function contactList(){

        $data = contact::orderBy('contact_id','desc')->paginate(5);

        if(count($data)==0){
            $emptyStatus = 0;
        }else{
            $emptyStatus=1;
        };

        return view('admin.contact.list')->with(['conData'=>$data, 'status'=>$emptyStatus]);
    }

    //contact user message search
    public function contactSearch(Request $request){
        $searchKey = $request->search;


        $searchData = contact::orWhere('name','like','%'.$searchKey.'%')
                                ->orWhere('email','like','%'.$searchKey.'%')
                                ->orWhere('message','like','%'.$searchKey.'%')
                                ->paginate(5);

        $searchData->appends($request->all());

        if(count($searchData)==0){
            $emptyStatus = 0;
        }else{
            $emptyStatus=1;
        };

        return view('admin.contact.list')->with(['conData'=>$searchData, 'status'=>$emptyStatus]);


    }
    //edit admin data from user tab
    public function adminDataEdit( $id){

        $userData = User::where('id','=',$id)->first();
        return view('admin.UserList.admin_role_edit')->with(['user'=>$userData]);
    }

    //update admin data from user tab
    public function updateAdminAonther(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'role' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = $this->getAdmin($request);

        $update = User::where('id',$id)->update($data);
        return redirect()->route('admin#adminListPage')->with(['updateSuccess'=>"Admin Data is Now Updated!! HoooYayyy!!"]);
    }

    private function getAdminData($request){
        $arr =[
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' =>$request->address,

        ];
        return $arr;
    }
    private function getAdmin($request){
        $arr =[
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' =>$request->address,
                'role'=>$request->role,

        ];
        return $arr;
    }
}
