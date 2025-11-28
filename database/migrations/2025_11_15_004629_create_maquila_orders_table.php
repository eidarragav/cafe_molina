<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaquilaOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquila_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->unsignedBigInteger('costumer_id');
            $table->foreign('costumer_id')->references('id')->on('costumers')->onDelete("cascade");

            $table->string("quality_type");
            $table->string("toast_type");
            $table->string("recieved_kilograms");
            $table->string("coffe_type");
            $table->string("green_density");
            $table->string("green_humidity");
            $table->string("tag");
            $table->string("peel_stick");
            $table->string("printed_label");
            $table->string("observations")->nullable();
            $table->string("urgent_order");
            $table->string("management_criteria")->nullable();
            $table->string("status");
            $table->float("net_weight");
            $table->string("packaging_type");
            $table->integer("packaging_quantity");
            $table->date("departure_date")->nullable();
            $table->date("entry_date")->nullable();
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maquila_orders');
    }
}
