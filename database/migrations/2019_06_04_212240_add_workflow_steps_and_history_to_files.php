<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWorkflowStepsAndHistoryToFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->integer('workflow_step_id')->unsigned()->nullable()->index()->after('folder_id');
            $table->foreign('workflow_step_id')->references('id')->on('workflow_steps')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

        });

        Schema::create('file_step_details', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('file_id')->unsigned()->nullable()->index();
            $table->foreign('file_id')->references('id')->on('files')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('workflow_step_id')->unsigned()->nullable()->index();
            $table->foreign('workflow_step_id')->references('id')->on('workflow_steps')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->text('details');
            
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
        Schema::table('files', function (Blueprint $table) {
            $table->dropForeign('files_workflow_step_id_foreign');
            $table->dropColumn('workflow_step_id');
        });

        Schema::dropIfExists('file_step_details');
    }
}
