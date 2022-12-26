<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo', function (Blueprint $table) {
            $table->id(); //this is a unique id for the tasks in the table
            $table->string('title', 100)->unique();// this is a title description of the task.
            $table->longText('description'); //this gives information about the task.
            $table->char('status', 10);//this indicate whether the task has been not started(nts), in progress(wip) and completed(com).
            $table->dateTime('startdateTime');//this indicates the date and time the task will start.
            $table->dateTime('enddateTime');//this indicates the date and time the task will end.
            $table->timestamps();//for audit which contains updated_at and created_at..
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todo');
    }
}
