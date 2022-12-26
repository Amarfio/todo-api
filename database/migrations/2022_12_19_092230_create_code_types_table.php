<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_types', function (Blueprint $table) {
            $table->id(); //this is the unique id of the code type element
            $table->char('code', 10)->unique(); //this is another unique character value for the code
            $table->string('description', 100); //this specifies what the code type stands for.
            $table->boolean('isActive')->default(true); //this indicates whether the element is active or not
            $table->timestamps(); //this is essential for audit reasons.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('code_types');
    }
}
