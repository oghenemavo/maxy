<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backups', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->foreign('created_by')->references('id')->on('users')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->string('name');
            $table->string('status');
            $table->string('file');

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
        Schema::dropIfExists('backups');
    }
}
