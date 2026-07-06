<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel.
     */
    protected $table = 'categories';

    /**
     * Primary Key.
     */
    protected $primaryKey = 'id_kategori';

    /**
     * Mass Assignment.
     */
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * Relasi ke Product.
     */
    public function products(): HasMany
    {
        return $this->hasMany(
            Product::class,
            'id_kategori',
            'id_kategori'
        );
    }
}