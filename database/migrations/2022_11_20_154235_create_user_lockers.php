<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_lockers', function (Blueprint $table) {
            $table->integer("locker_id")->unsigned();
            $table->integer("user_id")->unsigned();
            $table->timestampTz("expired_at");

            $table->unique(['user_id', 'locker_id']);
            $table->foreign("locker_id")->references('id')->on('lockers')->onDelete('cascade');
            $table->foreign("user_id")->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_lockers');
    }
};
