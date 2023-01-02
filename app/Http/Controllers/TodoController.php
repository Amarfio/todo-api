<?php

namespace App\Http\Controllers;

use App\Models\Codesc;
use App\Models\Todo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function PHPUnit\Framework\isEmpty;

class TodoController extends Controller
{

    //
    // protected $todo;

    // public function __construct(Todo $todo){
    //     $this->todo = $todo;
    // }

    /**
     * Create todo
     * @OA\Post(
     *    path="/api/todo/add",
     *    tags={"Todo"},
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *            @OA\Property(
     *                  type="object",
     *                  @OA\Property(
     *                      property="title",
     *                      type="string"
     *            ),
     *            @OA\Property(
     *                      property="description",
     *                      type="string"
     *            ),
     *            @OA\Property(
     *                      property="startdateTime",
     *                      type="datetime"
     *            ),
     *            @OA\Property(
     *                      property="enddateTime",
     *                      type="datetime"
     *            )
     *
     *          ),
     *          example={
     *              "title":"example title",
     *              "description":"example description",
     *              "startdateTime":"2022-12-19T12:06:00.000",
     *              "enddateTime":"2022-12-19T12:36:30.000"
     *          }
     *        )
     *      )
     *    ),
     *    @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="responseCode", type="number", example=200),
     *              @OA\Property(property="message", type="string", example="todo added successfully"),
     *              @OA\Property(property="data", type="array",
     *              @OA\Items(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="example title"),
     *              @OA\Property(property="description", type="string", example="this is an example title"),
     *              @OA\Property(property="startdateTime", type="datetime", example="2021-12-11T09:30:53.000000Z"),
     *              @OA\Property(property="enddateTime", type="datetime", example="2021-12-11T10:30:53.000000Z"),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z")
     *            )
     *         )
     *      )
     *     ),
     *    @OA\Response(
     *        response=417,
     *        description="not as expected",
     *        @OA\JsonContent(
     *            @OA\Property(property="responseCode", type="number", example="417"),
     *            @OA\Property(property="message", type="string", example="failed"),
     *            @OA\Property(property="data", type="string", example="null"),
     *        )
     *    )
     * )
    */
    //method to create new todo record
    public function store(Request $request){

        $result = null;
        try{
            $todo = null;

            if($request->title==""){
                $result=["responseCode"=>417, "message"=>"title can't be emtpy", "data"=> null];
            }else if($request->description==""){
                $result = ["responseCode" => 417, "message" => "description can't be empty", "data" => null];
            }else if ($request->startdateTime=="" || $request->enddateTime==""){
                $result = ["responseCode" => 417, "message" => "start datetime and end datetime cannot be empty", "data"=>null];
            }
            else{

                $countTodo = Todo::where('title',$request->title)->count();

                //get the status a default value of not started
                $defaultStatus=Codesc::where('code', 'nts')->value('code');

                if($countTodo>0){
                    $result = ["responseCode"=>417,"message"=>"title already exists", "data"=>null];
                }
                else{
                    $todo = Todo::create([
                        'title' => $request->title,
                        'description' => $request->description,
                        'status' => $defaultStatus,
                        'startdateTime' => $request->startdateTime,
                        'enddateTime' => $request->enddateTime,

                    ]);
                    $result = ["responseCode" => 200, "message" => "success", "data" => $todo];
                }
            }
            return response()->json($result);
        }catch(Exception $exception){
            $result = ["responseCode"=> 417, "message"=> "failed", "data" => $exception->getMessage()];
            return response()->json($result);
        }

    }

    /**
     * Get List Todo
     * @OA\Get (
     *     path="/api/todo/get-all",
     *     tags={"Todo"},
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
    *                          @OA\Property(property="title",type="string",example="title new"),
    *                          @OA\Property(property="description",type="string",example="this is a new title"),
    *                          @OA\Property(property="startdateTime",type="string",example="2022-12-20T10:50:13.000000Z"),
    *                          @OA\Property(property="enddateTime",type="string",example="2022-12-20T10:50:13.000000Z"),
    *                          @OA\Property(property="created_at",type="string",example="2022-12-20T10:50:13.000000Z"),
    *                          @OA\Property(property="updated_at",type="string",example="2022-12-20T10:50:13.000000Z")
     *                         )
     *             )
     *         )
     *     )
     * )
     */
    //method to get all to dos
    public function getAllTodos(){
        $todos = Todo::all();
        $countTodos = Todo::all()->count();

        //throw error if it comes up
        try{
            if($countTodos > 0){
                $result = array('responseCode'=>200, 'message'=> "success", 'data'=>$todos);
            }
            else{
                $result = array('responseCode'=>417, 'message'=> "failed",'data'=>null);
            }
            return response()->json($result);
        }catch(Exception $exception){
            //display the error that was thrown
            $result = array('responseCode'=> 417, 'message'=>$exception->getMessage(), 'data'=> $exception->getTraceAsString());
        }
    }

     // /**
    //  * @param $id
    //  * @return \Illuminate\Http\JsonResponse
    //  */

