<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id_produk';

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

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Relasi ke Sales.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'id_produk', 'id_produk');
    }
}
