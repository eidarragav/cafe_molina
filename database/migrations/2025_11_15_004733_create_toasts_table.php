<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toasts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("own_order_id")->nullable();
            $table->foreign("own_order_id")->references("id")->on("own_orders")->onDelete("cascade");
            $table->unsignedBigInteger("maquila_order_id")->nullable();
            $table->foreign("maquila_order_id")->references("id")->on("maquila_orders")->onDelete("cascade");
            $table->string("start_weight");
            $table->string("decrease");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toasts');
    }
}
