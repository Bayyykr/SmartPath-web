<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Category;
use App\Models\EmergencyReport;
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
                "nama_kategori" => "Penjambretan / Pencurian HP",
                "jenis" => "kejahatan",
                "warna_marker" => "#F97316",
            ],
            [
                "nama_kategori" => "Penipuan Online / Scam Digital",
                "jenis" => "kejahatan",
                "warna_marker" => "#6366F1",
            ],
            [
                "nama_kategori" => "Balap Liar / Gangguan Ketertiban",
                "jenis" => "kejahatan",
                "warna_marker" => "#F59E0B",
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
            [
                "user_email" => "nia@geocrime.test",
                "kategori" => "Pencurian Motor (Curanmor)",
                "lokasi" => "Lumajang (Kota)",
                "polsek" => "Polsek Lumajang Kota",
                "judul_laporan" => "Curanmor di parkiran minimarket Veteran",
                "deskripsi" =>
                    "Motor bebek warna merah hilang saat pemilik berbelanja sekitar 15 menit. Area parkir cukup ramai dan pelapor sudah mengecek sekitar lokasi.",
                "latitude" => -8.1328,
                "longitude" => 113.2242,
                "status" => "pending",
                "created_at" => now()->subDays(1)->setTime(20, 15),
            ],
            [
                "user_email" => "yoga@geocrime.test",
                "kategori" => "Penjambretan / Pencurian HP",
                "lokasi" => "Lumajang (Kota)",
                "polsek" => "Polsek Lumajang Kota",
                "judul_laporan" => "Penjambretan HP dekat kawasan alun-alun",
                "deskripsi" =>
                    "Pelapor kehilangan handphone saat berjalan kaki. Pelaku menggunakan sepeda motor dan langsung kabur ke arah jalan utama.",
                "latitude" => -8.134,
                "longitude" => 113.2215,
                "status" => "dikonfirmasi",
                "catatan" =>
                    "Laporan valid. Petugas melakukan penelusuran saksi dan rekaman kamera sekitar.",
                "petugas_email" => "admin.lumajang@geocrime.test",
                "created_at" => now()->subDays(2)->setTime(18, 55),
            ],
            [
                "user_email" => "rina@geocrime.test",
                "kategori" => "Penipuan Online / Scam Digital",
                "lokasi" => "Lumajang (Kota)",
                "polsek" => "Polsek Lumajang Kota",
                "judul_laporan" =>
                    "Penipuan marketplace dengan bukti transfer palsu",
                "deskripsi" =>
                    "Pelapor menerima bukti transfer palsu dari pembeli online. Barang hampir dikirim sebelum pelapor menyadari rekening belum bertambah.",
                "latitude" => -8.1352,
                "longitude" => 113.2237,
                "status" => "pending",
                "created_at" => now()->subDays(3)->setTime(10, 25),
            ],
            [
                "user_email" => "budi@geocrime.test",
                "kategori" => "Balap Liar / Gangguan Ketertiban",
                "lokasi" => "Sukodono",
                "polsek" => "Polsek Sukodono",
                "judul_laporan" =>
                    "Balap liar saat malam minggu di jalur Sukodono",
                "deskripsi" =>
                    "Sekelompok remaja melakukan balap liar dan mengganggu pengguna jalan. Warga meminta patroli rutin saat akhir pekan.",
                "latitude" => -8.1118,
                "longitude" => 113.2329,
                "status" => "dikonfirmasi",
                "catatan" =>
                    "Patroli malam ditingkatkan di titik rawan balap liar.",
                "petugas_email" => "dewi@geocrime.test",
                "created_at" => now()->subDays(4)->setTime(23, 30),
            ],
            [
                "user_email" => "siti@geocrime.test",
                "kategori" => "Kecelakaan Tabrakan",
                "lokasi" => "Pasirian",
                "polsek" => "Polsek Pasirian",
                "judul_laporan" => "Tabrakan motor di jalur padat Pasirian",
                "deskripsi" =>
                    "Dua pengendara motor bertabrakan saat salah satu kendaraan hendak menyalip. Korban mengalami luka ringan dan dibawa ke fasilitas kesehatan terdekat.",
                "latitude" => -8.2152,
                "longitude" => 113.1155,
                "status" => "pending",
                "created_at" => now()->subDays(2)->setTime(7, 45),
            ],
            [
                "user_email" => "maya@geocrime.test",
                "kategori" => "Kecelakaan Beruntun",
                "lokasi" => "Sumbersuko",
                "polsek" => "Polsek Sumbersuko",
                "judul_laporan" =>
                    "Kecelakaan beruntun kecil akibat pengereman mendadak",
                "deskripsi" =>
                    "Tiga kendaraan terlibat kecelakaan ringan saat arus lalu lintas padat. Tidak ada korban jiwa, namun arus sempat tersendat.",
                "latitude" => -8.1631,
                "longitude" => 113.2028,
                "status" => "dikonfirmasi",
                "catatan" =>
                    "Petugas mengatur lalu lintas dan meminta pengendara menjaga jarak aman.",
                "petugas_email" => "admin@geocrime.test",
                "created_at" => now()->subDays(6)->setTime(16, 20),
            ],
            [
                "user_email" => "andi@geocrime.test",
                "kategori" => "Pencurian Motor (Curanmor)",
                "lokasi" => "Sumbersuko",
                "polsek" => "Polsek Sumbersuko",
                "judul_laporan" =>
                    "Percobaan curanmor di halaman kos Sumbersuko",
                "deskripsi" =>
                    "Warga memergoki dua orang mencoba merusak kunci motor di halaman kos. Pelaku kabur setelah diteriaki warga.",
                "latitude" => -8.164,
                "longitude" => 113.2041,
                "status" => "pending",
                "created_at" => now()->subDays(1)->setTime(2, 10),
            ],
            [
                "user_email" => "fitri@geocrime.test",
                "kategori" => "Pemberatan / Penganiayaan",
                "lokasi" => "Yosowilangun",
                "polsek" => "Polsek Yosowilangun",
                "judul_laporan" => "Keributan antar pemuda setelah acara musik",
                "deskripsi" =>
                    "Terjadi keributan antar pemuda setelah acara musik lokal. Warga melerai sebelum kejadian meluas.",
                "latitude" => -8.2055,
                "longitude" => 113.3189,
                "status" => "dikonfirmasi",
                "catatan" =>
                    "Petugas melakukan pendataan saksi dan mediasi awal.",
                "petugas_email" => "fitri@geocrime.test",
                "created_at" => now()->subDays(7)->setTime(22, 40),
            ],
            [
                "user_email" => "eko@geocrime.test",
                "kategori" => "Pencurian Rumah / Toko",
                "lokasi" => "Kunir",
                "polsek" => "Polsek Lumajang Kota",
                "judul_laporan" =>
                    "Gudang toko bangunan kehilangan kabel dan perkakas",
                "deskripsi" =>
                    "Pemilik menemukan beberapa gulung kabel dan perkakas hilang dari gudang belakang. Diduga pelaku masuk melalui pagar samping.",
                "latitude" => -8.2128,
                "longitude" => 113.2668,
                "status" => "pending",
                "created_at" => now()->subDays(2)->setTime(6, 30),
            ],
            [
                "user_email" => "nia@geocrime.test",
                "kategori" => "Pembegalan / Perampokan Jalanan",
                "lokasi" => "Kunir",
                "polsek" => "Polsek Lumajang Kota",
                "judul_laporan" =>
                    "Dugaan pembegalan di ruas Kunir menjelang subuh",
                "deskripsi" =>
                    "Pengendara merasa diikuti dua sepeda motor di ruas sepi. Pelapor berhasil menuju permukiman warga sebelum terjadi kontak langsung.",
                "latitude" => -8.2119,
                "longitude" => 113.2654,
                "status" => "dikonfirmasi",
                "catatan" => "Patroli subuh ditingkatkan di ruas rawan Kunir.",
                "petugas_email" => "admin@geocrime.test",
                "created_at" => now()->subDays(3)->setTime(4, 35),
            ],
            [
                "user_email" => "yoga@geocrime.test",
                "kategori" => "Kecelakaan Lalu Lintas Tunggal",
                "lokasi" => "Candipuro",
                "polsek" => "Polsek Candipuro",
                "judul_laporan" => "Motor tergelincir saat hujan di Candipuro",
                "deskripsi" =>
                    "Pengendara tergelincir di jalan licin saat hujan deras. Warga membantu korban dan menghubungi keluarga.",
                "latitude" => -8.1892,
                "longitude" => 113.0524,
                "status" => "selesai",
                "catatan" =>
                    "Korban sudah ditangani dan kendaraan diamankan keluarga.",
                "petugas_email" => "dewi@geocrime.test",
                "created_at" => now()->subMonth()->setDay(18)->setTime(17, 10),
            ],
            [
                "user_email" => "budi@geocrime.test",
                "kategori" => "Penipuan Online / Scam Digital",
                "lokasi" => "Sukodono",
                "polsek" => "Polsek Sukodono",
                "judul_laporan" =>
                    "Modus link kurir palsu menguras saldo e-wallet",
                "deskripsi" =>
                    "Pelapor membuka tautan yang mengatasnamakan kurir paket. Setelah mengisi data, saldo e-wallet berkurang tanpa transaksi yang diakui.",
                "latitude" => -8.1125,
                "longitude" => 113.2314,
                "status" => "selesai",
                "catatan" =>
                    "Pelapor diarahkan mengamankan akun dan membuat laporan pendukung ke penyedia layanan.",
                "petugas_email" => "admin@geocrime.test",
                "created_at" => now()->subMonth()->setDay(24)->setTime(13, 5),
            ],
            [
                "user_email" => "siti@geocrime.test",
                "kategori" => "Pencurian Motor (Curanmor)",
                "lokasi" => "Pasirian",
                "polsek" => "Polsek Pasirian",
                "judul_laporan" => "Curanmor di parkiran tempat makan Pasirian",
                "deskripsi" =>
                    "Motor matic dilaporkan hilang saat pemilik makan malam. Saksi melihat dua orang mencurigakan di area parkir.",
                "latitude" => -8.2166,
                "longitude" => 113.1148,
                "status" => "selesai",
                "catatan" =>
                    "Laporan masuk arsip penanganan dan koordinasi patroli setempat.",
                "petugas_email" => "fitri@geocrime.test",
                "created_at" => now()->subMonths(2)->setDay(12)->setTime(20, 0),
            ],
            [
                "user_email" => "rina@geocrime.test",
                "kategori" => "Kecelakaan Tabrakan",
                "lokasi" => "Lumajang (Kota)",
                "polsek" => "Polsek Lumajang Kota",
                "judul_laporan" => "Senggolan motor saat jam berangkat sekolah",
                "deskripsi" =>
                    "Dua motor bersenggolan saat arus kendaraan padat. Tidak ada korban berat, namun perlu pengaturan lalu lintas pagi.",
                "latitude" => -8.1319,
                "longitude" => 113.222,
                "status" => "selesai",
                "catatan" =>
                    "Petugas mengimbau pengendara berhati-hati di jam padat sekolah.",
                "petugas_email" => "admin.lumajang@geocrime.test",
                "created_at" => now()->subMonths(3)->setDay(9)->setTime(6, 50),
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

        $emergencySamples = [
            [
                "user_email" => "rina@geocrime.test",
                "polsek" => "Polsek Lumajang Kota",
                "kode_darurat" => "SOS-LMJ-0001",
                "status" => "aktif",
                "latitude" => -8.1342,
                "longitude" => 113.2231,
                "alamat_terdeteksi" => "Area Alun-Alun Lumajang, Jogoyudan",
                "jarak_polsek_km" => 0.8,
                "waktu_sos" => now()->subMinutes(12),
                "waktu_dispatch" => null,
                "waktu_selesai" => null,
                "petugas_penanganan" => null,
                "catatan_petugas" =>
                    "SOS aktif, menunggu dispatch petugas terdekat.",
                "telemetri" => [
                    "battery" => 78,
                    "accuracy_meter" => 18,
                    "device" => "Android",
                ],
            ],
            [
                "user_email" => "budi@geocrime.test",
                "polsek" => "Polsek Sukodono",
                "kode_darurat" => "SOS-LMJ-0002",
                "status" => "dalam_penanganan",
                "latitude" => -8.1129,
                "longitude" => 113.2326,
                "alamat_terdeteksi" => "Jl. Raya Sukodono, dekat SPBU Sukodono",
                "jarak_polsek_km" => 1.4,
                "waktu_sos" => now()->subMinutes(45),
                "waktu_dispatch" => now()->subMinutes(32),
                "waktu_selesai" => null,
                "petugas_penanganan" => "Unit Patroli Sukodono 01",
                "catatan_petugas" =>
                    "Personel telah diberangkatkan menuju titik SOS.",
                "telemetri" => [
                    "battery" => 52,
                    "accuracy_meter" => 24,
                    "device" => "Android",
                ],
            ],
            [
                "user_email" => "siti@geocrime.test",
                "polsek" => "Polsek Pasirian",
                "kode_darurat" => "SOS-LMJ-0003",
                "status" => "selesai",
                "latitude" => -8.2161,
                "longitude" => 113.1161,
                "alamat_terdeteksi" => "Jl. Raya Pasirian, area pertokoan",
                "jarak_polsek_km" => 2.1,
                "waktu_sos" => now()->subDays(1)->setTime(20, 15),
                "waktu_dispatch" => now()->subDays(1)->setTime(20, 25),
                "waktu_selesai" => now()->subDays(1)->setTime(21, 5),
                "petugas_penanganan" => "Unit Reskrim Pasirian",
                "catatan_petugas" =>
                    "Situasi aman. Pelapor sudah didampingi dan diminta membuat laporan lanjutan jika diperlukan.",
                "telemetri" => [
                    "battery" => 64,
                    "accuracy_meter" => 16,
                    "device" => "iOS",
                ],
            ],
            [
                "user_email" => "maya@geocrime.test",
                "polsek" => "Polsek Candipuro",
                "kode_darurat" => "SOS-LMJ-0004",
                "status" => "arsip",
                "latitude" => -8.1887,
                "longitude" => 113.052,
                "alamat_terdeteksi" => "Simpang Candipuro arah Pasirian",
                "jarak_polsek_km" => 1.7,
                "waktu_sos" => now()->subDays(3)->setTime(18, 35),
                "waktu_dispatch" => now()->subDays(3)->setTime(18, 42),
                "waktu_selesai" => now()->subDays(3)->setTime(19, 18),
                "petugas_penanganan" => "Patroli Candipuro 02",
                "catatan_petugas" =>
                    "SOS telah selesai dan masuk arsip riwayat darurat.",
                "telemetri" => [
                    "battery" => 41,
                    "accuracy_meter" => 21,
                    "device" => "Android",
                ],
            ],
        ];

        foreach ($emergencySamples as $sample) {
            $user = User::where("email", $sample["user_email"])->first();
            $polsek = Polsek::where("nama", $sample["polsek"])->first();

            EmergencyReport::updateOrCreate(
                ["kode_darurat" => $sample["kode_darurat"]],
                [
                    "user_id" => $user?->id,
                    "nearest_polsek_id" => $polsek?->id,
                    "status" => $sample["status"],
                    "latitude" => $sample["latitude"],
                    "longitude" => $sample["longitude"],
                    "alamat_terdeteksi" => $sample["alamat_terdeteksi"],
                    "jarak_polsek_km" => $sample["jarak_polsek_km"],
                    "waktu_sos" => $sample["waktu_sos"],
                    "waktu_dispatch" => $sample["waktu_dispatch"],
                    "waktu_selesai" => $sample["waktu_selesai"],
                    "petugas_penanganan" => $sample["petugas_penanganan"],
                    "catatan_petugas" => $sample["catatan_petugas"],
                    "telemetri" => $sample["telemetri"],
                    "created_at" => $sample["waktu_sos"],
                    "updated_at" =>
                        $sample["waktu_selesai"] ??
                        ($sample["waktu_dispatch"] ?? $sample["waktu_sos"]),
                ],
            );
        }
    }
}
