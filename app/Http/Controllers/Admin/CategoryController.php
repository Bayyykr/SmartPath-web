<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $tipe = in_array($request->query('tipe'), ['kejahatan', 'kecelakaan'], true) ? $request->query('tipe') : 'kejahatan';
        $items = Category::query()
            ->where('tipe', $tipe)
            ->when($request->search, fn ($query, $search) => $query->where('nama', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.master.kategori.index', compact('items', 'tipe'));
    }

    public function create(Request $request): View
    {
        $tipe = in_array($request->query('tipe'), ['kejahatan', 'kecelakaan'], true) ? $request->query('tipe') : 'kejahatan';

        return view('admin.master.kategori.form', ['item' => new Category(['tipe' => $tipe])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:kejahatan,kecelakaan'],
        ]);

        Category::create($data);

        return redirect()->route('admin.categories.index', ['tipe' => $data['tipe']])->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        return view('admin.master.kategori.form', ['item' => $category]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tipe' => ['required', 'in:kejahatan,kecelakaan'],
        ]);

        $category->update($data);

        return redirect()->route('admin.categories.index', ['tipe' => $data['tipe']])->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $tipe = $category->tipe;
        $category->delete();

        return redirect()->route('admin.categories.index', ['tipe' => $tipe])->with('success', 'Kategori berhasil dihapus.');
    }
}
