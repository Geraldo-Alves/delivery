<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->bigIncrements('id_produto');
            $table->integer('id_categoria');
            $table->string('nome');
            $table->timestamps();

            $table->foreign('id_categoria')
                ->references('id_categoria')->on('categoria')
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
        Schema::dropIfExists('produto');
    }
}
