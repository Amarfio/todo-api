<?php

namespace App\Http\Controllers;

use App\Models\Todo;
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
        $todo = $this->todo->createTodo($request->all());
        if($todo==1){
            return response()->json(["responseCode"=>"000","message"=>"todo record added successfully", "data"=>$todo]);
        }
        else if($todo == 2){
            return response()->json(["responseCode"=>"99","message"=>"title is required", "data"=>$todo]);
        }
        else if($todo ==3){
            return response()->json(["responseCode"=>"99","message"=>"content is required", "data"=>$todo]);
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

        try {
            $todo = $this->todo->updateTodo($id, $request->all());
            return response()->json($todo);
        }
        catch (ModelNotFoundException $exception){

            return response()->json(["msg"=>$exception->getMessage(), "status" => 404]);
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
    public function get($id){
        $todo = $this->todo->getTodo($id);
        // return $todo;

        if($todo){
            return response()->json($todo);
        }

        return response()->json(["msg"=>"Todo item not found", "status" => 404]);
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
        return response()->json($todos);
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
            return response()->json(["msg"=>$exception->getMessage(), "status"=> 404]);
        }

    }
}
