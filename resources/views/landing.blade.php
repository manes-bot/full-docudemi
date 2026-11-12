<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocuDemi - Legalisir dan pengambilan ijazah alumni SMKN 5 Surakarta</title>
    <meta name="description" content="Ajukan legalisir ijazah atau transkrip dari rumah, pantau statusnya, dan datang ke sekolah hanya saat dokumen sudah siap diambil.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --forest: #0F3D22;
            --green: #15803D;
            --green-dark: #166534;
            --mint: #DCFCE7;
            --paper: #F6F8F7;
            --white: #FFFFFF;
            --ink: #172B1C;
            --muted: #5B6B60;
            --line: #DCE5DF;
            --stamp: #C8281E;

            --display: 'Bricolage Grotesque', 'Segoe UI', sans-serif;
            --body: 'Figtree', 'Segoe UI', system-ui, sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; -webkit-text-size-adjust: 100%; }
        body { overflow-x: clip; font-family: var(--body); font-size: 17px; line-height: 1.6; color: var(--ink); background: var(--paper); }
        img, video, svg { max-width: 100%; display: block; }
        a { color: inherit; }
        :focus-visible { outline: 3px solid var(--green); outline-offset: 3px; border-radius: 4px; }

        .wrap { width: min(1120px, 100% - 40px); margin-inline: auto; }

        /* Tombol */
        .btn { display: inline-flex; align-items: center; justify-content: center; min-height: 48px; padding: 0 26px; border-radius: 10px; font: 600 16px var(--body); text-decoration: none; border: 2px solid transparent; transition: background .2s, color .2s, border-color .2s; cursor: pointer; }
        .btn-primary { background: var(--green); color: var(--white); }
        .btn-primary:hover { background: var(--green-dark); }
        .btn-ghost { border-color: var(--forest); color: var(--forest); background: transparent; }
        .btn-ghost:hover { background: var(--forest); color: var(--white); }
        .btn-light { background: var(--white); color: var(--forest); }
        .btn-light:hover { background: var(--mint); }

        /* Navigasi */
        .nav { position: sticky; top: 0; z-index: 20; background: rgba(246, 248, 247, .92); backdrop-filter: blur(8px); border-bottom: 1px solid var(--line); }
        .nav .wrap { position: relative; display: flex; align-items: center; justify-content: space-between; height: 68px; }
        .brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .brand-mark { width: 38px; height: 38px; border-radius: 9px; background: var(--green); color: var(--white); display: grid; place-items: center; font: 800 21px var(--display); }
        .brand-name { font: 700 20px var(--display); letter-spacing: -.02em; line-height: 1.1; }
        .brand-name small { display: block; font: 500 12px var(--body); letter-spacing: 0; color: var(--muted); }
        .nav-panel { display: flex; align-items: center; gap: 24px; }
        .nav-links { list-style: none; display: flex; align-items: center; gap: 2px; }
        .nav-links a { display: block; padding: 8px 12px; border-radius: 8px; text-decoration: none; font-weight: 500; font-size: 15px; color: var(--muted); transition: background .2s, color .2s; }
        .nav-links a:hover { color: var(--ink); background: rgba(21, 128, 61, .08); }
        .nav-links a.is-active { color: var(--forest); background: var(--mint); font-weight: 600; }
        .nav-cta { display: flex; gap: 8px; }
        .nav-cta .btn { min-height: 40px; padding: 0 18px; font-size: 15px; }
        .menu-btn { display: none; width: 44px; height: 44px; border: 1px solid var(--line); border-radius: 10px; background: var(--white); color: var(--forest); cursor: pointer; align-items: center; justify-content: center; }
        .menu-btn .bars, .menu-btn .bars::before, .menu-btn .bars::after { display: block; width: 18px; height: 2px; background: currentColor; border-radius: 2px; transition: transform .25s, opacity .2s; }
        .menu-btn .bars { position: relative; }
        .menu-btn .bars::before, .menu-btn .bars::after { content: ""; position: absolute; left: 0; }
        .menu-btn .bars::before { top: -6px; }
        .menu-btn .bars::after { top: 6px; }
        .menu-btn[aria-expanded="true"] .bars { background: transparent; }
        .menu-btn[aria-expanded="true"] .bars::before { transform: translateY(6px) rotate(45deg); }
        .menu-btn[aria-expanded="true"] .bars::after { transform: translateY(-6px) rotate(-45deg); }

        /* Hero */
        .hero { padding: 64px 0 88px; }
        .hero .wrap { display: grid; grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr); gap: 56px; align-items: center; }
        h1 { font: 800 clamp(38px, 5.4vw, 62px)/1.04 var(--display); letter-spacing: -.035em; color: var(--forest); max-width: 14ch; }
        .hero p.lead { margin-top: 22px; font-size: 19px; color: var(--muted); max-width: 46ch; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 34px; }
        .hero-note { margin-top: 18px; font-size: 14px; color: var(--muted); }
        .hero-note a { color: var(--green); font-weight: 600; }

        .photo { position: relative; margin-bottom: 32px; isolation: isolate; }
        .photo::before { content: ""; position: absolute; inset: 22px -16px -16px 22px; background: var(--mint); border-radius: 20px; z-index: -1; }
        .photo img { width: 100%; height: auto; aspect-ratio: 3 / 2; object-fit: cover; object-position: 42% 68%; border-radius: 18px; box-shadow: 0 24px 48px -24px rgba(15, 61, 34, .45); background: var(--line); }
        .stamp { position: absolute; right: 16px; bottom: -34px; width: 150px; color: var(--stamp); transform: rotate(-12deg); opacity: .96; filter: drop-shadow(0 6px 10px rgba(15, 61, 34, .25)); }
        .stamp svg { width: 100%; height: auto; }
        @media (prefers-reduced-motion: no-preference) {
            .stamp { animation: stamp-down .5s .5s cubic-bezier(.2, 1.4, .4, 1) both; }
            @keyframes stamp-down {
                from { opacity: 0; transform: rotate(-24deg) scale(1.6); }
                to   { opacity: .96; transform: rotate(-12deg) scale(1); }
            }
        }

        /* Section umum */
        section { padding: 88px 0; scroll-margin-top: 68px; }
        h2 { font: 700 clamp(30px, 3.6vw, 42px)/1.12 var(--display); letter-spacing: -.03em; color: var(--forest); max-width: 20ch; }
        .section-intro { margin-top: 14px; color: var(--muted); max-width: 52ch; }

        /* Layanan */
        .layanan { background: var(--white); border-block: 1px solid var(--line); }
        .layanan-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 44px; }
        .layanan-item { border-left: 4px solid var(--green); padding: 6px 0 6px 24px; }
        .layanan-item:nth-child(2) { border-left-color: var(--stamp); }
        .layanan-item h3 { font: 700 24px var(--display); letter-spacing: -.02em; color: var(--forest); }
        .layanan-item p { margin-top: 8px; color: var(--muted); max-width: 44ch; }
        .layanan-item ul { margin-top: 16px; list-style: none; display: grid; gap: 8px; font-size: 15.5px; }
        .layanan-item li { padding-left: 24px; position: relative; }
        .layanan-item li::before { content: ""; position: absolute; left: 2px; top: 8px; width: 10px; height: 6px; border-left: 2px solid var(--green); border-bottom: 2px solid var(--green); transform: rotate(-45deg); }

        /* Alur status */
        .alur .wrap { display: grid; grid-template-columns: 1fr 1.2fr; gap: 64px; align-items: start; }
        .alur-sticky { position: sticky; top: 110px; }
        .steps { list-style: none; counter-reset: s; position: relative; }
        .steps::before { content: ""; position: absolute; left: 17px; top: 18px; bottom: 18px; width: 2px; background: var(--line); }
        .steps li { counter-increment: s; position: relative; padding: 0 0 30px 56px; }
        .steps li:last-child { padding-bottom: 0; }
        .steps li::before { content: counter(s); position: absolute; left: 0; top: 0; width: 36px; height: 36px; border-radius: 50%; background: var(--white); border: 2px solid var(--green); color: var(--green); display: grid; place-items: center; font: 700 15px var(--display); }
        .steps li:last-child::before { background: var(--green); color: var(--white); }
        .steps strong { display: block; font: 700 19px var(--display); letter-spacing: -.01em; color: var(--forest); line-height: 36px; }
        .steps span { color: var(--muted); font-size: 16px; }

        /* Video */
        .tutorial { background: var(--forest); color: var(--white); }
        .tutorial h2 { color: var(--white); }
        .tutorial .section-intro { color: #B9D3C2; }
        .tutorial .wrap { display: grid; grid-template-columns: 1fr 1.3fr; gap: 56px; align-items: center; }
        .video-frame { border-radius: 14px; overflow: hidden; background: #000; }
        .video-frame video { width: 100%; aspect-ratio: 16 / 9; background: #000; }

        /* FAQ */
        .faq .wrap { display: grid; grid-template-columns: 1fr 1.4fr; gap: 64px; align-items: start; }
        .faq-list { border-top: 1px solid var(--line); }
        .faq-list details { border-bottom: 1px solid var(--line); }
        .faq-list summary { list-style: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 20px 0; font: 600 18px var(--display); color: var(--forest); }
        .faq-list summary::-webkit-details-marker { display: none; }
        .faq-list summary::after { content: "+"; flex: none; width: 30px; height: 30px; border-radius: 50%; background: var(--mint); color: var(--green); display: grid; place-items: center; font: 600 20px/1 var(--body); transition: transform .25s; }
        .faq-list details[open] summary::after { transform: rotate(45deg); }
        .faq-list p { padding: 0 46px 22px 0; color: var(--muted); }

        /* Kontak */
        .kontak { background: var(--white); border-block: 1px solid var(--line); }
        .kontak .wrap { display: grid; grid-template-columns: 1fr 1fr; gap: 56px; align-items: center; }
        .kontak-list { margin-top: 28px; display: grid; gap: 20px; }
        .kontak-list dt { font: 600 14px var(--body); color: var(--muted); }
        .kontak-list dd { font: 600 18px var(--display); color: var(--forest); }
        .kontak-list a { color: var(--green); }
        .kontak-photo img { width: 100%; height: auto; aspect-ratio: 3 / 2; object-fit: cover; object-position: 42% 68%; border-radius: 18px; }

        /* CTA */
        .cta { text-align: left; }
        .cta-box { background: var(--green); color: var(--white); border-radius: 20px; padding: 56px; display: flex; align-items: center; justify-content: space-between; gap: 32px; flex-wrap: wrap; }
        .cta-box h2 { color: var(--white); max-width: 18ch; }
        .cta-box p { margin-top: 10px; color: #D5F2DF; }
        .cta-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-outline-light { border-color: rgba(255, 255, 255, .6); color: var(--white); }
        .btn-outline-light:hover { background: rgba(255, 255, 255, .12); }

        /* Footer */
        footer { background: var(--forest); color: #B9D3C2; padding: 64px 0 32px; font-size: 15px; }
        .foot-grid { display: grid; grid-template-columns: 1.4fr 1fr 1fr 1.2fr; gap: 40px; }
        footer h3 { font: 700 16px var(--display); color: var(--white); margin-bottom: 14px; }
        footer ul { list-style: none; display: grid; gap: 8px; }
        footer a { text-decoration: none; }
        footer a:hover { color: var(--white); text-decoration: underline; }
        .foot-brand .brand-name { color: var(--white); }
        .foot-brand .brand-name small { color: #8FB39D; }
        .foot-brand p { margin-top: 14px; max-width: 34ch; }
        .foot-bottom { margin-top: 48px; padding-top: 24px; border-top: 1px solid rgba(255, 255, 255, .14); display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; font-size: 14px; }

        /* Responsif */
        @media (max-width: 900px) {
            .hero { padding: 24px 0 64px; }
            .hero .wrap, .alur .wrap, .tutorial .wrap { grid-template-columns: 1fr; gap: 40px; }
            .layanan-grid { grid-template-columns: 1fr; gap: 36px; }
            .alur-sticky { position: static; }
            .stamp { width: 112px; right: 12px; bottom: -26px; }
            .photo { order: -1; margin-bottom: 8px; }
            .photo::before { inset: 14px -8px -10px 14px; }
            section { padding: 64px 0; }
            .cta-box { padding: 36px 26px; }
            .faq .wrap, .kontak .wrap { grid-template-columns: 1fr; gap: 32px; }
            .foot-grid { grid-template-columns: 1fr 1fr; }
            .foot-brand { grid-column: 1 / -1; }

            .menu-btn { display: inline-flex; }
            .nav-panel { display: none; position: absolute; top: 68px; left: -20px; right: -20px; flex-direction: column; align-items: stretch; gap: 16px; padding: 12px 20px 20px; background: var(--paper); border-bottom: 1px solid var(--line); box-shadow: 0 24px 32px -24px rgba(15, 61, 34, .35); }
            .nav-panel.is-open { display: flex; }
            .nav-links { flex-direction: column; align-items: stretch; }
            .nav-links a { padding: 13px 12px; font-size: 16px; }
            .nav-cta .btn { flex: 1; min-height: 48px; }
        }
        @media (max-width: 420px) {
            body { font-size: 16px; }
            .brand-name small { display: none; }
            .hero-actions .btn { width: 100%; }
            .photo img { aspect-ratio: 16 / 10; object-position: 40% 72%; border-radius: 14px; }
            .foot-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header class="nav">
        <div class="wrap">
            <a href="{{ url('/') }}" class="brand" aria-label="DocuDemi, beranda">
                <span class="brand-mark">D</span>
                <span class="brand-name">DocuDemi <small>SMKN 5 Surakarta</small></span>
            </a>
            <button type="button" class="menu-btn" id="menuBtn" aria-expanded="false" aria-controls="menu" aria-label="Buka menu"><span class="bars"></span></button>
            <div class="nav-panel" id="menu">
                <nav aria-label="Navigasi utama">
                    <ul class="nav-links">
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#layanan">Layanan</a></li>
                        <li><a href="#alur">Alur</a></li>
                        <li><a href="#tutorial">Tutorial</a></li>
                        <li><a href="#faq">FAQ</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                    </ul>
                </nav>
                <div class="nav-cta">
                    <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="hero" id="beranda">
            <div class="wrap">
                <div>
                    <h1>Legalisir ijazah tanpa antre di sekolah.</h1>
                    <p class="lead">Ajukan dari rumah, unggah scan ijazah atau transkrip, lalu pantau statusnya. Anda baru datang ke SMKN 5 Surakarta saat dokumen sudah siap diambil.</p>
                    <div class="hero-actions">
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar sebagai alumni</a>
                        <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
                    </div>
                    <p class="hero-note">Petugas kurikulum? <a href="{{ route('login') }}">Masuk di sini</a></p>
                </div>

                <div class="photo">
                    <div class="kontak-photo">
                    <img src="{{ asset('img/smk5hd.jpg') }}" alt="Papan nama SMK Negeri 5 Surakarta" width="800" height="503" loading="lazy">
                    <div class="stamp" aria-hidden="true">
                        <svg viewBox="0 0 200 200" fill="none" stroke="currentColor">
                            <defs>
                                <path id="ring" d="M100,100 m-72,0 a72,72 0 1,1 144,0 a72,72 0 1,1 -144,0"/>
                            </defs>
                            <circle cx="100" cy="100" r="95" fill="#F6F8F7" stroke="none"/>
                            <circle cx="100" cy="100" r="92" stroke-width="5"/>
                            <circle cx="100" cy="100" r="50" stroke-width="2.5"/>
                            <text fill="currentColor" stroke="none" font-family="Bricolage Grotesque, sans-serif" font-weight="800" font-size="17" letter-spacing="3.5">
                                <textPath href="#ring" startOffset="0">SMKN 5 SURAKARTA • SMKN 5 SURAKARTA •</textPath>
                            </text>
                            <text x="100" y="108" fill="currentColor" stroke="none" text-anchor="middle" font-family="Bricolage Grotesque, sans-serif" font-weight="800" font-size="22" letter-spacing="1">LEGALISIR</text>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <section class="layanan" id="layanan">
            <div class="wrap">
                <h2>Dua layanan dokumen untuk alumni</h2>
                <p class="section-intro">Pilih layanan saat membuat pengajuan. Petugas kurikulum memeriksa setiap pengajuan sebelum diproses.</p>

                <div class="layanan-grid">
                    <article class="layanan-item">
                        <h3>Legalisir ijazah / transkrip</h3>
                        <p>Pengesahan salinan fotokopi ijazah atau transkrip nilai oleh pihak sekolah.</p>
                        <ul>
                            <li>Unggah scan berkas dalam format PDF, JPG, atau PNG</li>
                            <li>Ukuran berkas maksimal 5 MB</li>
                            <li>Tentukan rencana tanggal pengambilan</li>
                        </ul>
                    </article>
                    <article class="layanan-item">
                        <h3>Pengambilan ijazah</h3>
                        <p>Pengambilan fisik ijazah asli yang tersimpan di sekolah.</p>
                        <ul>
                            <li>Tulis keperluan pengambilan</li>
                            <li>Pilih tanggal kedatangan</li>
                            <li>Ambil dokumen setelah status Siap Diambil</li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <section class="alur" id="alur">
            <div class="wrap">
                <div class="alur-sticky">
                    <h2>Status pengajuan selalu terlihat</h2>
                    <p class="section-intro">Setiap pengajuan melewati tahap yang sama. Anda bisa membuka dashboard kapan saja untuk melihat posisinya.</p>
                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn btn-primary">Ajukan layanan</a>
                    </div>
                </div>

                <ol class="steps">
                    <li><strong>Menunggu pemeriksaan</strong><span>Pengajuan Anda masuk ke antrean petugas kurikulum.</span></li>
                    <li><strong>Sedang diproses</strong><span>Petugas memeriksa kelengkapan dan keterbacaan berkas.</span></li>
                    <li><strong>Disetujui</strong><span>Pengajuan dinyatakan sesuai dan lanjut ke penyiapan dokumen.</span></li>
                    <li><strong>Disiapkan</strong><span>Dokumen sedang disiapkan oleh sekolah.</span></li>
                    <li><strong>Siap diambil</strong><span>Anda menerima notifikasi dan bisa datang sesuai jadwal pengambilan.</span></li>
                    <li><strong>Selesai</strong><span>Dokumen sudah diterima dan tercatat di riwayat Anda.</span></li>
                </ol>
            </div>
        </section>

        <section class="tutorial" id="tutorial">
            <div class="wrap">
                <div>
                    <h2>Belum pernah mencoba? Tonton dulu.</h2>
                    <p class="section-intro">Video singkat ini menunjukkan cara membuat pengajuan dari awal sampai selesai.</p>
                </div>
                <div class="video-frame">
                    <video controls preload="metadata" aria-label="Video tutorial penggunaan DocuDemi">
                        <source src="{{ asset('video/turorial.mp4') }}" type="video/mp4">
                        Peramban Anda tidak mendukung pemutaran video.
                    </video>
                </div>
            </div>
        </section>

        <section class="faq" id="faq">
            <div class="wrap">
                <div>
                    <h2>Pertanyaan yang sering muncul</h2>
                    <p class="section-intro">Belum menemukan jawabannya? Lihat bagian kontak untuk datang langsung ke sekolah.</p>
                </div>
                <div class="faq-list">
                    <details>
                        <summary>Siapa yang bisa memakai DocuDemi?</summary>
                        <p>Alumni SMKN 5 Surakarta yang sudah mendaftar memakai NIS / NISN. Petugas kurikulum masuk dengan email petugas.</p>
                    </details>
                    <details>
                        <summary>Berkas apa yang perlu diunggah?</summary>
                        <p>Untuk legalisir, unggah scan ijazah atau transkrip dalam format PDF, JPG, atau PNG dengan ukuran maksimal 5 MB. Pastikan tulisannya terbaca jelas. Pengambilan ijazah tidak memerlukan unggahan berkas.</p>
                    </details>
                    <details>
                        <summary>Bagaimana saya tahu dokumen sudah siap?</summary>
                        <p>Status pengajuan berubah menjadi Siap Diambil dan notifikasi muncul di akun Anda. Datanglah ke sekolah sesuai jadwal pengambilan.</p>
                    </details>
                    <details>
                        <summary>Pengajuan saya ditolak, apa yang harus dilakukan?</summary>
                        <p>Alasan penolakan ditampilkan pada halaman detail pengajuan. Perbaiki berkas atau data sesuai alasan tersebut, lalu buat pengajuan baru.</p>
                    </details>
                </div>
            </div>
        </section>

        <section class="kontak" id="kontak">
            <div class="wrap">
                <div>
                    <h2>Datang langsung ke sekolah</h2>
                    <p class="section-intro">Untuk kendala akun atau berkas yang tidak bisa diselesaikan online, temui petugas kurikulum di sekolah.</p>
                    <dl class="kontak-list">
                        <div><dt>Alamat</dt><dd>SMK Negeri 5 Surakarta<br>Jl. Adi Sucipto No. 42, Surakarta</dd></div>
                        <div><dt>Situs sekolah</dt><dd><a href="https://www.smkn5solo.sch.id" target="_blank" rel="noopener">www.smkn5solo.sch.id</a></dd></div>
                    </dl>
                    <div class="hero-actions">
                        <a class="btn btn-ghost" href="https://www.google.com/maps/search/?api=1&query=SMK+Negeri+5+Surakarta" target="_blank" rel="noopener">Buka di Google Maps</a>
                    </div>
                </div>
                <div class="kontak-photo">
                    <img src="{{ asset('img/smk5hd-landing-800.jpg') }}" alt="Papan nama SMK Negeri 5 Surakarta" width="800" height="503" loading="lazy">
                </div>
            </div>
        </section>

        <section class="cta">
            <div class="wrap">
                <div class="cta-box">
                    <div>
                        <h2>Siapkan scan ijazah, lalu mulai.</h2>
                        <p>Pendaftaran memakai NIS / NISN Anda.</p>
                    </div>
                    <div class="cta-actions">
                        <a href="{{ route('register') }}" class="btn btn-light">Daftar sebagai alumni</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Masuk</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="wrap">
            <div class="foot-grid">
                <div class="foot-brand">
                    <a href="#beranda" class="brand"><span class="brand-mark">D</span><span class="brand-name">DocuDemi <small>SMKN 5 Surakarta</small></span></a>
                    <p>Sistem informasi dokumen dan legalisir alumni SMKN 5 Surakarta.</p>
                </div>
                <div>
                    <h3>Halaman</h3>
                    <ul>
                        <li><a href="#layanan">Layanan</a></li>
                        <li><a href="#alur">Alur pengajuan</a></li>
                        <li><a href="#tutorial">Video tutorial</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Akses</h3>
                    <ul>
                        <li><a href="{{ route('login') }}">Masuk alumni</a></li>
                        <li><a href="{{ route('register') }}">Daftar alumni</a></li>
                        <li><a href="{{ route('login') }}">Masuk petugas</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Sekolah</h3>
                    <ul>
                        <li>Jl. Adi Sucipto No. 42, Surakarta</li>
                        <li><a href="https://www.smkn5solo.sch.id" target="_blank" rel="noopener">www.smkn5solo.sch.id</a></li>
                        <li><a href="#kontak">Cara menghubungi</a></li>
                    </ul>
                </div>
            </div>
            <div class="foot-bottom">
                <span>&copy; {{ date('Y') }} DocuDemi. SMK Negeri 5 Surakarta.</span>
                <a href="#beranda">Kembali ke atas</a>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            var btn = document.getElementById('menuBtn');
            var panel = document.getElementById('menu');
            var links = document.querySelectorAll('.nav-links a');

            function setMenu(open) {
                panel.classList.toggle('is-open', open);
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                btn.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
            }
            btn.addEventListener('click', function () { setMenu(!panel.classList.contains('is-open')); });
            links.forEach(function (a) { a.addEventListener('click', function () { setMenu(false); }); });
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { setMenu(false); } });
            window.matchMedia('(min-width: 901px)').addEventListener('change', function () { setMenu(false); });

            /* Tandai menu sesuai bagian yang sedang dilihat */
            if (!('IntersectionObserver' in window)) { return; }
            var map = {};
            links.forEach(function (a) { map[a.getAttribute('href').slice(1)] = a; });
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (en) {
                    if (!en.isIntersecting) { return; }
                    links.forEach(function (a) { a.classList.remove('is-active'); a.removeAttribute('aria-current'); });
                    var a = map[en.target.id];
                    if (a) { a.classList.add('is-active'); a.setAttribute('aria-current', 'true'); }
                });
            }, { rootMargin: '-45% 0px -50% 0px' });
            Object.keys(map).forEach(function (id) { var el = document.getElementById(id); if (el) { io.observe(el); } });
        })();
    </script>
</body>
</html>