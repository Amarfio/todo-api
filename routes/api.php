<?php

use App\Http\Controllers\SettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UsersController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["prefix"=>"todo"],function(){

    //routes for the main module thus the Todo module
    Route::post("/add",[TodoController::class, "store"]);
    Route::get("/get-all",[TodoController::class,"getAllTodos"]);
    Route::get("/{id}",[TodoController::class,"get"]);
    Route::put("/update/{id}",[TodoController::class, "update"]);
    Route::put("/change-status/{id}", [TodoController::class, "updateTodoStatus"]);

    //-------------------------routes for settings endpoints----------------------

    //routes for configuring code types
    Route::post("/settings/codetype/add", [SettingsController::class, "addCodeType"]);
    Route::get("/settings/codetype/get-all", [SettingsController::class, "getAllCodeTypes"]);
    Route::get("/settings/codetype/{id}", [SettingsController::class, "getCodeType"]);
    Route::put("/settings/codetype/update/{id}", [SettingsController::class, "updateCodetype"]);

    //routes for configuring codescs
    Route::post("/settings/codesc/add", [SettingsController::class, "addCodesc"]);
    Route::get("/settings/codesc/get-all",[SettingsController::class,"getAllCodescs"]);
    Route::get("/settings/codesc/{id}", [SettingsController::class, "getCodescById"]);
    Route::put("/settings/codesc/update/{id}", [SettingsController::class, "updateCodesc"]);
    Route::get("/settings/codesc/codetype/{codeTypeId}", [SettingsController::class, "getCodescByCodeId"]);

    //route for users
    Route::get("/user/get-all", [UsersController::class, "getAllUsers"]);

});

