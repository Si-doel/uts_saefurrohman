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
            'harga' => 'required|integer|min:0',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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
            'harga' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($product->foto && Storage::disk('public')->exists($product->foto)) {
                Storage::disk('public')->delete($product->foto);
            }
            $validated['foto'] = $request->file('foto')->store('uploads/products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->foto && Storage::disk('public')->exists($product->foto)) {
            Storage::disk('public')->delete($product->foto);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
