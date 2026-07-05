<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Menampilkan daftar transaksi penjualan.
     */
    public function index(Request $request): View
    {
        $query = $request->query('q');

        $sales = Sales::with(['product', 'user'])
            ->when($query, function ($builder, $query) {
                $builder->whereHas('product', function ($q) use ($query) {
                    $q->where('nama_produk', 'like', "%{$query}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.sales.index', compact('sales', 'query'));
    }

    /**
     * Menampilkan halaman tambah transaksi penjualan.
     */
    public function create(): View
    {
        $products = Product::orderBy('nama_produk')->get();

        return view('pages.sales.create', compact('products'));
    }

    /**
     * Mengambil informasi produk (AJAX).
     */
    public function getProduct(int $id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'id_produk'   => $product->id_produk,
            'nama_produk' => $product->nama_produk,
            'harga_jual'  => $product->harga_jual,
            'stok'        => $product->stok,
            'satuan'      => $product->satuan,
            'fraction'    => $product->fraction,
        ]);
    }

    /**
     * Menyimpan transaksi penjualan.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $validated = $request->validate([
            'id_produk'  => 'required|exists:products,id_produk',
            'qty'        => 'required|integer|min:1|max:9999',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'id_produk.required' => 'Produk wajib dipilih.',
            'qty.required'       => 'Qty wajib diisi.',
            'qty.min'            => 'Qty minimal 1.',
            'qty.max'            => 'Qty maksimal 9999.',
        ]);

        // Ambil data produk
        $product = Product::findOrFail($validated['id_produk']);

        // Validasi stok sebelum transaksi dimulai
        if ($validated['qty'] > $product->stok) {

            return back()
                ->withInput()
                ->withErrors([
                    'qty' => 'Stok tidak mencukupi. Stok tersedia : ' . $product->stok,
                ]);
        }

        try {

            // Memulai transaksi database
            DB::beginTransaction();

            // Hitung subtotal
            $subtotal = $product->harga_jual * $validated['qty'];

            // Simpan transaksi penjualan
            Sales::create([
                'id_produk'  => $product->id_produk,
                'id_user'    => Auth::id(),
                'qty'        => $validated['qty'],
                'satuan'     => $product->satuan,
                'fraction'   => $product->fraction,
                'harga'      => $product->harga_jual,
                'subtotal'   => $subtotal,
                'keterangan' => $validated['keterangan'],
            ]);

            // Kurangi stok produk
            $product->decrement('stok', $validated['qty']);

            // Simpan seluruh perubahan
            DB::commit();

            return redirect()
                ->route('sales.index')
                ->with('success', 'Transaksi penjualan berhasil disimpan.');

        } catch (\Exception $e) {

            // Batalkan seluruh transaksi jika terjadi error
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan : ' . $e->getMessage());
        }
    }
}