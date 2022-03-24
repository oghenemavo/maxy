<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOptionsToValueListsInUserFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_fields', function (Blueprint $table) {
            
            $table->dropColumn('options');

            $table->integer('value_list_id')->unsigned()->nullable()->index()->after('type');
            $table->foreign('value_list_id')->references('id')->on('value_lists')
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
        Schema::table('user_fields', function (Blueprint $table) {
            
            $table->dropForeign('user_fields_value_list_id_foreign');
            $table->dropColumn('value_list_id');
            $table->text('options')->nullable()->after("type");
        });
    }
}
