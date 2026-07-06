<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>Laporan Stock In</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        .periode {
            text-align: center;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
        }

        table th {
            background: #eeeeee;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <h2>
        LAPORAN STOCK IN
    </h2>
    <div class="periode">
        Periode :
        {{ \Carbon\Carbon::parse($tanggalAwal)->format('d-m-Y') }}
        s/d
        {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>User</th>
            </tr>
        </thead>

        <tbody>
            @php
                $total = 0;
            @endphp
            @forelse($stockIns as $index => $stockIn)
                @php
                    $total += $stockIn->subtotal;
                @endphp
                <tr>
                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>
                    <td>
                        {{ $stockIn->created_at->format('d-m-Y H:i') }}
                    </td>
                    <td>
                        {{ $stockIn->product->nama_produk }}
                    </td>
                    <td class="text-center">
                        {{ $stockIn->qty }}
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($stockIn->harga, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        Rp {{ number_format($stockIn->subtotal, 0, ',', '.') }}
                    </td>
                    <td>
                        {{ $stockIn->user->name }}
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center">
                        Tidak ada data.
                    </td>
                </tr>
            @endforelse

        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">
                    TOTAL PEMBELIAN
                </th>
                <th class="text-right">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak pada :
        {{ now()->format('d-m-Y H:i') }}
    </div>
</body>

</html>
