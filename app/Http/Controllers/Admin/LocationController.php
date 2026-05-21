<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(Request $request): View
    {
        $items = Location::query()
            ->when($request->search, fn ($query, $search) => $query->where('nama', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.master.lokasi.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.master.lokasi.form', ['item' => new Location()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Location::create($this->validated($request));

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Location $location): View
    {
        return view('admin.master.lokasi.form', ['item' => $location]);
    }

    public function update(Request $request, Location $location): RedirectResponse
    {
        $location->update($this->validated($request));

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);
    }
}
