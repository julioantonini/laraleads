<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('team_id')->nullable(true);
            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('cascade')->onDelete('set NULL');
            $table->unsignedBigInteger('privilege_id')->nullable(true);
            $table->foreign('privilege_id')->references('id')->on('privileges')->onUpdate('cascade')->onDelete('set NULL');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('received')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
