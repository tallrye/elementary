<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificationTypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->string('icon')->nullable();
            $table->nullableTimestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->text('description')->nullable();
            $table->integer('notificationType_id')->unsigned();
            $table->smallInteger('importance');
            $table->boolean('isRead')->default(false);
            $table->string('action_name')->nullable();
            $table->string('action_link')->nullable();
            $table->nullableTimestamps();

            $table->foreign('notificationType_id')->references('id')->on('notificationTypes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notifications');
        Schema::drop('notificationTypes');
    }
}
