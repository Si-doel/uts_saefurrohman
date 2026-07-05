<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sales extends Model
{
    /**
     * Nama tabel.
     */
    protected $table = 'sales';

    /**
     * Primary Key.
     */
    protected $primaryKey = 'id_trans';

    /**
     * Mass Assignment.
     */
    protected $fillable = [
        'id_produk',
        'id_user',
        'qty',
        'satuan',
        'fraction',
        'harga',
        'subtotal',
        'keterangan',
    ];

    /**
     * Relasi ke Product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }

    /**
     * Relasi ke User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
