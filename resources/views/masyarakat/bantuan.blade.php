<x-pwa-layout title="Pusat Bantuan">
    <style>
        .gc-help-page, .gc-help-page * { box-sizing: border-box; }
        .gc-help-page {
            min-height: 100vh;
            max-width: 430px;
            margin: 0 auto;
            background: #f8fafc;
            padding: 28px 24px 32px;
            color: #0f172a;
            font-family: Figtree, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .gc-back { display: inline-flex; align-items: center; gap: 8px; color: #475569; font-size: 11px; font-weight: 800; text-decoration: none; }
        .gc-back svg { width: 14px; height: 14px; }
        .gc-title { margin: 20px 0 0; color: #0f172a; font-size: 24px; font-weight: 800; line-height: 1.1; letter-spacing: -.03em; }
        .gc-subtitle { margin: 6px 0 0; color: #64748b; font-size: 12px; line-height: 1.5; }
        
        .gc-section-title {
            margin: 28px 0 16px;
            color: #0f172a;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: -.01em;
        }

        /* Accordion Styles */
        .gc-accordion {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: all 0.2s ease;
        }
        .gc-accordion-header {
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
            font-weight: 700;
            font-size: 12.5px;
            color: #1e293b;
            gap: 12px;
        }
        .gc-accordion-icon {
            width: 16px;
            height: 16px;
            color: #64748b;
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }
        .gc-accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
            background: #fafafa;
        }
        .gc-accordion-body {
            padding: 16px;
            font-size: 11.5px;
            line-height: 1.6;
            color: #475569;
            border-top: 1px solid #f1f5f9;
        }
        
        /* Active State */
        .gc-accordion.is-open {
            border-color: #cbd5e1;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .gc-accordion.is-open .gc-accordion-icon {
            transform: rotate(180deg);
            color: #253aa8;
        }

        /* Contact Cards */
        .gc-contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 16px;
        }
        .gc-contact-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: all 0.2s;
        }
        .gc-contact-card:hover {
            border-color: #cbd5e1;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .gc-contact-icon {
            font-size: 24px;
            margin-bottom: 8px;
            display: inline-block;
        }
        .gc-contact-label {
            display: block;
            font-weight: 800;
            font-size: 12px;
            color: #1e293b;
        }
        .gc-contact-desc {
            display: block;
            font-size: 10px;
            color: #64748b;
            margin-top: 4px;
        }
    </style>

    <main class="gc-help-page">
        <a href="{{ route('masyarakat.profile') }}" class="gc-back">
            <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="m12.5 15-5-5 5-5" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" /></svg>
            Kembali ke Profil
        </a>

        <h1 class="gc-title">Pusat Bantuan</h1>
        <p class="gc-subtitle">Cari jawaban atas pertanyaan Anda atau hubungi dukungan teknis GeoCrime</p>

        <h2 class="gc-section-title">Pertanyaan Sering Diajukan (FAQ)</h2>
        
        <div class="gc-accordion">
            <div class="gc-accordion-header" onclick="toggleAccordion(this)">
                <span>Bagaimana cara melaporkan tindakan kriminal?</span>
                <svg class="gc-accordion-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m5 7.5 5 5 5-5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="gc-accordion-content">
                <div class="gc-accordion-body">
                    Anda dapat mengetuk tab <strong>Lapor</strong> pada navigasi bawah, mengisi judul laporan, kronologi kejadian, memilih kategori laporan yang relevan, serta melampirkan foto bukti. Tekan tombol Kirim Laporan untuk mengirimkan laporan kepada petugas Polsek terdekat.
                </div>
            </div>
        </div>

        <div class="gc-accordion">
            <div class="gc-accordion-header" onclick="toggleAccordion(this)">
                <span>Apa kegunaan tombol darurat SOS?</span>
                <svg class="gc-accordion-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m5 7.5 5 5 5-5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="gc-accordion-content">
                <div class="gc-accordion-body">
                    Tombol darurat <strong>SOS</strong> digunakan jika Anda berada dalam situasi berbahaya dan membutuhkan pertolongan cepat. Ketika ditekan, sistem akan otomatis mengirimkan koordinat lokasi GPS Anda secara langsung ke petugas Polsek terdekat agar segera ditindaklanjuti.
                </div>
            </div>
        </div>

        <div class="gc-accordion">
            <div class="gc-accordion-header" onclick="toggleAccordion(this)">
                <span>Apakah identitas saya aman saat melapor?</span>
                <svg class="gc-accordion-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m5 7.5 5 5 5-5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="gc-accordion-content">
                <div class="gc-accordion-body">
                    Sangat aman. GeoCrime menjamin kerahasiaan identitas semua pelapor. Data diri Anda hanya digunakan untuk verifikasi internal oleh petugas yang berwenang dan tidak akan disebarluaskan ke publik.
                </div>
            </div>
        </div>

        <div class="gc-accordion">
            <div class="gc-accordion-header" onclick="toggleAccordion(this)">
                <span>Bagaimana cara melihat CCTV sekitar?</span>
                <svg class="gc-accordion-icon" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m5 7.5 5 5 5-5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="gc-accordion-content">
                <div class="gc-accordion-body">
                    Pada halaman Home, terdapat peta interaktif dan daftar CCTV terdekat. Anda dapat menekan salah satu kamera CCTV terdaftar untuk melihat tayangan langsung (*live stream*) kondisi keamanan jalan atau area tersebut.
                </div>
            </div>
        </div>

        <h2 class="gc-section-title">Hubungi Kami</h2>
        
        <div class="gc-contact-grid">
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20GeoCrime,%20saya%20butuh%20bantuan." target="_blank" rel="noopener noreferrer" class="gc-contact-card">
                <span class="gc-contact-icon">💬</span>
                <span class="gc-contact-label">WhatsApp</span>
                <span class="gc-contact-desc">Hubungi Admin Support</span>
            </a>
            
            <a href="mailto:support@geocrime.com?subject=Tanya%20GeoCrime" class="gc-contact-card">
                <span class="gc-contact-icon">✉️</span>
                <span class="gc-contact-label">E-Mail</span>
                <span class="gc-contact-desc">support@geocrime.com</span>
            </a>
        </div>
    </main>

    <script>
        function toggleAccordion(header) {
            const accordion = header.parentElement;
            const content = header.nextElementSibling;
            const isOpen = accordion.classList.contains('is-open');
            
            document.querySelectorAll('.gc-accordion').forEach(acc => {
                if (acc !== accordion) {
                    acc.classList.remove('is-open');
                    acc.querySelector('.gc-accordion-content').style.maxHeight = null;
                }
            });
            
            if (isOpen) {
                accordion.classList.remove('is-open');
                content.style.maxHeight = null;
            } else {
                accordion.classList.add('is-open');
                content.style.maxHeight = content.scrollHeight + "px";
            }
        }
    </script>
</x-pwa-layout>
