<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_files', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('file_id')->unsigned()->nullable()->index();
            $table->foreign('file_id')->references('id')->on('files')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->text('name');
            $table->string('size');
            $table->string('type');                    
            $table->text('file_path')->nullable();

            $table->boolean('is_locked')->default(FALSE);
            

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->foreign('created_by')->references('id')->on('users')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('other_files');
    }
}
