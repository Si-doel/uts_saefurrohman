<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Sales;
use App\Models\StockIn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel.
     */
    protected $table = 'products';

    /**
     * Primary Key.
     */
    protected $primaryKey = 'id_produk';

    /**
     * Mass Assignment.
     */
    protected $fillable = [
        'id_kategori',
        'nama_produk',
        'deskripsi',
        'harga_beli',
        'harga_jual',
        'stok',
        'min_stok',
        'max_stok',
        'satuan',
        'fraction',
        'foto',
    ];

    /**
     * Relasi ke Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'id_kategori',
            'id_kategori'
        );
    }

    /**
     * Relasi ke Sales.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(
            Sales::class,
            'id_produk',
            'id_produk'
        );
    }

    /**
     * Relasi ke Stock In.
     */
    public function stockIns(): HasMany
    {
        return $this->hasMany(
            StockIn::class,
            'id_produk',
            'id_produk'
        );
    }
}