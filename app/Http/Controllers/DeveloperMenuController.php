<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DeveloperMenuController extends Controller
{
    /**
     * Display a listing of menus.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        
        $menus = Menu::with('parent')
            ->leftJoin('menus as parents', 'menus.parent_id', '=', 'parents.id')
            ->select('menus.*')
            ->when($search, function ($builder, $search) {
                $builder->where('menus.name', 'like', "%{$search}%");
            })
            ->orderByRaw('COALESCE(parents.order, menus.order) ASC')
            ->orderByRaw('COALESCE(menus.parent_id, menus.id) ASC')
            ->orderByRaw('CASE WHEN menus.parent_id IS NULL THEN 0 ELSE 1 END ASC')
            ->orderBy('menus.order', 'ASC')
            ->paginate(15)
            ->withQueryString();

        return view('developer.menus.index', compact('menus', 'search'));
    }

    /**
     * Show the form for creating a new menu.
     */
    public function create(): View
    {
        $parentMenus = Menu::whereNull('parent_id')->orderBy('order')->get();
        return view('developer.menus.create', compact('parentMenus'));
    }

    /**
     * Store a newly created menu in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'route' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:merchant,developer'],
            'order' => ['required', 'integer', 'min:0'],
            'parent_id' => ['nullable', 'exists:menus,id'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        Menu::create($validated);

        return redirect()->route('developer.menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified menu.
     */
    public function edit(Menu $menu): View
    {
        $parentMenus = Menu::whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->orderBy('order')
            ->get();
        
        return view('developer.menus.edit', compact('menu', 'parentMenus'));
    }

    /**
     * Update the specified menu in storage.
     */
    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'route' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:merchant,developer'],
            'order' => ['required', 'integer', 'min:0'],
            'parent_id' => ['nullable', 'exists:menus,id'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $menu->update($validated);

        return redirect()->route('developer.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified menu from storage.
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete();

        return redirect()->route('developer.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }

    /**
     * Toggle the active status of the menu.
     */
    public function toggle(Menu $menu): RedirectResponse
    {
        $menu->update(['is_active' => !$menu->is_active]);

        return redirect()->back()
            ->with('success', 'Status menu berhasil diubah.');
    }
}
