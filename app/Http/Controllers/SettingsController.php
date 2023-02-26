<?php

namespace App\Http\Controllers;

use App\Models\Code_type;
use App\Models\Codesc;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Add Code Type
     * @OA\Post(
     *    path="/todo-api/public/api/v1/settings/codetypes",
     *    tags={"Settings|codetype"},
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *            @OA\Property(
     *                  type="object",
     *                  @OA\Property(property="code",type="string"),
     *                  @OA\Property(property="description",type="string")
     *                  ),
     *            example={
     *              "code":"nts",
     *              "description":"not started"
     *          }
     *        )
     *      )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="success",
     *        @OA\JsonContent(
     *           @OA\Property(property="responseCode", type="number", example=200),
     *           @OA\Property(property="message", type="string", example="success"),
     *           @OA\Property(property="data", type="array",
     *           @OA\Items(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="code", type="string", example="tstat"),
     *              @OA\Property(property="description", type="string", example="todo status"),
     *              @OA\Property(property="isActive", type="number", example=1),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *            )
     *           )
     *        )
     *    ),
     *    @OA\Response(
     *        response=417,
     *        description="not as expected",
     *        @OA\JsonContent(
     *            @OA\Property(property="responseCode", type="number", example="417"),
     *            @OA\Property(property="message", type="string", example="error message"),
     *            @OA\Property(property="data", type="string", example="stack trace of the error"),
     *        )
     *    )
     * )
    */

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


    /**
     * Get all code types
     * @OA\Get (
     *     path="/todo-api/public/api/v1/settings/codetypes",
     *     tags={"Settings|codetype"},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *                     @OA\Property(property="responseCode",type="number",example="200"),
     *                     @OA\Property(property="message",type="string",example="success"),
     *                     @OA\Property(property="data",type="array",
     *                         @OA\Items(
     *                         type="object",
    *                          @OA\Property(property="id",type="number",example="1"),
    *                          @OA\Property(property="code",type="string",example="nts"),
    *                          @OA\Property(property="description",type="string",example="not started"),
    *                          @OA\Property(property="isActive",type="number",example=1),
    *                          @OA\Property(property="created_at",type="string",example="2022-12-20T10:50:13.000000Z"),
    *                          @OA\Property(property="updated_at",type="string",example="2022-12-20T10:50:13.000000Z")
     *                         )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *        response=417,
     *        description="not as expected",
     *        @OA\JsonContent(
     *            @OA\Property(property="responseCode", type="number", example="417"),
     *            @OA\Property(property="message", type="string", example="error message"),
     *            @OA\Property(property="data", type="string", example="stack trace of the error"),
     *        )
     *    )
     * )
     */
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
                $result = array("responseCode"=>200, "message"=> "no data found", "data"=> null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            // return response()->json(null, 417);
            return response()->json($result);
        }
    }

    /**
     * Get code type by id
     * @OA\Get (
     *     path="/todo-api/public/api/v1/settings/codetypes/{id}",
     *     tags={"Settings|codetype"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="responseCode", type="number", example=200),
     *              @OA\Property(property="message", type="string", example="success"),
     *              @OA\Property(property="data", type="array",
     *              @OA\Items(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="code", type="string", example="nts"),
     *              @OA\Property(property="description", type="string", example="not started"),
     *              @OA\Property(property="isActive", type="number", example=1),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z")
     *            )
     *         )
     *      )
     *     )
     * )
     */

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

    /**
     * Update code type details by id
     * @OA\Put (
     *     path="/todo-api/public/api/v1/settings/codetypes/{id}",
     *     tags={"Settings|codetype"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="isActive",
     *                          type="number"
     *                      )
     *                 ),
     *                 example={
     *                     "code":"",
     *                     "description":"",
     *
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="responseCode", type="number", example=200),
     *              @OA\Property(property="message", type="string", example="code type details updated"),
     *              @OA\Property(property="data", type="array",
     *              @OA\Items(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="code", type="string", example="tstat"),
     *              @OA\Property(property="description", type="string", example="todo status"),
     *              @OA\Property(property="isActive", type="number", example=1),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z")
     *            )
     *         )
     *      )
     *     )
     * )
     */

    //method to update to the code type using id
    public function updateCodetype(Request $request){
        //for response level
        $result = null;

        try{
            $codetypeCount = Code_type::where(['id'=> $request->id])->count();

            $codetype = null;
            if($codetypeCount==1){
                $codetype = Code_type::where(['id' => $request->id])
                                            ->update(['code'=>$request->code,
                                            'description'=>$request->description,
                                            'isActive'=>$request->isActive])->get();
                $result = array("responseCode"=>200, "message"=> "code type details updated", "data"=> $codetype);
            }else{
                $result = array("responseCode"=>200, "message"=> "code type does not exist", "data"=> null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            // return response()->json(null, 417);
            return response()->json($result);
        }
    }

    /**
     * Add Codesc
     * @OA\Post(
     *    path="/todo-api/public/api/v1/settings/codescs",
     *    tags={"Settings|codesc"},
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *            @OA\Property(
     *                  type="object",
     *                  @OA\Property(property="code_type_id",type="string"),
     *                  @OA\Property(property="code",type="string"),
     *                  @OA\Property(property="description",type="string")
     *                  ),
     *            example={
     *              "code_type_id":1,
     *              "code":"nts",
     *              "description":"not started"
     *          }
     *        )
     *      )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="success",
     *        @OA\JsonContent(
     *           @OA\Property(property="responseCode", type="number", example=200),
     *           @OA\Property(property="message", type="string", example="success"),
     *           @OA\Property(property="data", type="array",
     *           @OA\Items(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="code_type_id", type="number", example=1),
     *              @OA\Property(property="code", type="string", example="nts"),
     *              @OA\Property(property="description", type="string", example="not started"),
     *              @OA\Property(property="isActive", type="number", example=1),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *            )
     *           )
     *        )
     *    ),
     *    @OA\Response(
     *        response=417,
     *        description="not as expected",
     *        @OA\JsonContent(
     *            @OA\Property(property="responseCode", type="number", example="417"),
     *            @OA\Property(property="message", type="string", example="error message"),
     *            @OA\Property(property="data", type="string", example="stack trace of the error"),
     *        )
     *    )
     * )
    */


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

    /**
     * Get all codesc stored
     * @OA\Get (
     *     path="/todo-api/public/api/v1/settings/codescs",
     *     tags={"Settings|codesc"},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *                     @OA\Property(property="responseCode",type="number",example="200"),
     *                     @OA\Property(property="message",type="string",example="success"),
     *                     @OA\Property(property="data",type="array",
     *                         @OA\Items(
     *                         type="object",
    *                          @OA\Property(property="id",type="number",example="1"),
    *                          @OA\Property(property="code_type_id",type="number",example=1),
    *                          @OA\Property(property="code",type="string",example="nts"),
    *                          @OA\Property(property="description",type="string",example="not started"),
    *                          @OA\Property(property="isActive",type="number",example=1),
    *                          @OA\Property(property="created_at",type="string",example="2022-12-20T10:50:13.000000Z"),
    *                          @OA\Property(property="updated_at",type="string",example="2022-12-20T10:50:13.000000Z")
     *                         )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *        response=417,
     *        description="not as expected",
     *        @OA\JsonContent(
     *            @OA\Property(property="responseCode", type="number", example="417"),
     *            @OA\Property(property="message", type="string", example="error message"),
     *            @OA\Property(property="data", type="string", example="stack trace of the error"),
     *        )
     *    )
     * )
     */

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

    /**
     * Get codesc by id
     * @OA\Get (
     *     path="/todo-api/public/api/v1/settings/codescs/{id}",
     *     tags={"Settings|codesc"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="responseCode", type="number", example=200),
     *              @OA\Property(property="message", type="string", example="success"),
     *              @OA\Property(property="data", type="array",
     *              @OA\Items(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="code_type_id", type="number", example=1),
     *              @OA\Property(property="code", type="string", example="nts"),
     *              @OA\Property(property="description", type="string", example="not started"),
     *              @OA\Property(property="isActive", type="number", example=1),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z")
     *            )
     *         )
     *      )
     *     ),
     *     @OA\Response(
     *                  response=417,
     *                  description="success",
     *                  @OA\JsonContent(
     *                          @OA\Property(property="responseCode", type="number", example=417),
     *                          @OA\Property(property="message", type="string", example="error message"),
     *                          @OA\Property(property="data", type="string", example=null)
     *                          )
     *                  )
     * )
     */

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

    /**
     * Update codesc details by id
     * @OA\Put (
     *     path="/todo-api/public/api/v1/settings/codescs/{id}",
     *     tags={"Settings|codesc"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="code_type_id",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="code",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="isActive",
     *                          type="number"
     *                      )
     *                 ),
     *                 example={
     *                     "code_type_id":0,
     *                     "code":"",
     *                     "description":"",
     *                     "isActive":1
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="responseCode", type="number", example=200),
     *              @OA\Property(property="message", type="string", example="codesc details updated"),
     *              @OA\Property(property="data", type="array",
     *              @OA\Items(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="code", type="string", example="NTS"),
     *              @OA\Property(property="description", type="string", example="not started"),
     *              @OA\Property(property="isActive", type="number", example=1),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z")
     *            )
     *         )
     *      )
     *     )
     * )
     */
    //method to update the codesc details
    public function updateCodesc(Request $request){
        //for response level
        $result = null;

        try{
            $codescCount = Codesc::where(['id' => $request->id])->count();
            $codesc = null;
            if($codescCount==1){
                $codesc = Codesc::where(['id' => $request->id])
                                    ->update(['code_type_id'=> $request->code_type_id,
                                    'code'=>$request->code,
                                    'description'=>$request->description,
                                    'isActive'=>$request->isActive])->get();
                $result = array("responseCode"=>200, "message"=> "success", "data"=> $codesc);
            }else{
                $result = array("responseCode"=>417, "message"=> "codesc id does not exist", "data"=> null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => $exception->getMessage(), "data" =>null);
            // return response()->json(null, 417);
            return response()->json($result);
        }
    }


    /**
     * Get all codescs by code type id
     * @OA\Get (
     *     path="/todo-api/public/api/v1/settings/codescs/codetypes/{codeTypeId}",
     *     tags={"Settings|codesc"},
     *     @OA\Parameter(
     *         in="path",
     *         name="codeTypeId",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="responseCode", type="number", example=200),
     *              @OA\Property(property="message", type="string", example="success"),
     *              @OA\Property(property="data", type="array",
     *              @OA\Items(
     *              @OA\Property(property="code_type_id", type="number", example=1),
     *              @OA\Property(property="code", type="string", example="nts"),
     *              @OA\Property(property="description", type="string", example="not started"),
     *              @OA\Property(property="isActive", type="number", example=1),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z")
     *            )
     *         )
     *      )
     *     )
     * )
     */

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
                $result = array("responseCode" => 417, "message" => "code type id invalid", "data" => null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = array("responseCode" => 417, "message" => "failed", "data" => $exception->getMessage());
            return response()->json($result);
        }
    }
}
