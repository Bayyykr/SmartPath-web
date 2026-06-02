<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BeritaResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CctvResource;
use App\Http\Resources\EmergencyReportResource;
use App\Http\Resources\LaporanResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PolsekResource;
use App\Http\Resources\UserResource;
use App\Models\Berita;
use App\Models\Category;
use App\Models\Cctv;
use App\Models\EmergencyReport;
use App\Models\Laporan;
use App\Models\Location;
use App\Models\Polsek;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MasyarakatApiController extends Controller
{
    public function overview(): JsonResponse
    {
        // This data is typically for a landing page, might be simplified for API
        // For API, we might just return a success message or basic info if this page isn't directly consumed by mobile.
        // If mobile needs similar overview data, this needs to be fleshed out.
        return response()->json([
            "message" =>
                "API overview endpoint. Extend with actual data if needed for mobile.",
        ]);
    }

    public function home(): JsonResponse
    {
        $categories = CategoryResource::collection(
            Category::query()->orderBy("nama_kategori")->get(),
        );
        $locations = LocationResource::collection(
            Location::query()
                ->whereNotNull("latitude")
                ->whereNotNull("longitude")
                ->withCount("laporans")
                ->orderByDesc("laporans_count")
                ->limit(12)
                ->get(),
        );
        $cctvs = CctvResource::collection(
            Cctv::query()->with("lokasi")->latest()->limit(6)->get(),
        );

        $mapPoints = Laporan::query()
            ->with("kategori")
            ->whereNotNull("latitude")
            ->whereNotNull("longitude")
            ->where("status", "!=", "ditolak")
            ->latest()
            ->limit(40)
            ->get()
            ->map(
                fn(Laporan $laporan) => [
                    "title" => $laporan->judul_laporan,
                    "type" => $laporan->kategori?->jenis ?? "laporan",
                    "category" =>
                        $laporan->kategori?->nama_kategori ?? "Laporan",
                    "status" => $laporan->status,
                    "lat" => (float) $laporan->latitude,
                    "lng" => (float) $laporan->longitude,
                    "color" => $laporan->kategori?->warna_marker ?: "#3159d4",
                ],
            );

        return response()->json([
            "categories" => $categories,
            "locations" => $locations,
            "cctvs" => $cctvs,
            "map_points" => $mapPoints,
        ]);
    }

    public function cctvs(): JsonResponse
    {
        $cctvs = CctvResource::collection(
            Cctv::query()
                ->with("lokasi")
                ->orderByDesc("aktif")
                ->orderBy("nama")
                ->get(),
        );
        return response()->json($cctvs);
    }

    public function reports(): JsonResponse
    {
        $laporans = LaporanResource::collection(
            Laporan::query()
                ->with("kategori")
                ->where("user_id", Auth::id())
                ->latest()
                ->get(),
        );

        return response()->json($laporans);
    }

    public function reportOptions(): JsonResponse
    {
        $categories = CategoryResource::collection(
            Category::query()->orderBy("nama_kategori")->get(),
        );
        $locations = LocationResource::collection(
            Location::query()->orderBy("nama_lokasi")->get(),
        );

        return response()->json([
            "categories" => $categories,
            "locations" => $locations,
        ]);
    }

    public function storeReport(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "judul_laporan" => ["required", "string", "max:255"],
            "deskripsi" => ["required", "string"],
            "kategori_id" => ["required", "exists:categories,id"],
            "lokasi_id" => ["nullable", "exists:locations,id"],
            "latitude" => ["nullable", "numeric", "between:-90,90"],
            "longitude" => ["nullable", "numeric", "between:-180,180"],
            "foto_kejadian" => ["nullable", "image", "max:2048"],
        ]);

        $filePath = null;
        if ($request->hasFile("foto_kejadian")) {
            $filePath = $request
                ->file("foto_kejadian")
                ->store("laporan", "public");
        }

        $validated["user_id"] = Auth::id();
        $validated["status"] = "pending";
        $validated["foto_kejadian"] = $filePath;

        $laporan = Laporan::create($validated);

        return response()->json(
            [
                "message" => "Laporan berhasil dikirim.",
                "laporan" => new LaporanResource($laporan),
            ],
            201,
        );
    }

    public function sos(): JsonResponse
    {
        $latestEmergency = null;
        $polseks = PolsekResource::collection(
            Polsek::query()->with("lokasi")->get(),
        );

        if (Auth::check()) {
            $latestEmergency = EmergencyReport::query()
                ->where("user_id", Auth::id())
                ->latest("waktu_sos")
                ->first();
            $latestEmergency = $latestEmergency
                ? new EmergencyReportResource($latestEmergency)
                : null;
        }

        return response()->json([
            "latest_emergency" => $latestEmergency,
            "polseks" => $polseks,
        ]);
    }

    public function storeSos(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "latitude" => ["required", "numeric", "between:-90,90"],
            "longitude" => ["required", "numeric", "between:-180,180"],
            "alamat_terdeteksi" => ["nullable", "string", "max:500"],
            "catatan" => ["nullable", "string", "max:1000"],
        ]);

        $nearestPolsekData = $this->nearestPolsek(
            (float) $validated["latitude"],
            (float) $validated["longitude"],
        );

        $emergencyReport = EmergencyReport::create([
            "user_id" => Auth::id(),
            "nearest_polsek_id" => $nearestPolsekData["polsek"]?->id,
            "kode_darurat" =>
                "SOS-" .
                now()->format("ymdHis") .
                "-" .
                Str::upper(Str::random(4)),
            "status" => "aktif",
            "latitude" => $validated["latitude"],
            "longitude" => $validated["longitude"],
            "alamat_terdeteksi" => $validated["alamat_terdeteksi"] ?? null,
            "jarak_polsek_km" => $nearestPolsekData["distance"],
            "waktu_sos" => now(),
            "telemetri" => [
                "catatan_pengguna" => $validated["catatan"] ?? null,
            ],
        ]);

        return response()->json(
            [
                "message" =>
                    "SOS terkirim. Lokasi Anda sudah dicatat untuk ditindaklanjuti petugas.",
                "emergency_report" => new EmergencyReportResource(
                    $emergencyReport,
                ),
            ],
            201,
        );
    }

    public function news(): JsonResponse
    {
        $beritas = BeritaResource::collection(
            Berita::query()
                ->where("status", "published")
                ->latest("published_at")
                ->latest()
                ->get(),
        );

        return response()->json($beritas);
    }

    public function showNews(Berita $berita): JsonResponse
    {
        // Assuming news are always published if accessed via API, or add check
        abort_unless($berita->status === "published", 404);
        return response()->json(new BeritaResource($berita));
    }

    public function profile(): JsonResponse
    {
        $user = Auth::user();
        return response()->json(new UserResource($user));
    }

    // Methods from ProfileController that might be relevant for API
    public function editProfile(): JsonResponse
    {
        $user = Auth::user();
        return response()->json(new UserResource($user)); // Return user data for editing
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            "name" => ["string", "max:255"],
            "email" => [
                "string",
                "email",
                "max:255",
                "unique:users,email," . $user->id,
            ],
            "profile_photo" => ["nullable", "image", "max:2048"],
            // Add other updatable fields here
        ]);

        if ($request->hasFile("profile_photo")) {
            // Handle file upload and storage for profile photo
            // This might require deleting the old photo if it exists
            $validated["profile_photo"] = $request
                ->file("profile_photo")
                ->store("profile_photos", "public");
        }

        $user->update($validated);

        return response()->json([
            "message" => "Profile updated successfully",
            "user" => new UserResource($user),
        ]);
    }

    public function destroyProfile(Request $request): JsonResponse
    {
        $user = Auth::user();
        // Add logic for deleting associated data if necessary
        $user->delete();

        return response()->json(["message" => "Account deleted successfully"]);
    }

    // Helper methods copied from MasyarakatController
    private function nearestPolsek(float $latitude, float $longitude): array
    {
        $nearest = null;
        $distance = null;

        foreach (Polsek::query()->with("lokasi")->get() as $polsek) {
            if (!$polsek->lokasi?->latitude || !$polsek->lokasi?->longitude) {
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

        return ["polsek" => $nearest, "distance" => $distance];
    }

    private function distanceInKm(
        float $lat1,
        float $lng1,
        float $lat2,
        float $lng2,
    ): float {
        $earthRadius = 6371;
        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);

        $a =
            sin($latDelta / 2) ** 2 +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lngDelta / 2) ** 2;

        return round($earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a)), 2);
    }
}
