<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateC2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c2s', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('typeid');
            $table->integer('cid');
            $table->string('param',45);	
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
        Schema::drop('c2s');
    }
}
