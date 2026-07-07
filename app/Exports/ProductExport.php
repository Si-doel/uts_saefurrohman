<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProductExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents,
    WithColumnFormatting
{
    protected $totalProduct = 0;
    protected $totalStock = 0;

    public function collection(): Collection
    {
        $products = Product::with('category')
            ->orderBy('nama_produk')
            ->get();

        $this->totalProduct = $products->count();
        $this->totalStock = $products->sum('stok');

        return $products->map(function ($product) {

            if ($product->stok <= $product->min_stok) {
                $status = 'Critical';
            } elseif ($product->stok >= $product->max_stok) {
                $status = 'Overstock';
            } else {
                $status = 'Normal';
            }

            return [

                'Produk' => $product->nama_produk,

                'Kategori' => $product->category->nama_kategori ?? '-',

                'Harga Beli' => $product->harga_beli,

                'Harga Jual' => $product->harga_jual,

                'Stok' => $product->stok,

                'Minimum' => $product->min_stok,

                'Maximum' => $product->max_stok,

                'Satuan' => $product->satuan,

                'Status' => $status,

            ];
        });
    }

    public function headings(): array
    {
        return [

            'Produk',

            'Kategori',

            'Harga Beli',

            'Harga Jual',

            'Stok',

            'Minimum',

            'Maximum',

            'Satuan',

            'Status',

        ];
    }

    public function columnFormats(): array
    {
        return [

            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                $sheet->insertNewRowBefore(1, 4);

                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', 'LAPORAN DATA PRODUK');

                $sheet->mergeCells('A2:I2');
                $sheet->setCellValue(
                    'A2',
                    'Tanggal Export : ' . now()->format('d-m-Y H:i')
                );

                $sheet->getStyle('A1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(16);

                $sheet->getStyle('A1:A2')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle('A5:I5')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('A5:I5')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle('A5:I5')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('D9EAD3');

                $sheet->freezePane('A6');

                $sheet->setAutoFilter('A5:I5');

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A5:I{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                $summaryRow = $lastRow + 2;

                $sheet->setCellValue("G{$summaryRow}", 'TOTAL PRODUCT');
                $sheet->setCellValue("H{$summaryRow}", $this->totalProduct);

                $sheet->setCellValue("G" . ($summaryRow + 1), 'TOTAL STOCK');
                $sheet->setCellValue("H" . ($summaryRow + 1), $this->totalStock);

                $sheet->getStyle(
                    "G{$summaryRow}:H" . ($summaryRow + 1)
                )->getFont()->setBold(true);
            }

        ];
    }
}