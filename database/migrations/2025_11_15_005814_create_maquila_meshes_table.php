<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaquilaMeshesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquila_meshes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("maquila_order_id");
            $table->foreign("maquila_order_id")->references("id")->on("maquila_orders")->onDelete("cascade");
            $table->unsignedBigInteger("meshe_id");
            $table->foreign("meshe_id")->references("id")->on("meshes")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maquila_meshes');
    }
}
