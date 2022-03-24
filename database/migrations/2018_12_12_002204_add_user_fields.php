<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_fields', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('title');
            $table->string('type')->index();
            $table->text('options')->nullable();

            $table->timestamps();

        });


         Schema::create('folder_user_field', function (Blueprint $table) {
            
            $table->integer('folder_id')->unsigned()->nullable()->index();
            $table->foreign('folder_id')->references('id')->on('folders')
                                    ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('user_field_id')->unsigned()->nullable()->index();
            $table->foreign('user_field_id')->references('id')->on('user_fields')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');
            
            
        });


         Schema::create('file_user_field', function (Blueprint $table) {
            
            $table->integer('file_id')->unsigned()->nullable()->index();
            $table->foreign('file_id')->references('id')->on('files')
                                    ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('user_field_id')->unsigned()->nullable()->index();
            $table->foreign('user_field_id')->references('id')->on('user_fields')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->text('value');
            
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
        Schema::dropIfExists('file_user_field');
        Schema::dropIfExists('folder_user_field');
        Schema::dropIfExists('user_fields');
    }
}
