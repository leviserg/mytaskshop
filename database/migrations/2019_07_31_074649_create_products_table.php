<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pname',90);
            $table->integer('price');
            $table->integer('typeid');
            $table->integer('c1param');
            $table->integer('c2param');
            $table->integer('c3param');
            $table->string('img',90);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            /*
            $table->foreign('typeid')->references('id')->on('types')
                ->onUpdate('cascade')->onDelete('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
