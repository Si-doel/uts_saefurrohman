<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {

            $table->id('id_trans');

            $table->unsignedBigInteger('id_produk');

            $table->unsignedBigInteger('id_user');

            $table->unsignedInteger('qty');

            $table->string('satuan', 20);

            $table->unsignedInteger('fraction');

            $table->unsignedInteger('harga');

            $table->unsignedInteger('subtotal');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('products')
                ->onDelete('restrict');

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};