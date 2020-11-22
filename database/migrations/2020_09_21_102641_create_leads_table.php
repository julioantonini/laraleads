<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('team_id')->nullable(true);
            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('cascade')->onDelete('set NULL');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('funnel_id')->default(1)->nullable(true);
            $table->foreign('funnel_id')->references('id')->on('funnels')->onUpdate('cascade')->onDelete('set NULL');
            $table->integer('funnel_order')->default(0);

            $table->string('name')->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('phone')->nullable(true);
            $table->string('comments')->nullable(true);
            $table->string('cpf')->nullable(true);
            $table->string('birthdate')->nullable(true);
            $table->string('income')->nullable(true);

            $table->boolean('status')->default(0);


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
        Schema::dropIfExists('leads');
    }
}
