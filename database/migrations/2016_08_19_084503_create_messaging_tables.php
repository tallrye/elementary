<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text');
            $table->integer('recipient_id')->unsigned();
            $table->integer('sender_id')->unsigned();
            $table->boolean('isRead')->default(false);
            $table->nullableTimestamps();
            
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('recipient_id')->references('id')->on('users');
        });

        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('sender_id')->unsigned();
            $table->integer('recipient_id')->unsigned();
            $table->nullableTimestamps();

            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('recipient_id')->references('id')->on('users');
        });

        Schema::create('messageNotifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('conversation_id')->unsigned();
            $table->integer('message_id')->unsigned();
            $table->nullableTimestamps();

            $table->foreign('conversation_id')->references('id')->on('conversations');
            $table->foreign('message_id')->references('id')->on('messages');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messageNotifications');
        Schema::drop('conversations');
        Schema::drop('messages');
    }
}
