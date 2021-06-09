<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
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
            $table->string('nombre');
            $table->decimal('precio',8,2);
            $table->integer('stock');
            $table->string('descripcion');
            $table->binary('image');
            $table->timestamps();
        });
    }

    public function down()
    {

        Schema::dropIfExists('products');
    }
}
