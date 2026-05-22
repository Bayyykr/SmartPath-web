<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BeritaController extends Controller
{
    public function index(Request $request): View
    {
        $items = Berita::query()
            ->with(['penulis', 'lokasi'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('judul', 'like', "%{$search}%")
                        ->orWhere('isi_berita', 'like', "%{$search}%")
                        ->orWhereHas('penulis', fn ($query) => $query->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('lokasi', fn ($query) => $query->where('nama_lokasi', 'like', "%{$search}%"));
                });
            })
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $locations = Location::query()->orderBy('nama_lokasi')->get();
        $createItem = new Berita(['status' => 'draft']);

        return view('admin.layanan.berita.index', compact('items', 'locations', 'createItem'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['user_id'] = Auth::id();
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('berita', 'public');
        }

        Berita::create($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, Berita $beritum): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            if ($beritum->foto) {
                Storage::disk('public')->delete($beritum->foto);
            }

            $data['foto'] = $request->file('foto')->store('berita', 'public');
        }

        if (($data['status'] ?? $beritum->status) === 'published' && ! $beritum->published_at) {
            $data['published_at'] = now();
        }

        if (($data['status'] ?? $beritum->status) === 'draft') {
            $data['published_at'] = null;
        }

        $beritum->update($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $beritum): RedirectResponse
    {
        if ($beritum->foto) {
            Storage::disk('public')->delete($beritum->foto);
        }

        $beritum->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function publish(Berita $berita): RedirectResponse
    {
        $berita->update([
            'status' => 'published',
            'published_at' => $berita->published_at ?: now(),
        ]);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dipublikasikan.');
    }

    public function draft(Berita $berita): RedirectResponse
    {
        $berita->update([
            'status' => 'draft',
            'published_at' => null,
        ]);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita dikembalikan ke draft.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'lokasi_id' => ['nullable', 'exists:locations,id'],
            'judul' => ['required', 'string', 'max:255'],
            'isi_berita' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);
    }
}
