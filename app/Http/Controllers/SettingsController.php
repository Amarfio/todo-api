<?php

namespace App\Http\Controllers;

use App\Models\Code_type;
use App\Models\Codesc;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{

    //method to create a code type
    public function addCodeType(Request $request){

        //result to be stored here
        $result = null;


        try{

            $codeType = Code_type::create([
                'code'=>strtoupper($request->code),
                'description'=>$request->description
            ]);

            //check if code type has been added with count
            if ($codeType!=null) {
                $result = array("responseCode" => 200, "message" => "success", "data" => $codeType);
            }
            else{
                $result = array("responseCode"=>417, "message"=>"failed", "data"=> null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            return response()->json($result);
        }
    }


    //method to get all code types
    public function getAllCodeTypes(){
        //for response level
        $result = null;

        try{
            $countCodetypes = Code_type::all()->count();
            $codetypes = null;
            if($countCodetypes > 0){
                $codetypes = Code_type::all();
                $result = array("responseCode"=>200, "message"=> "success", "data"=> $codetypes);
            }else{
                $result = array("responseCode"=>417, "message"=> "failed", "data"=> null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            // return response()->json(null, 417);
            return response()->json($result);
        }
    }

    //method to get code type by id
    public function getCodeType(Request $request) {
        //for response level
        $result = null;
        try{
            $countCodetype = Code_type::where('id', $request->id)->count();
            $codetype = null;
            if($countCodetype>0){
                $codetype = Code_type::where('id', $request->id)->get();
                $result = array("responseCode" => 200, "message" => "success", "data" => $codetype);
            }else{
                $result = array("responseCode" => 417, "message" => "failed", "data" => null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            return response()->json($result);
        }
    }

    //method to add to the codescs table
    public function addCodesc(Request $request){
        //for response level
        $result = null;

        try{
            $codesc = Codesc::create([
                'code_type_id' => $request->codeTypeId,
                'code' => strtolower($request->code) ,
                'description'=> $request->description,
            ]);

            if($codesc!=null){
                $result = array("responseCode"=>200, "message"=> "success", "data"=> $codesc);
            }else{
                $result = array("responseCode"=>417, "message"=> "failed", "data"=> null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            // return response()->json(null, 417);
            return response()->json($result);
        }
    }

    //method to add to the codescs table
    public function updateCodesc(Request $request){
        //for response level
        $result = null;

        try{
            $codescCount = Codesc::where(['id'=> $request->id])
                           ->update(['code_type_id'=> $request->code_type_id,
                                     'code'=>$request->code,
                                     'description'=>$request->description,
                                     'isActive'=>$request->isActive]);
            $codesc = null;
            if($codescCount==1){
                $codesc = Codesc::where(['id' => $request->id])->get();
                $result = array("responseCode"=>200, "message"=> "success", "data"=> $codesc);
            }else{
                $result = array("responseCode"=>417, "message"=> "failed", "data"=> null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            // return response()->json(null, 417);
            return response()->json($result);
        }
    }

    //method to get all values added in the codesc table
    public function getAllCodescs(){
        //for response level
        $result = null;

        try{
            $countCodescs = Codesc::all()->count();
            $codescs = null;
            if($countCodescs > 0){
                $codescs = Codesc::all();
                $result = array("responseCode"=>200, "message"=> "success", "data"=> $codescs);
            }else{
                $result = array("responseCode"=>417, "message"=> "failed", "data"=> null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            // return response()->json(null, 417);
            return response()->json($result);
        }
    }

    //method to get codesc by its id
    public function getCodescById(Request $request){
        //for response level
        $result = null;
        $codesc = null;
        try{
            $countCodesc = Codesc::where('id', $request->id)->count();
            if($countCodesc > 0){
                $codesc = Codesc::where('id', $request->id)->get();
                $result = array("responseCode" => 200, "message" => "success", "data" => $codesc);
            }
            else{
                $result = array("responseCode" => 417, "message" => "failed", "data" => null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            return response()->json($result);
        }
    }


    //method to get all codescs details by code type id
    public function getCodescByCodeId(Request $request){
        //for response level
        $result = null;
        $codescDetailsByTypeId = null;
        try{
            $codescDetailsByTypeIdCount = Codesc::where('code_type_id', $request->codeTypeId)->count();
            if($codescDetailsByTypeIdCount>0){
                $codescDetailsByTypeId = Codesc::where('code_type_id', $request->codeTypeId)->get();
                $result = array("responseCode" => 200, "message" => "success", "data" => $codescDetailsByTypeId);
            }else{
                $result = array("responseCode" => 417, "message" => "failed", "data" => null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            return response()->json($result);
        }
    }
}
