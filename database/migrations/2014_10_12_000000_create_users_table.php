<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('photo')->default('public/assets/team.png');
            $table->string('title')->nullable();
            $table->string('organization')->nullable();
            $table->boolean('isActivationSent')->default(false);
            $table->boolean('isBlocked')->default(false);
            $table->boolean('sidebarOpen')->default(false);
            $table->string('theme')->default('default');
            $table->nullableTimestamps();

        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('profile_id')->unsigned();
            $table->string('password', 60);
            $table->rememberToken();
            $table->nullableTimestamps();

            $table->foreign('profile_id')->references('id')->on('profiles');
        });

        Schema::create('userServers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->integer('profile_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->nullableTimestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('profile_id')->references('id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('userServers');
        Schema::drop('users');
        Schema::drop('profiles');
    }
}
