<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // default to 'id' as primary key
            $table->foreignId('user_id')->constrained('users'); 
            $table->foreignId('menu_id')->constrained('menus'); 
            $table->integer('jumlah');
            $table->decimal('total_harga', 10, 2);
            $table->enum('status', ['pending', 'diproses', 'selesai', 'dibatalkan', 'lunas cash', 'lunas tf'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
