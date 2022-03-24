<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('details')->nullable();
            $table->boolean('is_active')->default(TRUE);
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('details')->nullable();
            $table->integer('parent_id')->unsigned()->nullable()->index();
            $table->foreign('parent_id')->references('id')->on('tags')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');
            
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('folders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_id')->unsigned()->nullable()->index();
            $table->foreign('parent_id')->references('id')->on('folders')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->string('colour')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_locked')->default(FALSE);
            

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->foreign('created_by')->references('id')->on('users')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');
            
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('size');
            $table->string('current_version');
            $table->string('type');
            $table->timestamp('last_modified')->nullable();
            $table->text('file_path')->nullable();

            $table->boolean('is_locked')->default(FALSE);
            $table->boolean('is_checked_in')->default(FALSE);
            $table->boolean('inherits_folder_permissions')->default(FALSE);

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->foreign('created_by')->references('id')->on('users')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('folder_id')->unsigned()->nullable()->index();
            $table->foreign('folder_id')->references('id')->on('folders')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('versions', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('file_id')->unsigned()->nullable()->index();
            $table->foreign('file_id')->references('id')->on('files')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->string('version');
            $table->string('size');
            $table->string('type');                    
            $table->text('comments')->nullable();
            $table->text('file_path')->nullable();

            $table->boolean('is_locked')->default(FALSE);
            

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->foreign('created_by')->references('id')->on('users')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');
            
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('file_user', function (Blueprint $table) {
            
            $table->integer('file_id')->unsigned()->nullable()->index();
            $table->foreign('file_id')->references('id')->on('files')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');                                

            $table->boolean('can_read')->default(FALSE);
            $table->boolean('can_write')->default(FALSE);
            $table->boolean('can_download')->default(FALSE);
            $table->boolean('can_share')->default(FALSE);
            $table->boolean('can_lock')->default(FALSE);
            $table->boolean('can_checkin')->default(FALSE);
            $table->boolean('can_force_checkin')->default(FALSE);
            
            
        });


        Schema::create('file_group', function (Blueprint $table) {
            
            $table->integer('file_id')->unsigned()->nullable()->index();
            $table->foreign('file_id')->references('id')->on('files')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('group_id')->unsigned()->nullable()->index();
            $table->foreign('group_id')->references('id')->on('groups')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');                                

            $table->boolean('can_read')->default(FALSE);
            $table->boolean('can_write')->default(FALSE);
            $table->boolean('can_download')->default(FALSE);
            $table->boolean('can_share')->default(FALSE);
            $table->boolean('can_lock')->default(FALSE);
            $table->boolean('can_checkin')->default(FALSE);
            $table->boolean('can_force_checkin')->default(FALSE);
            
            
        });

        Schema::create('folder_user', function (Blueprint $table) {
            
            $table->integer('folder_id')->unsigned()->nullable()->index();
            $table->foreign('folder_id')->references('id')->on('folders')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');                                

            $table->boolean('can_read')->default(FALSE);
            $table->boolean('can_write')->default(FALSE);
            $table->boolean('can_download')->default(FALSE);
            $table->boolean('can_share')->default(FALSE);
            $table->boolean('can_lock')->default(FALSE);
            $table->boolean('can_checkin')->default(FALSE);
            $table->boolean('can_force_checkin')->default(FALSE);
            
            
        });

        Schema::create('folder_group', function (Blueprint $table) {
            
            $table->integer('folder_id')->unsigned()->nullable()->index();
            $table->foreign('folder_id')->references('id')->on('folders')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('group_id')->unsigned()->nullable()->index();
            $table->foreign('group_id')->references('id')->on('groups')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');                                

            $table->boolean('can_read')->default(FALSE);
            $table->boolean('can_write')->default(FALSE);
            $table->boolean('can_download')->default(FALSE);
            $table->boolean('can_share')->default(FALSE);
            $table->boolean('can_lock')->default(FALSE);
            $table->boolean('can_checkin')->default(FALSE);
            $table->boolean('can_force_checkin')->default(FALSE);
            
            
        });


        Schema::create('file_tag', function (Blueprint $table) {
            
            $table->integer('file_id')->unsigned()->nullable()->index();
            $table->foreign('file_id')->references('id')->on('files')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('tag_id')->unsigned()->nullable()->index();
            $table->foreign('tag_id')->references('id')->on('tags')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');                                

            
        });


        Schema::create('folder_tag', function (Blueprint $table) {
            
            $table->integer('folder_id')->unsigned()->nullable()->index();
            $table->foreign('folder_id')->references('id')->on('folders')
                                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('tag_id')->unsigned()->nullable()->index();
            $table->foreign('tag_id')->references('id')->on('tags')
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
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('folder_tag');
        Schema::dropIfExists('folder_user');
        Schema::dropIfExists('folder_group');
        Schema::dropIfExists('file_tag');
        Schema::dropIfExists('file_group');
        Schema::dropIfExists('file_user');
        Schema::dropIfExists('versions');
        Schema::dropIfExists('files');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('folders');
        Schema::dropIfExists('groups');
        
        
        
        
        
        
        
        
        
        

    }
}
