<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Category;
use App\Models\Cctv;
use App\Models\EmergencyReport;
use App\Models\Laporan;
use App\Models\Location;
use App\Models\Polsek;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MasyarakatController extends Controller
{
    public function overview(): View
    {
        return view('masyarakat.overview');
    }

    public function home(): View
    {
        $categories = Category::query()->orderBy('nama_kategori')->get();
        $locations = Location::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->withCount('laporans')
            ->orderByDesc('laporans_count')
            ->limit(12)
            ->get();
        $cctvs = Cctv::query()->with('lokasi')->latest()->limit(6)->get();

        $mapPoints = Laporan::query()
            ->with('kategori')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('status', '!=', 'ditolak')
            ->latest()
            ->limit(40)
            ->get()
            ->map(fn (Laporan $laporan) => [
                'title' => $laporan->judul_laporan,
                'type' => $laporan->kategori?->jenis ?? 'laporan',
                'category' => $laporan->kategori?->nama_kategori ?? 'Laporan',
                'status' => $laporan->status,
                'lat' => (float) $laporan->latitude,
                'lng' => (float) $laporan->longitude,
                'color' => $laporan->kategori?->warna_marker ?: '#3159d4',
            ]);

        return view('masyarakat.home', compact('categories', 'locations', 'cctvs', 'mapPoints'));
    }

    public function cctv(): View
    {
        $cctvs = Cctv::query()->with('lokasi')->orderByDesc('aktif')->orderBy('nama')->get();

        return view('masyarakat.cctv', compact('cctvs'));
    }

    public function laporan(): View
    {
        $laporans = Laporan::query()
            ->with('kategori')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('masyarakat.laporan.index', compact('laporans'));
    }

    public function createLaporan(): View
    {
        $categories = Category::query()->orderBy('nama_kategori')->get();
        $locations = Location::query()->orderBy('nama_lokasi')->get();

        return view('masyarakat.laporan.create', compact('categories', 'locations'));
    }

    public function storeLaporan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul_laporan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kategori_id' => ['required', 'exists:categories,id'],
            'lokasi_id' => ['nullable', 'exists:locations,id'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'foto_kejadian' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto_kejadian')) {
            $validated['foto_kejadian'] = $request->file('foto_kejadian')->store('laporan', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        Laporan::create($validated);

        return redirect()->route('masyarakat.laporan.index')->with('status', 'Laporan berhasil dikirim dan menunggu konfirmasi.');
    }

    public function sos(): View
    {
        $latestEmergency = EmergencyReport::query()
            ->where('user_id', Auth::id())
            ->latest('waktu_sos')
            ->first();
        $polseks = Polsek::query()->with('lokasi')->get();

        return view('masyarakat.sos', compact('latestEmergency', 'polseks'));
    }

    public function storeSos(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'alamat_terdeteksi' => ['nullable', 'string', 'max:500'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $nearestPolsek = $this->nearestPolsek((float) $validated['latitude'], (float) $validated['longitude']);

        EmergencyReport::create([
            'user_id' => Auth::id(),
            'nearest_polsek_id' => $nearestPolsek['polsek']?->id,
            'kode_darurat' => 'SOS-'.now()->format('ymdHis').'-'.Str::upper(Str::random(4)),
            'status' => 'aktif',
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'alamat_terdeteksi' => $validated['alamat_terdeteksi'] ?? null,
            'jarak_polsek_km' => $nearestPolsek['distance'],
            'waktu_sos' => now(),
            'telemetri' => ['catatan_pengguna' => $validated['catatan'] ?? null],
        ]);

        return redirect()->route('masyarakat.sos')->with('status', 'SOS terkirim. Lokasi Anda sudah dicatat untuk ditindaklanjuti petugas.');
    }

    public function berita(): View
    {
        $beritas = Berita::query()
            ->where('status', 'published')
            ->latest('published_at')
            ->latest()
            ->get();

        return view('masyarakat.berita.index', compact('beritas'));
    }

    public function showBerita(Berita $berita): View
    {
        abort_unless($berita->status === 'published', 404);

        return view('masyarakat.berita.show', compact('berita'));
    }

    public function profile(): View
    {
        return view('masyarakat.profile', ['user' => Auth::user()]);
    }

    private function nearestPolsek(float $latitude, float $longitude): array
    {
        $nearest = null;
        $distance = null;

        foreach (Polsek::query()->with('lokasi')->get() as $polsek) {
            if (! $polsek->lokasi?->latitude || ! $polsek->lokasi?->longitude) {
                continue;
            }

            $currentDistance = $this->distanceInKm(
                $latitude,
                $longitude,
                (float) $polsek->lokasi->latitude,
                (float) $polsek->lokasi->longitude,
            );

            if ($distance === null || $currentDistance < $distance) {
                $nearest = $polsek;
                $distance = $currentDistance;
            }
        }

        return ['polsek' => $nearest, 'distance' => $distance];
    }

    private function distanceInKm(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371;
        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);

        $a = sin($latDelta / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lngDelta / 2) ** 2;

        return round($earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a)), 2);
    }
}
