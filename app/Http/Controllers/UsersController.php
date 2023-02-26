<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    /**
     * Add new user
     * @OA\Post(
     *    path="/todo-api/public/api/v1/users",
     *    tags={"Users"},
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *            @OA\Property(
     *                  type="object",
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *            ),
     *            @OA\Property(
     *                      property="email",
     *                      type="string"
     *            ),
     *            @OA\Property(
     *                      property="password",
     *                      type="string"
     *            )
     *
     *          ),
     *          example={
     *              "name":"",
     *              "email":"",
     *              "password":""
     *          }
     *        )
     *      )
     *    ),
     *    @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="responseCode", type="number", example=200),
     *              @OA\Property(property="message", type="string", example="user added successfully"),
     *              @OA\Property(property="data", type="array",
     *              @OA\Items(
     *              @OA\Property(property="name", type="string", example="Joshua A"),
     *              @OA\Property(property="email", type="string", example="joshua@email.com"),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="id", type="number", example=1)
     *            )
     *         )
     *      )
     *     ),
     *    @OA\Response(
     *        response=417,
     *        description="not as expected",
     *        @OA\JsonContent(
     *            @OA\Property(property="responseCode", type="number", example="417"),
     *            @OA\Property(property="message", type="string", example="error message"),
     *            @OA\Property(property="data", type="string", example="stack trace string"),
     *        )
     *    )
     * )
    */

    //method to add new user
    public function addUser(Request $request){
        //for response level
        $result = null;
        $response = null;
        try{
            $user = null;

            if($request->name==""){
                $result=["responseCode"=>417, "message"=>"name can't be emtpy", "data"=> null];
                $response = response($result, 417);
            }else if($request->email==""){
                $result = ["responseCode" => 417, "message" => "email can't be empty", "data" => null];
                $response = response($result, 417);
            }else if ($request->password==""){
                $result = ["responseCode" => 417, "message" => "password cannot be empty", "data"=>null];
                $response = response($result, 417);
            }
            else{
                //check for similar emails
                $countUser = User::where('email',$request->email)->count();

                if($countUser>0){
                    $result = ["responseCode"=>417,"message"=>"email already exists", "data"=>null];
                    $response = response($result, 417);
                }
                else{
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password)
                    ]);
                    $result = ["responseCode" => 200, "message" => "success", "data" => $user];
                    $response = response($result, 200);
                }
            }
            return $response;
        }catch(Exception $exception){
            $result = ["responseCode"=> 417, "message"=> $exception->getMessage(), "data" => $exception->getTraceAsString()];
            $response =  response($result, 417);
            return $response;
        }
    }

    /**
     * Get all users
     * @OA\Get (
     *     path="/todo-api/public/api/v1/users",
     *     tags={"Users"},
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
    *                          @OA\Property(property="name",type="string",example="Joshua A"),
    *                          @OA\Property(property="email",type="string",example="joshua@email.com"),
    *                          @OA\Property(property="password",type="string",example="hasedValue"),
    *                          @OA\Property(property="created_at",type="string",example="2022-12-20T10:50:13.000000Z"),
    *                          @OA\Property(property="updated_at",type="string",example="2022-12-20T10:50:13.000000Z")
     *                         )
     *             )
     *         )
     *     )
     * )
     */
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
