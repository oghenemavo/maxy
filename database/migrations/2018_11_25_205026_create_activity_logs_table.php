<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('log_name');
            $table->text('description');
            $table->morphs('actionable'); 
            $table->integer('causer_id')->unsigned()->nullable()->index();
            $table->foreign('causer_id')->references('id')->on('users')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');
            ; 
            $table->string('ip')->nullable(); 
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
        Schema::dropIfExists('activity_logs');
    }
}
