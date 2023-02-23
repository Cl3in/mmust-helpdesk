<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')
            ->references('id')
            ->on('departments')
            ->onUpdate('cascade')
            ->onDelete('no action');
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')
            ->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('no action');
            $table->integer('status')->nullable();
            $table->longText('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
