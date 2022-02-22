<?php

use App\Http\Controllers\AclController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\QuestionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'guest:api'], function (){
    Route::post('login', [AuthController::class, 'login']);

    Route::post('register', [AuthController::class, 'register']);
});


Route::group(['middleware' => 'auth:api'], function (){

    /* all permissions without group name
    */
   Route::get('/all_permissions', [AclController::class, 'allPermission']);
   /**
    * /this route for listing all perm  if Id is given it will return  the user with that all his permissions
    */

   Route::get('/permissions',[AclController::class, 'Permissions']);
   /**
    * permissions In Role
    */
   Route::get('/permissions/{id}', [AclController::class, 'index']);

   /**
    * this is the url for get all roles
    */

   Route::get('/roles/{id}', [AclController::class, 'show']);
   /**
    *  //this is the url for Put  roles with permeission
    */
   Route::put('/roles/{id}', [AclController::class, 'update']);


   Route::put('/roles/sync/{id}',[AclController::class, 'syncToUser']);

   /**
    * // this URL for assign roles to user
    */
   Route::delete('/roles_delete/{id}',[AclController::class, 'delete']);
   /**
    * this is the url for get all roles
    */
   Route::get('/roles', [AclController::class, 'roles']);
   /**
    * this is the url for get all roles
    */
   Route::post('/roles/store ', [AclController::class, 'store']);
});
//test
   // category
    Route::resource('category',  CategoryController::class);
      //order
      Route::post('/category-order', [CategoryController::class, 'order']);
    // subCategory
    Route::resource('subCategory', SubcategoryController::class);
     //order
     Route::post('/subCategory-order', [SubcategoryController::class, 'order']);
    // questions
    Route::resource('questions', QuestionController::class);
    Route::post('/filter-questions', [QuestionController::class, 'filter']);

    //add Daily quiz
    Route::post('/add-daily-quiz', [QuestionController::class, 'addDailyQuize']);
    Route::delete('/delete-daily-quiz/{id}', [QuestionController::class, 'deleteDailyQuize']);
    Route::post('/filter-daily-questions', [QuestionController::class, 'daily_filter']);

// });
