<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserCheckMiddleware;
use App\Http\Middleware\AdminCheckMiddleware;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PizzaContorller;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        // return view('dashboard');
        if(Auth::check()){
            if(Auth::user()->role == 'user'){
                return redirect()->route('user#index');
            }elseif(Auth::user()->role == 'admin'){
                return redirect()->route('admin#profile');
            }
        }


    })->name('dashboard');
});


Route::prefix('admin')->middleware([AdminCheckMiddleware::class])->group(function () {


    //category section
    Route::get('/profile',[AdminController::class,'profile'])->name('admin#profile');
    Route::post('/profile/{id}',[AdminController::class,'updateAdmin'])->name('admin#updateAdminData');
    Route::post('/changePassword/{id}',[AdminController::class,'updatePassword'])->name('admin#updatePassword');


    Route::get('/category',[CategoryController::class,'category'])->name('admin#category');//category show list
    Route::get('/addCategory',[CategoryController::class,'addCategory'])->name('admin#addCategory');
    Route::post('/createCategory',[CategoryController::class,'createCategory'])->name('admin#createCategory');
    Route::get('/deleteCategory/{id}',[CategoryController::class,'deleteCategory'])->name('admin#deleteCategory');
    Route::get('/editCategory/{id}',[CategoryController::class,'editCategory'])->name('admin#editCategory');
    //update category name with normal carry id
    // Route::post('/updateCategory/{id}',[CategoryController::class,'updateCategory'])->name('admin#updateCategory');

    //id carrying with hidden input text
    Route::post('/updateCategory',[CategoryController::class,'updateCategory'])->name('admin#updateCategory');

    //search category
    Route::get('/category/search',[CategoryController::class,'searchCategory'])->name('admin#searchCategory');

    //detail item view
    Route::get('/categoryItem/{id}',[CategoryController::class,'categoryItem'])->name('admin#categoryItem');


    //pizza section
    Route::get('/pizza',[PizzaContorller::class,'pizza'])->name('admin#pizza');
    Route::get('/addPizza',[PizzaContorller::class,'addPizzaPage'])->name('admin#addPizzaPage');
    Route::post('/addPizza',[PizzaContorller::class,'addNewPizza'])->name('admin#addNewPizza');
    Route::get('/deletePizza/{id}',[PizzaContorller::class,'deletePizza'])->name('admin#deletePizza');
    Route::get('/pizzaInfo/{id}',[PizzaContorller::class,'infoPizza'])->name('admin#pizzaInfo');
    Route::get('/pizzaEdit/{id}',[PizzaContorller::class,'editPizza'])->name('admin#pizzaEdit');
    //update pizza
    Route::post('/pizzaEdit/{id}',[PizzaContorller::class,'updatePizza'])->name('admin#pizzaUpdate');
    //Search
    Route::get('/pizza/Search',[PizzaContorller::class,'searchPizza'])->name('admin#pizzaSearch');


    //user page
    Route::get('/userList',[AdminUserController::class,'userListPage'])->name('admin#userListPage');
    //user page search
    Route::get('/userList/search',[AdminUserController::class,'userListSearch'])->name('admin#userListSearch');
    //user delete
    Route::get('/userDelete/{id}',[AdminUserController::class,'userDelete'])->name('admin#userDelete');

    //admin page
    Route::get('/adminList',[AdminUserController::class,'adminListPage'])->name('admin#adminListPage');
    //admin search
    Route::get('/adminList/search',[AdminUserController::class,'adminListSearch'])->name('admin#admnListSearch');
    //admin delete
    Route::get('/adminList/delete/{id}',[AdminUserController::class,'adminDelete'])->name('admin#adminDelete');
    //admin user contact view page
    Route::get('/userContactList',[AdminController::class,'contactList'])->name('admin#contactList');
    //admin user contact search
    Route::get('userContactSearch',[AdminController::class,'contactSearch'])->name('admin#contactSearch');

    //admin order list view
    Route::get('orderList',[OrderController::class,'orderList'])->name('admin#orderList');
    //admin order list search
    Route::get('orderSearch',[OrderController::class,'orderSearch'])->name('admin#orderSearch');
    //download category csv
    Route::get('category/download',[CategoryController::class,'downloadCSV'])->name('admin#downloadCSV');
    //download pizza csv
    Route::get('pizza/download',[PizzaContorller::class,'downloadPizzaCSV'])->name('admin#downloadPizzaCSV');
    //edit admin data from user tab
    Route::get('edit/adminData/{id}',[AdminController::class,'adminDataEdit'])->name('admin#editData');
    //update admin data from user tab
    Route::post('/profileEdit/{id}',[AdminController::class,'updateAdminAonther'])->name('admin#updateAdminDataAnother');

});



Route::prefix('user')->middleware([UserCheckMiddleware::class])->group(function () {

    Route::get('/profile',[UserController::class,'index'])->name('user#index');


    //user contact form route
    Route::post('userContact',[UserController::class,'userContact'])->name('user#userContact');
    //user category search
    Route::get('/categoryLink/{id}',[UserController::class,'categoryLink'])->name('user#categoryLink');
    //user search bar search
    Route::get('/searchPizza',[UserController::class,'searchPizza'])->name('user#searchPizza');
    //user search using date time min-max
    Route::get('/minMaxDateTime',[UserController::class,'minMaxDateTime'])->name('user#minMaxDateTime');
    //pizza detail user side
    Route::get('/moreDetail/{id}',[UserController::class,'moreDetail'])->name('user#moreDetail');
    //pizza order page
    Route::get('/orderPizza',[UserController::class,'orderPizza'])->name('user#orderPizza');
    //pizza place order
    Route::post('/placeOrder',[UserController::class,'placeOrder'])->name('user#placeOrder');

});