    /**
     * Get Detail Todo
     * @OA\Get (
     *     path="/api/todo/{id}",
     *     tags={"Todo"},
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
     *              @OA\Property(property="title", type="string", example="example title"),
     *              @OA\Property(property="description", type="string", example="this is an example title"),
     *              @OA\Property(property="startdateTime", type="datetime", example="2021-12-11T09:30:53.000000Z"),
     *              @OA\Property(property="enddateTime", type="datetime", example="2021-12-11T10:30:53.000000Z"),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z")
     *            )
     *         )
     *      )
     *     )
     * )
     */
    //method to get to do details by id
    public function get(Request $request ){

        //declare the and assign the result as an empty array
        $result = null;

        //catch any error that comes up from this code
        $result = null;
        try {
            // $todo = $this->todo->updateTodoStatus($id, $request->status);
            $countTodo = Todo::where('id', $request->id)->count();
            $todo = null;
            if ($countTodo > 0) {
                $todo = Todo::where('id', $request->id)->get();
                $result = ["responseCode" => 200, "message" => "success", "data" => $todo];
            }else{
                $result = ["responseCode" => 417, "message" => "todo details not found", "data" => null];
            }
            // $result = ["responseCode" => 200, "msg"=>"success", "data"=>$todo];
            return response()->json($result);
        }
        catch (Exception $exception){
            $result = ["responseCode" => 417, "msg"=>$exception->getMessage(), "data"=>null];
            return response()->json($result);
        }
    }

    // /**
    //  * @param $id
    //  * @param Request $request
    //  * @return \Illuminate\Http\JsonResponse
    //  */

    /**
     * Update Todo
     * @OA\Put (
     *     path="/api/todo/update/{id}",
     *     tags={"Todo"},
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
     *                          property="title",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="startdateTime",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="enddateTime",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"example title",
     *                     "description":"example description",
     *                     "startdateTime":"2022-12-19T12:06:00.000",
     *                     "enddateTime":"2022-12-19T12:36:30.000"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="responseCode", type="number", example=200),
     *              @OA\Property(property="message", type="string", example="todo details updated"),
     *              @OA\Property(property="data", type="array",
     *              @OA\Items(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="example title"),
     *              @OA\Property(property="description", type="string", example="this is an example title"),
     *              @OA\Property(property="startdateTime", type="datetime", example="2021-12-11T09:30:53.000000Z"),
     *              @OA\Property(property="enddateTime", type="datetime", example="2021-12-11T10:30:53.000000Z"),
     *              @OA\Property(property="updated_at", type="datetime", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="datetime", example="2021-12-11T09:25:53.000000Z")
     *            )
     *         )
     *      )
     *     )
     * )
     */


    //method to update todo record by id
    public function update(Request $request){

        //for response base
        $result = null;
        try {
            $todo = null;
            $countTodo = Todo::where('id', $request->id)->count();
            if($countTodo>0){
                $saveTodo = Todo::where('id', $request->id)->update([
                        'title' => $request->title,
                        'description' => $request->description,
                        'startdateTime' => $request->startdateTime,
                        'enddateTime' => $request->enddateTime
                    ]);
                // return $saveTodo;
                if($saveTodo == 1){
                    $todo = Todo::where('id', $request->id)->get();
                    $result = ["responseCode"=>200, "message"=> "success", "data"=>$todo];
                }else{
                    $result = ["responseCode"=>417, "message"=>"failed to update todo details", "data"=>null];
                }
            }else{
                $result = ["responseCode"=>417, "message"=> "failed", "data"=>null];
            }
            // $result = ["responseCode" => 200, "msg"=>"success", "data"=>$todo];
            return response()->json($result);
        }
        catch (Exception $exception){
            $result = ["responseCode" => 417, "msg"=>$exception->getMessage(), "data"=>null];
            return response()->json($result);
        }
    }

    //method to update todo status record by id
    public function updateTodoStatus(Request $request){

        $result = null;
        try {
            // $todo = $this->todo->updateTodoStatus($id, $request->status);
            $countTodo = Todo::where('id', $request->id)->count();
            $todo = null;
            if ($countTodo > 0) {
                $savetodo = Todo::where('id', $request->id)->update([
                    'status' => $request->status
                ]);
                if($savetodo == 1){
                    $todo = Todo::where('id', $request->id)->get();
                    $result = ["responseCode" => 200, "message" => "success", "data" => $todo];
                }
                else{
                    $result = ["responseCode" => 417, "message" => "failed to updated todo status", "data" => null];
                }
            }else{
                $result = ["responseCode" => 417, "message" => "todo details not found", "data" => null];
            }
            // $result = ["responseCode" => 200, "msg"=>"success", "data"=>$todo];
            return response()->json($result);
        }
        catch (Exception $exception){
            $result = ["responseCode" => 417, "msg"=>$exception->getMessage(), "data"=>null];
            return response()->json($result);
        }
    }



    // /**
    //  * @param $id
    //  * @return \Illuminate\Http\JsonResponse
    //  */

    // /**
    //  * Delete Todo
    //  * @OA\Delete (
    //  *     path="/api/todo/delete/{id}",
    //  *     tags={"Todo"},
    //  *     @OA\Parameter(
    //  *         in="path",
    //  *         name="id",
    //  *         required=true,
    //  *         @OA\Schema(type="string")
    //  *     ),
    //  *     @OA\Response(
    //  *         response=200,
    //  *         description="success",
    //  *         @OA\JsonContent(
    //  *             @OA\Property(property="msg", type="string", example="delete todo success")
    //  *         )
    //  *     )
    //  * )
    //  */
    // //method to delete to do by id
    // public function delete($id){

    //     try{
    //         $todo = $this->todo->deleteTodo($id);
    //         return response()->json(["msg"=>"delete todo successful", "result"=>$todo]);
    //     }catch(ModelNotFoundException $exception){
    //         return response()->json(["responseCode"=> 404, "message"=>$exception->getMessage(), "data"=>null ]);
    //     }

    // }
}
