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
        Schema::table('products', function (Blueprint $table) {

            // Hapus kolom harga lama jika project masih baru
            $table->dropColumn('harga');

            $table->unsignedInteger('harga_beli')
                ->default(0)
                ->after('deskripsi');

            $table->unsignedInteger('harga_jual')
                ->default(0)
                ->after('harga_beli');

            $table->unsignedInteger('stok')
                ->default(0)
                ->after('harga_jual');

            $table->unsignedInteger('min_stok')
                ->default(0)
                ->after('stok');

            $table->unsignedInteger('max_stok')
                ->default(0)
                ->after('min_stok');

            $table->string('satuan', 20)
                ->default('PCS')
                ->after('max_stok');

            $table->unsignedInteger('fraction')
                ->default(0)
                ->after('satuan');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn([
                'harga_beli',
                'harga_jual',
                'stok',
                'min_stok',
                'max_stok',
                'satuan',
                'fraction',
            ]);

            $table->unsignedInteger('harga')->default(0);

        });
    }
};