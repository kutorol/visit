<?php

use App\Models\Product;
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
        Schema::create('user_accesses', function (Blueprint $table) {
            $table->integer("user_id");
            $table->addColumn("string", "type")->default(Product::TYPE_SUBSCRIPTION);
            $table->timestampTz("ended_at");
            $table->timestamps();

            $table->primary(["user_id", "type"]);
            $table->foreign("user_id")->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_accesses');
    }
};
