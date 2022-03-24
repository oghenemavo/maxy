<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValueListAndRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('value_lists', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type')->default('LOCAL');
            $table->string('model')->nullable();
            $table->text('connection_details')->nullable();


            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('value_list_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('value_list_id')->unsigned()->nullable()->index();
            $table->foreign('value_list_id')->references('id')->on('value_lists')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->string('name');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('value_lists');
        Schema::dropIfExists('value_list_items');
    }
}
