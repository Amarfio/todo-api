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

Route::group(["prefix"=>"v1"],function(){

    //-------------------------routes for the main module thus the Todo module-----------------
    Route::post("todos",[TodoController::class, "store"]);
    Route::get("todos",[TodoController::class,"getAllTodos"]);
    Route::get("todos/{id}",[TodoController::class,"get"]);
    Route::put("todos/{id}",[TodoController::class, "update"]);
    Route::put("todos/status/{id}", [TodoController::class, "updateTodoStatus"]);

    //-------------------------routes for settings endpoints----------------------

    //routes for configuring code types
    Route::post("/settings/codetypes", [SettingsController::class, "addCodeType"]);
    Route::get("/settings/codetypes", [SettingsController::class, "getAllCodeTypes"]);
    Route::get("/settings/codetypes/{id}", [SettingsController::class, "getCodeType"]);
    Route::put("/settings/codetypes/{id}", [SettingsController::class, "updateCodetype"]);

    //routes for configuring codescs
    Route::post("/settings/codescs", [SettingsController::class, "addCodesc"]);
    Route::get("/settings/codescs",[SettingsController::class,"getAllCodescs"]);
    Route::get("/settings/codescs/{id}", [SettingsController::class, "getCodescById"]);
    Route::put("/settings/codescs/{id}", [SettingsController::class, "updateCodesc"]);
    Route::get("/settings/codescs/codetypes/{codeTypeId}", [SettingsController::class, "getCodescByCodeId"]);

    //---------------------------routes for user endponts -----------------------------

    //route for users
    Route::post("/users", [UsersController::class, "addUser"]);
    Route::get("/users", [UsersController::class, "getAllUsers"]);

});

