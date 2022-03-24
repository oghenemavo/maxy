<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });


        Schema::table('folders', function (Blueprint $table) {
            
            $table->integer('workflow_id')->unsigned()->nullable()->index()->after('parent_id');
            $table->foreign('workflow_id')->references('id')->on('workflows')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            


        });


        Schema::create('workflow_user_field', function (Blueprint $table) {
            
            $table->integer('workflow_id')->unsigned()->nullable()->index();
            $table->foreign('workflow_id')->references('id')->on('workflows')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('user_field_id')->unsigned()->nullable()->index();
            $table->foreign('user_field_id')->references('id')->on('user_fields')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');


        });

        Schema::create('workflow_steps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();

            $table->integer('workflow_id')->unsigned()->nullable()->index();
            $table->foreign('workflow_id')->references('id')->on('workflows')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('rank')->default(10);                    


            $table->timestamps();
        });

            Schema::create('workflow_step_notifications', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('workflow_step_id')->unsigned()->nullable()->index();
                $table->foreign('workflow_step_id')->references('id')->on('workflow_steps')
                                    ->onUpdate('CASCADE')->onDelete('CASCADE');

                $table->string('recipient_type');
                $table->integer('recipient_id')->unsigned()->index();
                $table->text('template');

                $table->timestamps();
            });


            Schema::create('workflow_step_conditions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('workflow_step_id')->unsigned()->nullable()->index();
                $table->foreign('workflow_step_id')->references('id')->on('workflow_steps')
                                    ->onUpdate('CASCADE')->onDelete('CASCADE');

                $table->integer('user_field_id')->unsigned()->nullable()->index();
                $table->foreign('user_field_id')->references('id')->on('user_fields')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

                $table->string('mode');
                $table->string('operator');
                $table->string('value')->nullable();
                $table->string('option')->nullable();
                
                $table->timestamps();


            });
 

            Schema::create('workflow_step_assignees', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('workflow_step_id')->unsigned()->nullable()->index();
                $table->foreign('workflow_step_id')->references('id')->on('workflow_steps')
                                    ->onUpdate('CASCADE')->onDelete('CASCADE');

                $table->string('recipient_type');
                $table->integer('recipient_id')->unsigned()->index();
                
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
        Schema::dropIfExists('workflow_step_assignees');
        Schema::dropIfExists('workflow_step_conditions');
        Schema::dropIfExists('workflow_step_notifications');
        Schema::dropIfExists('workflow_steps');
        Schema::dropIfExists('workflow_user_field');

        Schema::table('folders', function (Blueprint $table) {
            
            $table->dropForeign('folders_workflow_id_foreign');
            $table->dropColumn('workflow_id');


        });


        Schema::dropIfExists('workflows');


    }
}
