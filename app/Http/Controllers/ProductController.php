<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->query('q');
        $categoryId = $request->query('category');

        $products = Product::with('category')
            ->when($query, function ($builder, $query) {
                $builder->where('nama_produk', 'like', "%{$query}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($query) {
                        $categoryQuery->where('nama_kategori', 'like', "%{$query}%");
                    });
            })
            ->when($categoryId, function ($builder, $categoryId) {
                $builder->where('id_kategori', $categoryId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('nama_kategori')->get();

        return view('pages.products.index', compact('products', 'query', 'categories', 'categoryId'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('nama_kategori')->get();

        return view('pages.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:categories,id_kategori',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',

            'harga_beli' => 'required|integer|min:0|max:999999999',
            'harga_jual' => 'required|integer|min:0|max:999999999|gte:harga_beli',

            'min_stok' => 'required|integer|min:0|max:999999',
            'max_stok' => 'required|integer|min:0|max:999999|gte:min_stok',

            'satuan' => 'required|in:PCS,BOX,CTN,PACK,LUSIN,ROLL',
            'fraction' => 'required|integer|min:1|max:1000',

            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'harga_beli.max' => 'Harga beli maksimal Rp999.999.999.',
            'harga_jual.max' => 'Harga jual maksimal Rp999.999.999.',
            'harga_jual.gte' => 'Harga jual tidak boleh lebih kecil dari harga beli.',

            'stok.max' => 'Stok maksimal 999.999.',
            'min_stok.max' => 'Minimum stok maksimal 999.999.',
            'max_stok.max' => 'Maksimum stok maksimal 999.999.',
            'max_stok.gte' => 'Maksimum stok harus lebih besar atau sama dengan minimum stok.',

            'fraction.min' => 'Fraction minimal 1.',
            'fraction.max' => 'Fraction maksimal 1000.',

            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, jpg, png, gif, atau webp.',
            'foto.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $path = $request->file('foto')->store('uploads/products', 'public');
        $validated['foto'] = $path;

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil disimpan.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('nama_kategori')->get();

        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:categories,id_kategori',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',

            'harga_beli' => 'required|integer|min:0|max:999999999',
            'harga_jual' => 'required|integer|min:0|max:999999999|gte:harga_beli',

            'min_stok' => 'required|integer|min:0|max:999999',
            'max_stok' => 'required|integer|min:0|max:999999|gte:min_stok',

            'satuan' => 'required|in:PCS,BOX,CTN,PACK,LUSIN,ROLL',
            'fraction' => 'required|integer|min:1|max:1000',

            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {

            if ($product->foto && Storage::disk('public')->exists($product->foto)) {
                Storage::disk('public')->delete($product->foto);
            }

            $validated['foto'] = $request->file('foto')
                ->store('uploads/products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Hitung jumlah transaksi
        $totalSales = $product->sales()->count();
        $totalStockIn = $product->stockIns()->count();

        // Jika produk sudah memiliki transaksi
        if ($totalSales > 0 || $totalStockIn > 0) {

            $message = [];

            if ($totalStockIn > 0) {
                $message[] = $totalStockIn . ' Stock In';
            }

            if ($totalSales > 0) {
                $message[] = $totalSales . ' Sales';
            }

            return redirect()
                ->route('products.index')
                ->with(
                    'error',
                    'Produk "' . $product->nama_produk .
                        '" tidak dapat dihapus karena masih memiliki riwayat transaksi (' .
                        implode(', ', $message) .
                        ').'
                );
        }

        // Soft Delete produk
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Produk berhasil dihapus.'
            );
    }
}
