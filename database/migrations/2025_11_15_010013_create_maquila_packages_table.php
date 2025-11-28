<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaquilaPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquila_packages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("maquila_order_id");
            $table->foreign("maquila_order_id")->references("id")->on("maquila_orders")->onDelete("cascade");
            //$table->unsignedBigInteger("measure_id");
            //$table->foreign("measure_id")->references("id")->on("measures")->onDelete("cascade");
            $table->unsignedBigInteger("package_id");
            $table->foreign("package_id")->references("id")->on("packages")->onDelete("cascade");
            $table->string("kilograms");
            $table->string("mesh");
            $table->string("presentation");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maquila_packages');
    }
}
