<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowStepMetadatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_step_metadatas', function (Blueprint $table) {
            $table->integer('workflow_step_id')->unsigned()->nullable()->index();
            $table->foreign('workflow_step_id')->references('id')->on('workflow_steps')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('user_field_id')->unsigned()->nullable()->index();
            $table->foreign('user_field_id')->references('id')->on('user_fields')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflow_step_metadatas');
    }
}
