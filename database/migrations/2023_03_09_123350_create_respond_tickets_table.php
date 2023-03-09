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
        Schema::create('respond_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id')->unsigned();
            $table->foreign('ticket_id')
            ->references('ticket_id')
            ->on('manage_tickets')
            ->onUpdate('cascade')
            ->onDelete('no action');
            $table->integer('technician_id')->unsigned();
            $table->foreign('technician_id')
            ->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('no action');
            $table->longText('response')->nullable();
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
        Schema::dropIfExists('respond_tickets');
    }
};
