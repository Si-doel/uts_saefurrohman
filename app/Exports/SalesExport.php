<?php

namespace App\Exports;

use App\Models\Sales;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SalesExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents,
    WithColumnFormatting
{
    protected $tanggalAwal;
    protected $tanggalAkhir;
    protected $totalPenjualan = 0;
    protected $totalTransaksi = 0;

    /**
     * Constructor.
     */
    public function __construct($tanggalAwal, $tanggalAkhir)
    {
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    /**
     * Mengambil data yang akan diexport.
     */
    public function collection(): Collection
    {
        $sales = Sales::with([
            'product',
            'user'
        ])
            ->whereBetween('created_at', [
                $this->tanggalAwal . ' 00:00:00',
                $this->tanggalAkhir . ' 23:59:59',
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $this->totalTransaksi = $sales->count();
        $this->totalPenjualan = $sales->sum('subtotal');

        return $sales->map(function ($sale) {
            return [
                'Tanggal'     => $sale->created_at->format('d-m-Y H:i'),
                'Produk'      => $sale->product->nama_produk,
                'Qty'         => $sale->qty,
                'Satuan'      => $sale->satuan,
                'Harga'       => $sale->harga,
                'Subtotal'    => $sale->subtotal,
                'User'        => $sale->user->name,
                'Keterangan'  => $sale->keterangan,
            ];
        });
    }

    /**
     * Heading tabel.
     */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Produk',
            'Qty',
            'Satuan',
            'Harga',
            'Subtotal',
            'User',
            'Keterangan',
        ];
    }

    /**
     * Format kolom angka.
     */
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    /**
     * Styling Excel.
     */
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                /*
                 * Sisipkan 4 baris di atas header.
                 */
                $sheet->insertNewRowBefore(1, 4);

                /*
                 * Judul.
                 */
                $sheet->mergeCells('A1:H1');
                $sheet->setCellValue('A1', 'LAPORAN PENJUALAN');

                $sheet->mergeCells('A2:H2');
                $sheet->setCellValue(
                    'A2',
                    'Periode : '
                        . date('d-m-Y', strtotime($this->tanggalAwal))
                        . ' s/d '
                        . date('d-m-Y', strtotime($this->tanggalAkhir))
                );

                $sheet->mergeCells('A3:H3');
                $sheet->setCellValue(
                    'A3',
                    'Tanggal Export : '
                        . now()->format('d-m-Y H:i')
                );

                /*
                 * Style Judul.
                 */
                $sheet->getStyle('A1')->getFont()
                    ->setBold(true)
                    ->setSize(16);

                $sheet->getStyle('A1:A3')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                /*
                 * Header.
                 */
                $sheet->getStyle('A5:H5')->getFont()
                    ->setBold(true);

                $sheet->getStyle('A5:H5')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle('A5:H5')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('D9EAD3');

                /*
                 * Freeze Header.
                 */
                $sheet->freezePane('A6');

                /*
                 * Auto Filter.
                 */
                $sheet->setAutoFilter('A5:H5');

                /*
                 * Border.
                 */
                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A5:H{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                /*
                 * Ringkasan.
                 */
                $summaryRow = $lastRow + 2;

                $sheet->setCellValue(
                    "F{$summaryRow}",
                    'TOTAL TRANSAKSI'
                );

                $sheet->setCellValue(
                    "G{$summaryRow}",
                    $this->totalTransaksi
                );

                $sheet->getStyle("G" . ($summaryRow + 1))
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');

                $sheet->setCellValue(
                    "G" . ($summaryRow + 1),
                    $this->totalPenjualan
                );

                $sheet->getStyle(
                    "F{$summaryRow}:G" . ($summaryRow + 1)
                )->getFont()->setBold(true);
            }
        ];
    }
}
