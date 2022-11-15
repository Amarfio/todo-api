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

    /**
     * @param array $attributes
     * @return Todo
     */

    public function createTodo(array $attributes){
        $todo = new self();

        $title = $attributes["title"];
        $content = $attributes["content"];
        if($title == ""){
            $todo = 2;
        }
        else if($content == ""){
            $todo = 3;
        }
        else{
            $todo->title = $title;
            $todo->content = $content;
            // $todo->save();
            $todo = $todo->save();
        }

        return $todo;

    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTodo($id){
        $todo = $this->where("id", $id)->first();
        return $todo;
    }

    /**
     * @return Todo[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getsTodo(){
        $todos = $this::all();
        return $todos;
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function updateTodo(int $id, array $attributes){
        $todo = $this->getTodo($id);

        if($todo == null){
            throw new ModelNotFoundException("Can't find todo");
        }

        $todo->title = $attributes["title"];
        $todo->content = $attributes["content"];
        $todo->save();
        return $todo;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteTodo($id){
        $todo = $this->getTodo($id);

        if($todo == null){
            throw new ModelNotFoundException("Todo item not found");
        }

        return $todo->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTodoWithId($id){
        $todo = $this->getTodo($id);

        if($todo == null){
            throw new ModelNotFoundException("Todo item not found");
        }

        return $todo->delete();
    }
}
