<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cctv;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CctvController extends Controller
{
    public function index(Request $request): View
    {
        $items = Cctv::query()
            ->with('lokasi')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('nama', 'like', "%{$search}%")
                        ->orWhere('keterangan', 'like', "%{$search}%")
                        ->orWhereHas(
                            'lokasi',
                            fn ($query) => $query->where(
                                'nama_lokasi',
                                'like',
                                "%{$search}%",
                            ),
                        );
                });
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $locations = Location::query()->orderBy('nama_lokasi')->get();
        $createItem = new Cctv(['aktif' => true]);

        return view(
            'admin.master.cctv.index',
            compact('items', 'locations', 'createItem'),
        );
    }

    public function create(): View
    {
        return view('admin.master.cctv.form', [
            'item' => new Cctv(['aktif' => true]),
            'locations' => Location::query()->orderBy('nama_lokasi')->get(),
        ]);
    }

    public function show(Cctv $cctv): View
    {
        return view('admin.master.cctv.show', [
            'item' => $cctv->load('lokasi'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Cctv::create($this->validated($request));

        return redirect()
            ->route('admin.cctvs.index')
            ->with('success', 'CCTV berhasil ditambahkan.');
    }

    public function edit(Cctv $cctv): View
    {
        return view('admin.master.cctv.form', [
            'item' => $cctv,
            'locations' => Location::query()->orderBy('nama_lokasi')->get(),
        ]);
    }

    public function update(Request $request, Cctv $cctv): RedirectResponse
    {
        $cctv->update($this->validated($request));

        return redirect()
            ->route('admin.cctvs.index')
            ->with('success', 'CCTV berhasil diperbarui.');
    }

    public function destroy(Cctv $cctv): RedirectResponse
    {
        $cctv->delete();

        return redirect()
            ->route('admin.cctvs.index')
            ->with('success', 'CCTV berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'lokasi_id' => ['nullable', 'exists:locations,id'],
            'nama' => ['required', 'string', 'max:255'],
            'url_stream' => ['nullable', 'url', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
