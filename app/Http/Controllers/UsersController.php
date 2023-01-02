<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //method to get all users
    public function getAllUsers(){
        //for response level
        $result = null;

        try{
            $countUsers = User::all()->count();
            $users = null;
            if($countUsers > 0){
                $users = User::all();
                $result = response(array("responseCode"=>200, "message"=> "success", "data"=> $users), 200);
            }else{
                $result = response(array("responseCode"=>200, "message"=> "no user found", "data"=> null), 200);
            }
            return $result;
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            // return response()->json(null, 417);
            return response($result, 417);
        }
    }
}
