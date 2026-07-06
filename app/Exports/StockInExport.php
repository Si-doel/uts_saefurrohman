<?php

namespace App\Exports;

use App\Models\StockIn;
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

class StockInExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents,
    WithColumnFormatting
{
    protected $tanggalAwal;
    protected $tanggalAkhir;

    protected $totalStockIn = 0;
    protected $totalNilai = 0;

    /**
     * Constructor.
     */
    public function __construct($tanggalAwal, $tanggalAkhir)
    {
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    /**
     * Mengambil data Stock In.
     */
    public function collection(): Collection
    {
        $stockIns = StockIn::with([
                'product',
                'user'
            ])
            ->whereBetween('created_at', [
                $this->tanggalAwal . ' 00:00:00',
                $this->tanggalAkhir . ' 23:59:59',
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $this->totalStockIn = $stockIns->count();
        $this->totalNilai = $stockIns->sum('subtotal');

        return $stockIns->map(function ($stockIn) {
            return [
                'Tanggal'     => $stockIn->created_at->format('d-m-Y H:i'),
                'Produk'      => $stockIn->product->nama_produk,
                'Qty'         => $stockIn->qty,
                'Satuan'      => $stockIn->satuan,
                'Harga Beli'  => $stockIn->harga,
                'Subtotal'    => $stockIn->subtotal,
                'User'        => $stockIn->user->name,
                'Keterangan'  => $stockIn->keterangan,
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
            'Harga Beli',
            'Subtotal',
            'User',
            'Keterangan',
        ];
    }

    /**
     * Format angka.
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
                 * Sisipkan 4 baris sebelum heading.
                 */
                $sheet->insertNewRowBefore(1, 4);
                /*
                 * Judul.
                 */
                $sheet->mergeCells('A1:H1');
                $sheet->setCellValue('A1', 'LAPORAN STOCK IN');
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
                $sheet->getStyle('A1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(16);

                $sheet->getStyle('A1:A3')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                /*
                 * Header.
                 */
                $sheet->getStyle('A5:H5')
                    ->getFont()
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
                    $this->totalStockIn
                );

                $sheet->setCellValue(
                    "F" . ($summaryRow + 1),
                    'TOTAL NILAI STOCK IN'
                );

                $sheet->setCellValue(
                    "G" . ($summaryRow + 1),
                    $this->totalNilai
                );

                $sheet->getStyle(
                    "F{$summaryRow}:G" . ($summaryRow + 1)
                )->getFont()->setBold(true);

                $sheet->getStyle(
                    "G" . ($summaryRow + 1)
                )->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');

            }

        ];
    }
}