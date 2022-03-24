<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowStepTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_step_triggers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('workflow_step_id')->unsigned()->nullable()->index();
            $table->foreign('workflow_step_id')->references('id')->on('workflow_steps')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('user_field_id')->unsigned()->nullable()->index();
            $table->foreign('user_field_id')->references('id')->on('user_fields')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->string('operator');
            $table->string('value')->nullable();
            $table->string('option')->nullable();

            $table->integer('new_step_id')->unsigned()->nullable()->index();
            $table->foreign('new_step_id')->references('id')->on('workflow_steps')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('rank')->default(10);
            
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
        Schema::dropIfExists('workflow_step_triggers');
    }
}
