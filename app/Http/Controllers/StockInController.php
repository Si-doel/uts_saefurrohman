<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    /**
     * Menampilkan daftar transaksi stock in.
     */
    public function index(Request $request): View
    {
        $query = $request->query('q');

        $stockIns = StockIn::with(['product', 'user'])
            ->when($query, function ($builder, $query) {
                $builder->whereHas('product', function ($q) use ($query) {
                    $q->where('nama_produk', 'like', "%{$query}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.stock_in.index', compact('stockIns', 'query'));
    }

    /**
     * Menampilkan halaman tambah stock in.
     */
    public function create(): View
    {
        $products = Product::orderBy('nama_produk')->get();

        return view('pages.stock_in.create', compact('products'));
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
            'harga_beli'  => $product->harga_beli,
            'stok'        => $product->stok,
            'satuan'      => $product->satuan,
            'fraction'    => $product->fraction,
        ]);
    }

    /**
     * Menyimpan transaksi stock in.
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

        try {

            // Memulai transaksi database
            DB::beginTransaction();

            // Ambil data produk
            $product = Product::findOrFail($validated['id_produk']);

            // Validasi harga beli
            if ($product->harga_beli <= 0) {

                DB::rollBack();

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Harga beli produk "' . $product->nama_produk .
                            '" masih Rp 0. Silakan update harga beli pada Master Produk terlebih dahulu.'
                    );
            }

            // Hitung subtotal berdasarkan harga beli
            $subtotal = $product->harga_beli * $validated['qty'];

            // Simpan transaksi stock in
            StockIn::create([
                'id_produk'  => $product->id_produk,
                'id_user'    => Auth::id(),
                'qty'        => $validated['qty'],
                'satuan'     => $product->satuan,
                'fraction'   => $product->fraction,
                'harga'      => $product->harga_beli,
                'subtotal'   => $subtotal,
                'keterangan' => $validated['keterangan'],
            ]);

            // Tambahkan stok produk
            $product->increment('stok', $validated['qty']);

            // Simpan transaksi
            DB::commit();

            return redirect()
                ->route('stock_in.index')
                ->with('success', 'Transaksi stock in berhasil disimpan.');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan : ' . $e->getMessage());
        }
    }
}
