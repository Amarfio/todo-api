<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class TodoController extends Controller
{

    //
    protected $todo;

    public function __construct(Todo $todo){
        $this->todo = $todo;
    }

    /**
     * Create todo
     * @OA\Post(
     *    path="/api/todo/store",
     *    tags={"ToDo"},
     *    @OA\RequestBody(
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(
     *                  type="object",
     *                  @OA\Property(
     *                      property="title",
     *                      type="string"
     *            ),
     *                  @OA\Property(
     *                      property="content",
     *                      type="string"
     *            )
     *          ),
     *          example={
     *              "title":"example title",
     *              "content":"example content"
     *          }
     *        )
     *      )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="success",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="number", example=1),
     *           @OA\Property(property="title", type="string", example="title"),
     *           @OA\Property(property="content", type="string", example="content"),
     *           @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *           @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *        )
     *    ),
     *    @OA\Response(
     *        response=400,
     *        description="invalid",
     *        @OA\JsonContent(
     *            @OA\Property(property="msg", type="string", example="fail"),
     *        )
     *    )
     * )
    */
    //method to create new todo record
    public function store(Request $request){

        $result = null;
        try{
            $todo = $this->todo->createTodo($request->all());
            if($todo==1){
                $result = ["responseCode"=>200,"message"=>"todo record added successfully", "data"=>$todo];
            }
            else if($todo == 2){
                $result = ["responseCode"=>"99","message"=>"title is required", "data"=>$todo];
            }
            else if($todo ==3){
                $result = ["responseCode"=>"99","message"=>"content is required", "data"=>$todo];
            }

            return response()->json($result);
        }catch(Exception $exception){
            $result = ["responseCode"=> 400, "message"=> $exception->getMessage(), "data" => null];
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
     *     tags={"ToDo"},
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
     *                          property="content",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "title":"example title",
     *                     "content":"example content"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="content", type="string", example="content"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *          )
     *      )
     * )
     */

    //method to update todo record by id
    public function update($id, Request $request){

        $result = null;
        try {
            $todo = $this->todo->updateTodo($id, $request->all());
            $result = ["responseCode" => 200, "msg"=>"data found", "data"=>$todo];
            return response()->json($result);
        }
        catch (ModelNotFoundException $exception){
            $result = ["msg"=>$exception->getMessage(), "responseCode" => 404, "data"=>null];
            return response()->json($result);
        }
    }

    // /**
    //  * @param $id
    //  * @return \Illuminate\Http\JsonResponse
    //  */

    /**
     * Get Detail Todo
     * @OA\Get (
     *     path="/api/todo/get/{id}",
     *     tags={"ToDo"},
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
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="content", type="string", example="content"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *         )
     *     )
     * )
     */
    //method to get to do details by id
    public function get(Request $request ){

        //declare the and assign the result as an empty array
        $result = null;
        
        //catch any error that comes up from this code
        try{    
            $todo = $this->todo->getTodoWithId($request->id);
            // return $todo->;
            // if($todo == null){

            //     //assign the empty array content to this
            //     $result = array("responseCode"=> 400, "message"=> "no data found", "data"=> null);
            // }
            // 
            $result = array("responseCode"=>200, "message"=> "data found", "data" => $todo);

            //return the result of the array
            return response()->json($result);

        }catch (ModelNotFoundException $exception){

            //put the catched error into the result array
            $result = array("responseCode"=> 404, "message"=> $exception->getMessage(), "data"=> null);

            //return the result of the array
            return response()->json($result);
        }
    }

    /**
     * Get List Todo
     * @OA\Get (
     *     path="/api/todo/gets",
     *     tags={"ToDo"},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="_id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         example="example title"
     *                     ),
     *                     @OA\Property(
     *                         property="content",
     *                         type="string",
     *                         example="example content"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2021-12-11T09:25:53.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    //method to get all to dos
    public function gets(){
        $todos = $this->todo->getsTodo();

        //throw error if it comes up
        try{
            if(count($todos)> 0){
                $result = array('responseCode'=>200, 'message'=> "data found", 'data'=>$todos);
            }
            else{
                $result = array('responseCode'=>201, 'message'=> "no data found",'data'=>null);
            }

            // return response()->setStatusCode(300)->setContent($result);

            return response()->json($result);
        }catch(Exception $exception){
            //display the error that was thrown
            $result = array('responseCode'=> 400, 'message'=>$exception->getMessage(), 'data'=> null);
        }
    }

    // /**
    //  * @param $id
    //  * @return \Illuminate\Http\JsonResponse
    //  */

    /**
     * Delete Todo
     * @OA\Delete (
     *     path="/api/todo/delete/{id}",
     *     tags={"ToDo"},
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
     *             @OA\Property(property="msg", type="string", example="delete todo success")
     *         )
     *     )
     * )
     */
    //method to delete to do by id
    public function delete($id){

        try{
            $todo = $this->todo->deleteTodo($id);
            return response()->json(["msg"=>"delete todo successful", "result"=>$todo]);
        }catch(ModelNotFoundException $exception){
            return response()->json(["responseCode"=> 404, "message"=>$exception->getMessage(), "data"=>null ]);
        }

    }
}
