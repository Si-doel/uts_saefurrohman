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
        Schema::create('stock_ins', function (Blueprint $table) {

            $table->id('id_stock_in');

            $table->unsignedBigInteger('id_produk');

            $table->unsignedBigInteger('id_user');

            $table->unsignedInteger('qty');

            $table->string('satuan', 20);

            $table->unsignedInteger('fraction');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('products')
                ->onDelete('cascade');

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
        Schema::dropIfExists('stock_ins');
    }
};