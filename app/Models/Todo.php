<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Mime\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Todo extends Model
{
    use HasFactory;

    protected $table= "todo";

    protected $fillable = ['title', 'description', 'status', 'startdateTime','enddateTime'];

    // /**
    //  * @param array $attributes
    //  * @return Todo
    //  */

    // public function createTodo(array $attributes){
    //     $todo = new self();

    //     $title = $attributes["title"];
    //     $description = $attributes["description"];
    //     $codeStatus = Codesc::where('code', 'nts')->value('code');
    //     $status = $codeStatus;
    //     $startdateTime = $attributes["startdateTime"];
    //     $enddateTime = $attributes["enddateTime"];
    //     if($title == ""){
    //         $todo = null;
    //     }
    //     else if($description == ""){
    //         $todo = null;
    //     }
    //     else if($startdateTime == "" && $enddateTime == ""){
    //         $todo = null;
    //     }
    //     else{
    //         $todo->title = $title;
    //         $todo->description = $description;
    //         $todo->status = $status;
    //         $todo->startdateTime = $startdateTime;
    //         $todo->enddateTime = $enddateTime;
    //         $todo->save();
    //     }

    //     return $todo;

    // }

    // /**
    //  * @param $id
    //  * @return mixed
    //  */
    // public function getTodo($id){
    //     $todo = $this->where("id", $id)->first();
    //     return $todo;
    // }

    // /**
    //  * @return Todo[]|\Illuminate\Database\Eloquent\Collection
    //  */
    // public function getsTodo(){
    //     $todos = $this::all();
    //     return $todos;
    // }

    // /**
    //  * @param int $id
    //  * @param array $attributes
    //  * @return mixed
    //  */
    // public function updateTodo(int $id, array $attributes){
    //     $todo = $this->getTodo($id);

    //     if($todo == null){
    //         throw new ModelNotFoundException("Can't find todo");
    //     }

    //     // $todo->title = $attributes["title"];
    //     $todo->description = $attributes["description"];

    //     $currentTodoStatus = Todo::where('id',$id)->value('status');
    //     // return $currentTodoStatus;
    //     $todo->status = $currentTodoStatus;
    //     $todo->startdateTime = $attributes["startdateTime"];
    //     $todo->enddateTime = $attributes["enddateTime"];
    //     $todo->save();
    //     return $todo;
    // }

    // /**
    //  * @param int $id
    //  * @param array $attributes
    //  * @return mixed
    //  */
    // public function updateTodoStatus(int $id, $status){
    //     $todo = $this->getTodo($id);

    //     if($todo == null){
    //         throw new ModelNotFoundException("Can't find todo");
    //     }

    //     $todo->status = $status;
    //     $todo->save();
    //     return $todo;
    // }

    // /**
    //  * @param $id
    //  * @return mixed
    //  */
    // public function deleteTodo($id){
    //     $todo = $this->getTodo($id);

    //     if($todo == null){
    //         throw new ModelNotFoundException("Todo item not found");
    //     }

    //     return $todo->delete();
    // }

    // /**
    //  * @param $id
    //  * @return mixed
    //  */
    // public function getTodoWithId($id){
    //     $todo = $this->getTodo($id);

    //     if($todo == null){
    //         throw new ModelNotFoundException("Todo item not found");
    //     }

    //     return $todo;
    // }
}
