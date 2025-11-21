<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaquilaServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquila_services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("selection")->default('no');
            $table->unsignedBigInteger("service_id");
            $table->foreign("service_id")->references("id")->on("services")->onDelete("cascade");
            $table->unsignedBigInteger("maquila_order_id");
            $table->foreign("maquila_order_id")->references("id")->on("maquila_orders")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maquila_services');
    }
}
