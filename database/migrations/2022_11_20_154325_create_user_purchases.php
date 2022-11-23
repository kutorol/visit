<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->index();
            $table->integer("product_id");

            $table->timestampTz('created_at')->default(DB::raw('NOW()'));

            $table->foreign("user_id")->references('id')->on('users')->nullOnDelete();
            $table->foreign("product_id")->references('id')->on('products')->nullOnDelete();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_purchases');
    }
};
