<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->default(0);
            $table->integer('activity_id')->index();
            $table->string('name');
            $table->string('code')->default('')->comment('unique participate id');
            $table->string('company');
            $table->string('title');
            $table->string('phone',20);
            $table->integer('status')->comment('0 new, 1 approved, 2 participated');
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
        Schema::drop('participants');
    }
}
