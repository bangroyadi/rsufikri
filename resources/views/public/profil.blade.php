@extends('layouts.app')

@section('title', __('Tentang Kami') . ' - RSU Fikri Medika')

@section('content')

<!-- EXPLICIT SELF-CONTAINED CSS (100% INDEPENDENT OF TAILWIND COMPILATION) -->
<style>
    .mitra-body-bg {
        background-color: #EDF6FB;
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: #334155;
        overflow-x: hidden;
    }
    
    .mitra-container {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
        padding-left: 24px;
        padding-right: 24px;
    }

    /* 1. HERO SECTION */
    .mitra-hero-section {
        background: linear-gradient(180deg, #FFFFFF 0%, #EDF6FB 100%);
        padding-top: 24px;
        padding-bottom: 70px;
        position: relative;
    }
    .mitra-breadcrumb {
        font-size: 13px;
        color: #8C98A4;
        font-weight: 500;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .mitra-breadcrumb a {
        color: #8C98A4;
        text-decoration: none;
    }
    .mitra-breadcrumb a:hover {
        color: #0085CA;
    }

    .mitra-hero-row {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 48px;
        width: 100%;
    }
    .mitra-hero-img-col {
        flex: 0 0 50%;
        max-width: 50%;
        position: relative;
    }
    .mitra-hero-text-col {
        flex: 0 0 50%;
        max-width: 50%;
        text-align: left;
    }
    .mitra-hero-title-pink {
        color: #E61B72;
        font-weight: 800;
        font-size: 46px;
        line-height: 1.15;
        letter-spacing: -0.02em;
        margin: 0 0 6px 0;
    }
    .mitra-hero-title-blue {
        color: #0085CA;
        font-weight: 800;
        font-size: 46px;
        line-height: 1.15;
        letter-spacing: -0.02em;
        margin: 0 0 6px 0;
    }

    /* 2. OVERLAPPING CARDS & IMAGES */
    .mitra-section-wrap {
        padding: 40px 0;
        position: relative;
    }
    .mitra-overlap-row {
        display: flex;
        flex-direction: row;
        align-items: center;
        position: relative;
        width: 100%;
    }
    .mitra-card-floating {
        background: #FFFFFF;
        border-radius: 28px;
        box-shadow: 0 15px 35px rgba(0, 85, 150, 0.08);
        padding: 44px 40px;
        position: relative;
        z-index: 10;
        flex: 0 0 54%;
        max-width: 54%;
    }
    .mitra-img-floating {
        flex: 0 0 54%;
        max-width: 54%;
        height: 380px;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 85, 150, 0.08);
        position: relative;
        background: #FFFFFF;
    }
    .mitra-img-floating img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .mitra-card-left {
        margin-right: -8%;
    }
    .mitra-card-right {
        margin-left: -8%;
    }

    /* PILL BADGES */
    .mitra-badge-orange-pink {
        background: linear-gradient(90deg, #FF6B35 0%, #E61B72 100%);
        color: #FFFFFF;
        font-weight: 700;
        font-size: 18px;
        padding: 10px 32px;
        border-radius: 50px;
        position: absolute;
        top: -24px;
        box-shadow: 0 6px 16px rgba(230, 27, 114, 0.35);
        display: inline-block;
        white-space: nowrap;
    }
    .mitra-badge-green-yellow {
        background: linear-gradient(90deg, #0e7c47 0%, #16a34a 55%, #eab308 100%);
        color: #FFFFFF;
        font-weight: 700;
        font-size: 18px;
        padding: 10px 32px;
        border-radius: 50px;
        position: absolute;
        top: -24px;
        box-shadow: 0 6px 16px rgba(14, 124, 71, 0.35);
        display: inline-block;
        white-space: nowrap;
    }

    /* 4. CORE VALUES SECTION */
    .mitra-values-card {
        background: #FFFFFF;
        border-radius: 28px;
        box-shadow: 0 15px 35px rgba(0, 85, 150, 0.08);
        padding: 48px 44px;
        position: relative;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .mitra-values-row {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 32px;
        margin-top: 16px;
    }
    .mitra-values-text-col {
        flex: 0 0 58%;
        max-width: 58%;
        text-align: left;
    }
    .mitra-values-diagram-col {
        flex: 0 0 38%;
        max-width: 38%;
        display: flex;
        justify-content: center;
    }

    /* 5. WHATSAPP CTA BANNER */
    .mitra-wa-banner {
        background: #0085CA;
        background: linear-gradient(90deg, #0085CA 0%, #009FE3 100%);
        padding: 28px 0;
        color: #FFFFFF;
        width: 100%;
        margin-top: 40px;
    }
    .mitra-wa-flex {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
    }
    .mitra-wa-btn {
        background: #FFFFFF;
        color: #0085CA !important;
        border-radius: 50px;
        padding: 12px 34px;
        font-weight: 800;
        font-size: 22px;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        white-space: nowrap;
    }
    .mitra-wa-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
    }

    /* RESPONSIVE MEDIA QUERIES */
    @media (max-width: 992px) {
        .mitra-hero-row, .mitra-overlap-row, .mitra-values-row, .mitra-wa-flex {
            flex-direction: column !important;
            gap: 32px !important;
        }
        .mitra-hero-img-col, .mitra-hero-text-col, .mitra-card-floating, .mitra-img-floating, .mitra-values-text-col, .mitra-values-diagram-col {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        .mitra-hero-title-pink, .mitra-hero-title-blue {
            font-size: 32px;
        }
    }
</style>

<div class="mitra-body-bg">

    <!-- =========================================================================
         1. HERO HEADER SECTION (FULL-WIDTH BANNER GEDUNG 1)
         ========================================================================= -->
    <section class="mitra-hero-section">
        <div class="mitra-container">
            
            <!-- BREADCRUMB -->
            <div class="mitra-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>></span>
                <span style="color: #212529; font-weight: 600;">Tentang Kami</span>
            </div>

            <!-- FULL WIDTH BANNER IMAGE -->
            <div style="width: 100%; height: 420px; border-radius: 28px; overflow: hidden; box-shadow: 0 15px 35px rgba(0, 85, 150, 0.08); background: #FFFFFF;">
                <img src="{{ asset('gedung1_web.jpg') }}" 
                     alt="Gedung RSU Fikri Medika" 
                     style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;">
            </div>

        </div>
    </section>

    <!-- =========================================================================
         2. SEKILAS TENTANG KAMI (EXACT OVERLAPPING WHITE CARD LEFT, IMAGE RIGHT)
         ========================================================================= -->
    <section class="mitra-section-wrap">
        <div class="mitra-container">
            <div class="mitra-overlap-row">
                
                <!-- LEFT: FLOATING WHITE CARD -->
                <div class="mitra-card-floating mitra-card-left">
                    <!-- FLOATING ORANGE-PINK PILL BADGE -->
                    <div class="mitra-badge-orange-pink" style="left: 36px;">
                        Tentang Kami
                    </div>

                    <div style="font-size: 14.5px; color: #334155; line-height: 1.75; margin-top: 8px;">
                        <p style="margin-bottom: 14px;">
                            <strong>RSU Fikri Medika</strong> berdiri pada tahun 2008 dan didirikan dengan semangat untuk mendekatkan akses pelayanan kesehatan sekunder bagi masyarakat Karawang dan sekitarnya. Sejak awal berdirinya, rumah sakit ini terus mengalami perkembangan yang signifikan, baik dari segi penambahan fasilitas fisik, peningkatan jumlah dokter spesialis, maupun digitalisasi proses bisnis.
                        </p>
                        <p style="margin-bottom: 0;">
                            Transformasi digital yang dimulai dari sistem billing sederhana kini telah berkembang menjadi sistem informasi rumah sakit terintegrasi yang mencakup implementasi Rekam Medis Elektronik (RME) secara menyeluruh. Di bawah kepemimpinan Direktur <strong>Apt. Bintari Ari Kusumawati, S.Farm., MMRS</strong>, RSU Fikri Medika berkomitmen penuh untuk menjalani siklus akreditasi berkala sebagai bentuk penjaminan mutu pelayanan dan keselamatan pasien.
                        </p>
                    </div>
                </div>

                <!-- RIGHT: RECEPTIONIST PHOTO -->
                <div class="mitra-img-floating">
                    <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1000&q=80" 
                         alt="Pelayanan Ramah RSU Fikri Medika">
                </div>

            </div>
        </div>
    </section>

    <!-- =========================================================================
         3. VISI & MISI & MOTTO (MIRRORED OVERLAP: IMAGE LEFT, WHITE CARD RIGHT)
         ========================================================================= -->
    <section class="mitra-section-wrap">
        <div class="mitra-container">
            <div class="mitra-overlap-row">
                
                <!-- LEFT: DOCTOR EXAMINING CHILD PHOTO -->
                <div class="mitra-img-floating">
                    <img src="https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=1000&q=80" 
                         alt="Pelayanan Medis RSU Fikri Medika">
                </div>

                <!-- RIGHT: FLOATING WHITE CARD -->
                <div class="mitra-card-floating mitra-card-right">
                    <!-- FLOATING GREEN-YELLOW PILL BADGE -->
                    <div class="mitra-badge-green-yellow" style="right: 36px;">
                        Visi & Misi
                    </div>

                    <!-- VISI -->
                    <div style="margin-top: 8px;">
                        <h3 style="font-size: 21px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">Visi RSU Fikri Medika</h3>
                        <p style="font-size: 14.5px; color: #334155; line-height: 1.6; margin: 0;">
                            Menjadikan Rumah Sakit Swasta yang menyediakan layanan berkualitas, unggul dan terpercaya di Karawang.
                        </p>
                    </div>

                    <!-- DIVIDER -->
                    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 18px 0;">

                    <!-- MISI -->
                    <div>
                        <h3 style="font-size: 21px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">Misi RSU Fikri Medika</h3>
                        <ol style="margin: 0; padding-left: 20px; font-size: 14.5px; color: #334155; line-height: 1.7;">
                            <li style="margin-bottom: 4px;">Memberikan Pelayanan Kesehatan dan Medis terbaik kepada masyarakat.</li>
                            <li style="margin-bottom: 4px;">Mewujudkan Kesejahteraan bagi seluruh Stakeholder.</li>
                            <li style="margin-bottom: 0;">Peduli kepada lingkungan, masyarakat dan bangsa.</li>
                        </ol>
                    </div>

                    <!-- DIVIDER -->
                    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 18px 0;">

                    <!-- MOTTO -->
                    <div>
                        <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">Motto RSU Fikri Medika</h3>
                        <p style="font-size: 14.5px; font-weight: 600; color: #0e7c47; margin: 0; font-style: italic;">
                            "Kesehatan Anda Prioritas Layanan Utama Kami."
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

@endsection
