<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('kode_menu', 12); 
            $table->string('nama', 100)->nullable(); 
            $table->char('harga', 11)->nullable(); 
            $table->string('gambar', 100)->nullable(); 
            $table->string('kategori', 100)->nullable(); 
            $table->integer('stok')->default(1); 
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
