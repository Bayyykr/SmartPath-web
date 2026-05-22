<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Category;
use App\Models\KonfirmasiLaporan;
use App\Models\Laporan;
use App\Models\Location;
use App\Models\Polsek;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "Super Admin",
                "username" => "superadmin",
                "email" => "admin@geocrime.test",
                "telepon" => "081234560001",
                "alamat" => "Kantor Polres Lumajang",
                "role" => "admin",
                "aktif" => true,
            ],
            [
                "name" => "Operator CCTV",
                "username" => "operator.cctv",
                "email" => "operator.cctv@geocrime.test",
                "telepon" => "081234560002",
                "alamat" => "Ruang Command Center Lumajang",
                "role" => "operator",
                "aktif" => true,
            ],
            [
                "name" => "Admin Polsek Lumajang",
                "username" => "admin.lumajang",
                "email" => "admin.lumajang@geocrime.test",
                "telepon" => "081234560003",
                "alamat" => "Jl. Alun-Alun Lumajang",
                "role" => "admin",
                "aktif" => true,
            ],
            [
                "name" => "Rina Anggraini",
                "username" => "rina.anggraini",
                "email" => "rina@geocrime.test",
                "telepon" => "081234560004",
                "alamat" => "Kecamatan Sukodono",
                "role" => "user",
                "aktif" => true,
            ],
            [
                "name" => "Budi Santoso",
                "username" => "budi.santoso",
                "email" => "budi@geocrime.test",
                "telepon" => "081234560005",
                "alamat" => "Kecamatan Sumbersuko",
                "role" => "user",
                "aktif" => true,
            ],
            [
                "name" => "Dewi Lestari",
                "username" => "dewi.lestari",
                "email" => "dewi@geocrime.test",
                "telepon" => "081234560006",
                "alamat" => "Kecamatan Tekung",
                "role" => "operator",
                "aktif" => true,
            ],
            [
                "name" => "Agus Prasetyo",
                "username" => "agus.prasetyo",
                "email" => "agus@geocrime.test",
                "telepon" => "081234560007",
                "alamat" => "Kecamatan Senduro",
                "role" => "user",
                "aktif" => false,
            ],
            [
                "name" => "Siti Aminah",
                "username" => "siti.aminah",
                "email" => "siti@geocrime.test",
                "telepon" => "081234560008",
                "alamat" => "Kecamatan Pasirian",
                "role" => "user",
                "aktif" => true,
            ],
            [
                "name" => "Eko Wahyudi",
                "username" => "eko.wahyudi",
                "email" => "eko@geocrime.test",
                "telepon" => "081234560009",
                "alamat" => "Kecamatan Klakah",
                "role" => "operator",
                "aktif" => true,
            ],
            [
                "name" => "Maya Putri",
                "username" => "maya.putri",
                "email" => "maya@geocrime.test",
                "telepon" => "081234560010",
                "alamat" => "Kecamatan Candipuro",
                "role" => "user",
                "aktif" => true,
            ],
            [
                "name" => "Andi Saputra",
                "username" => "andi.saputra",
                "email" => "andi@geocrime.test",
                "telepon" => "081234560011",
                "alamat" => "Kecamatan Yosowilangun",
                "role" => "user",
                "aktif" => true,
            ],
            [
                "name" => "Fitri Handayani",
                "username" => "fitri.handayani",
                "email" => "fitri@geocrime.test",
                "telepon" => "081234560012",
                "alamat" => "Kecamatan Randuagung",
                "role" => "admin",
                "aktif" => true,
            ],
            [
                "name" => "Hendra Wijaya",
                "username" => "hendra.wijaya",
                "email" => "hendra@geocrime.test",
                "telepon" => "081234560013",
                "alamat" => "Kecamatan Jatiroto",
                "role" => "operator",
                "aktif" => false,
            ],
            [
                "name" => "Nia Kurniawati",
                "username" => "nia.kurniawati",
                "email" => "nia@geocrime.test",
                "telepon" => "081234560014",
                "alamat" => "Kecamatan Rowokangkung",
                "role" => "user",
                "aktif" => true,
            ],
            [
                "name" => "Yoga Firmansyah",
                "username" => "yoga.firmansyah",
                "email" => "yoga@geocrime.test",
                "telepon" => "081234560015",
                "alamat" => "Kecamatan Tempursari",
                "role" => "user",
                "aktif" => true,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ["email" => $user["email"]],
                $user + ["password" => Hash::make("password")],
            );
        }

        $polseks = [
            [
                "nama" => "Polsek Lumajang Kota",
                "alamat" => "Jl. Alun-Alun Barat, Lumajang",
                "telepon" => "0334-881001",
            ],
            [
                "nama" => "Polsek Sukodono",
                "alamat" => "Jl. Raya Sukodono, Lumajang",
                "telepon" => "0334-881002",
            ],
            [
                "nama" => "Polsek Sumbersuko",
                "alamat" => "Jl. Raya Sumbersuko, Lumajang",
                "telepon" => "0334-881003",
            ],
            [
                "nama" => "Polsek Tekung",
                "alamat" => "Jl. Raya Tekung, Lumajang",
                "telepon" => "0334-881004",
            ],
            [
                "nama" => "Polsek Senduro",
                "alamat" => "Jl. Raya Senduro, Lumajang",
                "telepon" => "0334-881005",
            ],
            [
                "nama" => "Polsek Pasirian",
                "alamat" => "Jl. Raya Pasirian, Lumajang",
                "telepon" => "0334-881006",
            ],
            [
                "nama" => "Polsek Candipuro",
                "alamat" => "Jl. Raya Candipuro, Lumajang",
                "telepon" => "0334-881007",
            ],
            [
                "nama" => "Polsek Klakah",
                "alamat" => "Jl. Raya Klakah, Lumajang",
                "telepon" => "0334-881008",
            ],
            [
                "nama" => "Polsek Ranuyoso",
                "alamat" => "Jl. Raya Ranuyoso, Lumajang",
                "telepon" => "0334-881009",
            ],
            [
                "nama" => "Polsek Jatiroto",
                "alamat" => "Jl. Raya Jatiroto, Lumajang",
                "telepon" => "0334-881010",
            ],
            [
                "nama" => "Polsek Randuagung",
                "alamat" => "Jl. Raya Randuagung, Lumajang",
                "telepon" => "0334-881011",
            ],
            [
                "nama" => "Polsek Yosowilangun",
                "alamat" => "Jl. Raya Yosowilangun, Lumajang",
                "telepon" => "0334-881012",
            ],
            [
                "nama" => "Polsek Rowokangkung",
                "alamat" => "Jl. Raya Rowokangkung, Lumajang",
                "telepon" => "0334-881013",
            ],
            [
                "nama" => "Polsek Tempursari",
                "alamat" => "Jl. Raya Tempursari, Lumajang",
                "telepon" => "0334-881014",
            ],
            [
                "nama" => "Polsek Pronojiwo",
                "alamat" => "Jl. Raya Pronojiwo, Lumajang",
                "telepon" => "0334-881015",
            ],
        ];

        foreach ($polseks as $polsek) {
            Polsek::updateOrCreate(["nama" => $polsek["nama"]], $polsek);
        }

        $categories = [
            [
                "nama_kategori" => "Pembegalan / Perampokan Jalanan",
                "jenis" => "kejahatan",
                "warna_marker" => "#FF0000",
            ],
            [
                "nama_kategori" => "Pencurian Motor (Curanmor)",
                "jenis" => "kejahatan",
                "warna_marker" => "#E91E63",
            ],
            [
                "nama_kategori" => "Pemberatan / Penganiayaan",
                "jenis" => "kejahatan",
                "warna_marker" => "#9C27B0",
            ],
            [
                "nama_kategori" => "Pencurian Rumah / Toko",
                "jenis" => "kejahatan",
                "warna_marker" => "#FF5722",
            ],
            [
                "nama_kategori" => "Kecelakaan Lalu Lintas Tunggal",
                "jenis" => "kecelakaan",
                "warna_marker" => "#4CAF50",
            ],
            [
                "nama_kategori" => "Kecelakaan Tabrakan",
                "jenis" => "kecelakaan",
                "warna_marker" => "#009688",
            ],
            [
                "nama_kategori" => "Kecelakaan Beruntun",
                "jenis" => "kecelakaan",
                "warna_marker" => "#00BCD4",
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ["nama_kategori" => $category["nama_kategori"]],
                $category,
            );
        }

        $locations = [
            [
                "nama_lokasi" => "Lumajang (Kota)",
                "latitude" => -8.1331,
                "longitude" => 113.2224,
                "status_kerawanan" => "Rawan",
            ],
            [
                "nama_lokasi" => "Sumbersuko",
                "latitude" => -8.1636,
                "longitude" => 113.2031,
                "status_kerawanan" => "Rawan",
            ],
            [
                "nama_lokasi" => "Kunir",
                "latitude" => -8.2125,
                "longitude" => 113.2662,
                "status_kerawanan" => "Sangat Rawan",
            ],
            [
                "nama_lokasi" => "Yosowilangun",
                "latitude" => -8.2044,
                "longitude" => 113.3194,
                "status_kerawanan" => "Rawan",
            ],
            [
                "nama_lokasi" => "Sukodono",
                "latitude" => -8.1122,
                "longitude" => 113.2318,
                "status_kerawanan" => "Aman",
            ],
            [
                "nama_lokasi" => "Pasirian",
                "latitude" => -8.2157,
                "longitude" => 113.1152,
                "status_kerawanan" => "Rawan",
            ],
            [
                "nama_lokasi" => "Candipuro",
                "latitude" => -8.1885,
                "longitude" => 113.0512,
                "status_kerawanan" => "Aman",
            ],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(
                ["nama_lokasi" => $location["nama_lokasi"]],
                $location,
            );
        }

        $polsekLocationMap = [
            "Polsek Lumajang Kota" => "Lumajang (Kota)",
            "Polsek Sumbersuko" => "Sumbersuko",
            "Polsek Sukodono" => "Sukodono",
            "Polsek Pasirian" => "Pasirian",
            "Polsek Candipuro" => "Candipuro",
            "Polsek Yosowilangun" => "Yosowilangun",
        ];

        foreach ($polsekLocationMap as $polsekName => $locationName) {
            $location = Location::where("nama_lokasi", $locationName)->first();

            if ($location) {
                Polsek::where("nama", $polsekName)->update([
                    "lokasi_id" => $location->id,
                ]);
            }
        }

        $laporanSamples = [
            [
                "user_email" => "rina@geocrime.test",
                "kategori" => "Kecelakaan Lalu Lintas Tunggal",
                "lokasi" => "Sukodono",
                "polsek" => "Polsek Sukodono",
                "judul_laporan" => "Kecelakaan motor di jalan raya Sukodono",
                "deskripsi" =>
                    "Pengendara motor tergelincir saat melewati tikungan licin. Korban mengalami luka ringan dan sudah dibantu warga sekitar.",
                "latitude" => -8.1127,
                "longitude" => 113.2321,
                "status" => "pending",
                "created_at" => now()->subDays(1)->setTime(7, 20),
            ],
            [
                "user_email" => "budi@geocrime.test",
                "kategori" => "Pencurian Motor (Curanmor)",
                "lokasi" => "Lumajang (Kota)",
                "polsek" => "Polsek Lumajang Kota",
                "judul_laporan" => "Motor hilang di area parkir pasar",
                "deskripsi" =>
                    "Motor matic warna hitam hilang sekitar pukul 19.30 WIB. Pelapor sudah mengecek area parkir namun kendaraan tidak ditemukan.",
                "latitude" => -8.1336,
                "longitude" => 113.2228,
                "status" => "dikonfirmasi",
                "catatan" =>
                    "Laporan valid, petugas diarahkan mengecek CCTV sekitar pasar.",
                "petugas_email" => "admin@geocrime.test",
                "created_at" => now()->subDays(2)->setTime(19, 45),
            ],
            [
                "user_email" => "siti@geocrime.test",
                "kategori" => "Pembegalan / Perampokan Jalanan",
                "lokasi" => "Pasirian",
                "polsek" => "Polsek Pasirian",
                "judul_laporan" => "Dugaan pembegalan di jalan sepi Pasirian",
                "deskripsi" =>
                    "Ada dua orang mencurigakan menghentikan kendaraan warga di ruas jalan minim penerangan. Warga sekitar diminta lebih waspada.",
                "latitude" => -8.2163,
                "longitude" => 113.1158,
                "status" => "ditolak",
                "catatan" =>
                    "Data belum lengkap dan tidak ada saksi pendukung. Pelapor diminta melengkapi informasi.",
                "petugas_email" => "fitri@geocrime.test",
                "created_at" => now()->subDays(3)->setTime(21, 10),
            ],
            [
                "user_email" => "maya@geocrime.test",
                "kategori" => "Kecelakaan Tabrakan",
                "lokasi" => "Candipuro",
                "polsek" => "Polsek Candipuro",
                "judul_laporan" =>
                    "Tabrakan dua kendaraan dekat simpang Candipuro",
                "deskripsi" =>
                    "Dua kendaraan roda dua bertabrakan di dekat simpang. Arus lalu lintas sempat melambat dan warga membantu mengatur jalan.",
                "latitude" => -8.1889,
                "longitude" => 113.0515,
                "status" => "selesai",
                "catatan" =>
                    "Laporan telah ditangani Polsek Candipuro dan lalu lintas kembali normal.",
                "petugas_email" => "dewi@geocrime.test",
                "created_at" => now()->subDays(4)->setTime(16, 5),
            ],
            [
                "user_email" => "andi@geocrime.test",
                "kategori" => "Pencurian Rumah / Toko",
                "lokasi" => "Yosowilangun",
                "polsek" => "Polsek Yosowilangun",
                "judul_laporan" => "Toko kelontong dibobol dini hari",
                "deskripsi" =>
                    "Pemilik toko menemukan pintu belakang rusak dan beberapa barang hilang. Kejadian diperkirakan terjadi dini hari.",
                "latitude" => -8.2048,
                "longitude" => 113.3198,
                "status" => "pending",
                "created_at" => now()->subDays(5)->setTime(5, 40),
            ],
        ];

        foreach ($laporanSamples as $sample) {
            $user = User::where("email", $sample["user_email"])->first();
            $category = Category::where(
                "nama_kategori",
                $sample["kategori"],
            )->first();
            $location = Location::where(
                "nama_lokasi",
                $sample["lokasi"],
            )->first();
            $polsek = Polsek::where("nama", $sample["polsek"])->first();

            if (!$user || !$category) {
                continue;
            }

            $laporan = Laporan::updateOrCreate(
                ["judul_laporan" => $sample["judul_laporan"]],
                [
                    "user_id" => $user->id,
                    "kategori_id" => $category->id,
                    "lokasi_id" => $location?->id,
                    "polsek_id" => $polsek?->id,
                    "deskripsi" => $sample["deskripsi"],
                    "latitude" => $sample["latitude"],
                    "longitude" => $sample["longitude"],
                    "status" => $sample["status"],
                    "created_at" => $sample["created_at"],
                    "updated_at" => $sample["created_at"],
                ],
            );

            if (
                in_array(
                    $sample["status"],
                    ["dikonfirmasi", "ditolak", "selesai"],
                    true,
                )
            ) {
                $petugas = User::where(
                    "email",
                    $sample["petugas_email"] ?? "admin@geocrime.test",
                )->first();

                KonfirmasiLaporan::updateOrCreate(
                    ["laporan_id" => $laporan->id],
                    [
                        "petugas_id" => $petugas?->id,
                        "status" =>
                            $sample["status"] === "ditolak"
                                ? "ditolak"
                                : "valid",
                        "catatan" => $sample["catatan"] ?? null,
                        "dikonfirmasi_pada" => $sample["created_at"]
                            ->copy()
                            ->addHours(2),
                    ],
                );
            }
        }

        $beritaSamples = [
            [
                "judul" => "Info: Pemeliharaan CCTV Wonorejo",
                "isi_berita" =>
                    "Dinas terkait melakukan pemeliharaan perangkat CCTV di area Wonorejo. Selama proses berlangsung, pemantauan dialihkan ke titik kamera terdekat.",
                "lokasi" => "Lumajang (Kota)",
                "penulis_email" => "admin@geocrime.test",
                "status" => "published",
                "published_at" => now()->subDays(1)->setTime(9, 0),
            ],
            [
                "judul" => "Waspada: Peningkatan Arus Lalu Lintas di Pasirian",
                "isi_berita" =>
                    "Masyarakat diimbau berhati-hati saat melintas di jalur Pasirian karena terjadi peningkatan arus kendaraan pada jam pulang kerja.",
                "lokasi" => "Pasirian",
                "penulis_email" => "fitri@geocrime.test",
                "status" => "published",
                "published_at" => now()->subDays(2)->setTime(15, 30),
            ],
            [
                "judul" => "Imbauan Keamanan Area Parkir Pasar Lumajang",
                "isi_berita" =>
                    "Pengunjung pasar diminta memastikan kendaraan terkunci ganda dan tidak meninggalkan barang berharga di kendaraan.",
                "lokasi" => "Lumajang (Kota)",
                "penulis_email" => "admin.lumajang@geocrime.test",
                "status" => "draft",
                "published_at" => null,
            ],
            [
                "judul" => "Patroli Malam Ditingkatkan di Sumbersuko",
                "isi_berita" =>
                    "Petugas meningkatkan patroli malam di beberapa titik rawan Kecamatan Sumbersuko untuk menjaga keamanan lingkungan.",
                "lokasi" => "Sumbersuko",
                "penulis_email" => "dewi@geocrime.test",
                "status" => "draft",
                "published_at" => null,
            ],
        ];

        foreach ($beritaSamples as $sample) {
            $penulis = User::where("email", $sample["penulis_email"])->first();
            $location = Location::where(
                "nama_lokasi",
                $sample["lokasi"],
            )->first();

            if (!$penulis) {
                continue;
            }

            Berita::updateOrCreate(
                ["judul" => $sample["judul"]],
                [
                    "user_id" => $penulis->id,
                    "lokasi_id" => $location?->id,
                    "isi_berita" => $sample["isi_berita"],
                    "status" => $sample["status"],
                    "published_at" => $sample["published_at"],
                ],
            );
        }
    }
}
