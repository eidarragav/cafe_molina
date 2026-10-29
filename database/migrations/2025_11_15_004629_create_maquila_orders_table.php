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

            $table->string("quality_type")->nullable();
            $table->string("toast_type")->nullable();
            $table->string("recieved_kilograms")->nullable();
            $table->string("coffe_type")->nullable();
            $table->string("green_density")->nullable();
            $table->string("green_humidity")->nullable();
            $table->string("tag")->default("no");
            $table->string("peel_stick")->default("no");
            $table->string("printed_label")->default("no");
            $table->string("observations")->nullable();
            $table->string("urgent_order")->default("no");
            $table->string("management_criteria")->nullable()->default("no");
            $table->string("status")->default("received");
            $table->float("net_weight")->default(0);
            $table->string("packaging_type")->nullable();
            $table->integer("packaging_quantity")->default(0);
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
