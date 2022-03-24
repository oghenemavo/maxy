<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckedInByToFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function (Blueprint $table) {
             $table->integer('checked_in_by')->unsigned()->nullable()->index()->after('is_checked_in');
            $table->foreign('checked_in_by')->references('id')->on('users')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('locked_by')->unsigned()->nullable()->index()->after('is_checked_in');
            $table->foreign('locked_by')->references('id')->on('users')
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
        Schema::table('files', function (Blueprint $table) {
            //
        });
    }
}
