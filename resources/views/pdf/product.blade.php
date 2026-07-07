<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>Product Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .periode {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            background: #f2f2f2;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        table tbody td {
            border: 1px solid #000;
            padding: 6px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        tfoot th {
            border: 1px solid #000;
            padding: 8px;
            background: #f2f2f2;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 11px;
        }
    </style>

</head>

<body>

    <h2>
        LAPORAN DATA PRODUK
    </h2>

    <div class="periode">

        Tanggal Export :

        {{ now()->format('d-m-Y H:i') }}

    </div>

    <table>

        <thead>

            <tr>

                <th width="5%">No</th>

                <th>Produk</th>

                <th>Kategori</th>

                <th>Harga Beli</th>

                <th>Harga Jual</th>

                <th>Stok</th>

                <th>Min</th>

                <th>Max</th>

                <th>Satuan</th>

            </tr>

        </thead>

        <tbody>

            @php
                $totalStok = 0;
            @endphp

            @forelse($products as $index => $product)

                @php
                    $totalStok += $product->stok;
                @endphp

                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $product->nama_produk }}
                    </td>

                    <td>
                        {{ $product->category->nama_kategori ?? '-' }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($product->harga_beli, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        {{ $product->stok }}
                    </td>

                    <td class="text-center">
                        {{ $product->min_stok }}
                    </td>

                    <td class="text-center">
                        {{ $product->max_stok }}
                    </td>

                    <td class="text-center">
                        {{ $product->satuan }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="9" class="text-center">

                        Tidak ada data.

                    </td>

                </tr>

            @endforelse

        </tbody>

        <tfoot>

            <tr>

                <th colspan="5" class="text-right">

                    TOTAL PRODUK

                </th>

                <th class="text-center">

                    {{ $products->count() }}

                </th>

                <th colspan="2" class="text-right">

                    TOTAL STOK

                </th>

                <th class="text-center">

                    {{ $totalStok }}

                </th>

            </tr>

        </tfoot>

    </table>

    <div class="footer">

        Dicetak pada :

        {{ now()->format('d-m-Y H:i') }}

    </div>

</body>

</html>