<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::select(
            'id_produk',
            'id_kategori',
            'nama_produk',
            'deskripsi',
            'harga',
            'created_at',
            'updated_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID Produk',
            'ID Kategori',
            'Nama Produk',
            'Deskripsi',
            'Harga',
            'Created At',
            'Updated At'
        ];
    }
}