<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodescsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codescs', function (Blueprint $table) {
            $table->id();//this is the codesc's unique id
            $table->integer('code_type_id'); //this is the code type id from the code_types table
            $table->char('code', 10)->unique(); //this is the character code for the codesc element
            $table->string('description', 100); //this is what the codesc element stands for
            $table->boolean('isActive')->default(true); //this is specifies whether the code is active or not
            $table->timestamps(); //this is essential for audit which checks the date it was created and updated.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codescs');
    }
}
