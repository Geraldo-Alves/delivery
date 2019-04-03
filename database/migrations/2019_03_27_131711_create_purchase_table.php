<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase', function (Blueprint $table) {
            $table->bigIncrements('id_purchase');
            $table->integer('id_user');
            $table->integer('id_product');
            $table->timestamps();

            $table->foreign('id_user')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('id_product')
                ->references('id_product')->on('product')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase');
    }
}
