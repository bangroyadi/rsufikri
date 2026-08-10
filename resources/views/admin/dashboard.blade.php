@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- ═══ WELCOME BANNER ═══ --}}
<div style="background: linear-gradient(135deg, #0f1f2e 0%, #0e7c47 100%); border-radius: 14px; padding: 28px 32px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 20px; overflow: hidden; position: relative;">
    <div style="position: absolute; right: -40px; top: -40px; width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,0.04); pointer-events: none;"></div>
    <div style="position: absolute; right: 80px; bottom: -60px; width: 180px; height: 180px; border-radius: 50%; background: rgba(255,255,255,0.03); pointer-events: none;"></div>
    <div style="position: relative; z-index: 1;">
        <div style="font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.55); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px;">
            Selamat datang kembali
        </div>
        <h2 style="font-size: 22px; font-weight: 800; color: #ffffff; margin: 0 0 6px 0; letter-spacing: -0.02em;">
            {{ Auth::user()?->name ?? 'Administrator' }} 👋
        </h2>
        <p style="font-size: 13px; color: rgba(255,255,255,0.65); margin: 0; max-width: 480px; line-height: 1.6;">
            Panel CMS RSU Fikri Medika Karawang — kelola semua konten website dari satu tempat.
        </p>
    </div>
    <div style="display: flex; gap: 10px; flex-shrink: 0; position: relative; z-index: 1;">
        <a href="{{ route('admin.doctors.index') }}" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); color: #ffffff; padding: 9px 16px; border-radius: 9px; font-size: 12.5px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 7px; backdrop-filter: blur(4px);">
            <i class="fa-solid fa-user-plus"></i>
            Kelola Dokter
        </a>
        <a href="{{ route('admin.banners.index') }}" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.8); padding: 9px 16px; border-radius: 9px; font-size: 12.5px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 7px;">
            <i class="fa-solid fa-sliders"></i>
            Banner
        </a>
    </div>
</div>

{{-- ═══ STAT CARDS ═══ --}}
<div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px; margin-bottom: 24px;">

    {{-- Dokter --}}
    <a href="{{ route('admin.doctors.index') }}" style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 14px; padding: 20px; text-decoration: none; display: block; transition: all 0.15s; grid-column: span 1;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #ecfdf5; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #0e7c47;">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
        </div>
        <div style="font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; line-height: 1;">{{ $totalDoctors }}</div>
        <div style="font-size: 12px; color: #64748b; font-weight: 500; margin-top: 4px;">Dokter Spesialis</div>
        <div style="width: 100%; height: 3px; background: #ecfdf5; border-radius: 99px; margin-top: 14px; overflow: hidden;">
            <div style="height: 100%; background: #0e7c47; border-radius: 99px; width: 70%;"></div>
        </div>
    </a>

    {{-- Jadwal --}}
    <a href="{{ route('admin.schedules.index') }}" style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 14px; padding: 20px; text-decoration: none; display: block; transition: all 0.15s; grid-column: span 1;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #fffbeb; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #d97706;">
                <i class="fa-regular fa-calendar-check"></i>
            </div>
        </div>
        <div style="font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; line-height: 1;">{{ $totalSchedules }}</div>
        <div style="font-size: 12px; color: #64748b; font-weight: 500; margin-top: 4px;">Jadwal Praktik</div>
        <div style="width: 100%; height: 3px; background: #fffbeb; border-radius: 99px; margin-top: 14px; overflow: hidden;">
            <div style="height: 100%; background: #f59e0b; border-radius: 99px; width: 55%;"></div>
        </div>
    </a>

    {{-- Poli --}}
    <a href="{{ route('admin.polyclinics.index') }}" style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 14px; padding: 20px; text-decoration: none; display: block; transition: all 0.15s; grid-column: span 1;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #f0fdfa; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #0d9488;">
                <i class="fa-solid fa-clinic-medical"></i>
            </div>
        </div>
        <div style="font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; line-height: 1;">{{ $totalPolyclinics }}</div>
        <div style="font-size: 12px; color: #64748b; font-weight: 500; margin-top: 4px;">Poli / Dep.</div>
        <div style="width: 100%; height: 3px; background: #f0fdfa; border-radius: 99px; margin-top: 14px; overflow: hidden;">
            <div style="height: 100%; background: #14b8a6; border-radius: 99px; width: 80%;"></div>
        </div>
    </a>

    {{-- Layanan --}}
    <a href="{{ route('admin.services.index') }}" style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 14px; padding: 20px; text-decoration: none; display: block; transition: all 0.15s; grid-column: span 1;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #eff6ff; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #2563eb;">
                <i class="fa-solid fa-briefcase-medical"></i>
            </div>
        </div>
        <div style="font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; line-height: 1;">{{ $totalServices }}</div>
        <div style="font-size: 12px; color: #64748b; font-weight: 500; margin-top: 4px;">Fasilitas</div>
        <div style="width: 100%; height: 3px; background: #eff6ff; border-radius: 99px; margin-top: 14px; overflow: hidden;">
            <div style="height: 100%; background: #3b82f6; border-radius: 99px; width: 65%;"></div>
        </div>
    </a>

    {{-- Berita --}}
    <a href="{{ route('admin.news.index') }}" style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 14px; padding: 20px; text-decoration: none; display: block; transition: all 0.15s; grid-column: span 1;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #faf5ff; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #9333ea;">
                <i class="fa-regular fa-newspaper"></i>
            </div>
        </div>
        <div style="font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; line-height: 1;">{{ $totalNews }}</div>
        <div style="font-size: 12px; color: #64748b; font-weight: 500; margin-top: 4px;">Berita RS</div>
        <div style="width: 100%; height: 3px; background: #faf5ff; border-radius: 99px; margin-top: 14px; overflow: hidden;">
            <div style="height: 100%; background: #9333ea; border-radius: 99px; width: 40%;"></div>
        </div>
    </a>

    {{-- Artikel --}}
    <a href="{{ route('admin.articles.index') }}" style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 14px; padding: 20px; text-decoration: none; display: block; transition: all 0.15s; grid-column: span 1;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: #fff1f2; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #e11d48;">
                <i class="fa-solid fa-file-medical"></i>
            </div>
        </div>
        <div style="font-size: 26px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; line-height: 1;">{{ $totalArticles }}</div>
        <div style="font-size: 12px; color: #64748b; font-weight: 500; margin-top: 4px;">Artikel</div>
        <div style="width: 100%; height: 3px; background: #fff1f2; border-radius: 99px; margin-top: 14px; overflow: hidden;">
            <div style="height: 100%; background: #e11d48; border-radius: 99px; width: 35%;"></div>
        </div>
    </a>

</div>

{{-- ═══ QUICK ACTIONS ═══ --}}
<div style="background: #ffffff; border: 1px solid #e9ecef; border-radius: 14px; padding: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;">
        <div>
            <div style="font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-bolt" style="color: #f59e0b; font-size: 14px;"></i>
                Pintasan Cepat
            </div>
            <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">Akses langsung ke fitur-fitur utama.</div>
        </div>
    </div>
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;">

        <a href="{{ route('admin.doctors.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; background: #f8fafc; border: 1px solid #e9ecef; border-radius: 11px; text-decoration: none; transition: all 0.15s;">
            <div style="width: 38px; height: 38px; border-radius: 9px; background: #ecfdf5; display: flex; align-items: center; justify-content: center; font-size: 15px; color: #0e7c47; flex-shrink: 0;">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <div>
                <div style="font-size: 12.5px; font-weight: 700; color: #1e293b;">Dokter Baru</div>
                <div style="font-size: 11px; color: #94a3b8; margin-top: 1px;">Tambah profil</div>
            </div>
        </a>

        <a href="{{ route('admin.schedules.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; background: #f8fafc; border: 1px solid #e9ecef; border-radius: 11px; text-decoration: none; transition: all 0.15s;">
            <div style="width: 38px; height: 38px; border-radius: 9px; background: #fffbeb; display: flex; align-items: center; justify-content: center; font-size: 15px; color: #d97706; flex-shrink: 0;">
                <i class="fa-regular fa-calendar-plus"></i>
            </div>
            <div>
                <div style="font-size: 12.5px; font-weight: 700; color: #1e293b;">Slot Jadwal</div>
                <div style="font-size: 11px; color: #94a3b8; margin-top: 1px;">Atur jam praktik</div>
            </div>
        </a>

        <a href="{{ route('admin.news.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; background: #f8fafc; border: 1px solid #e9ecef; border-radius: 11px; text-decoration: none; transition: all 0.15s;">
            <div style="width: 38px; height: 38px; border-radius: 9px; background: #faf5ff; display: flex; align-items: center; justify-content: center; font-size: 15px; color: #9333ea; flex-shrink: 0;">
                <i class="fa-regular fa-paper-plane"></i>
            </div>
            <div>
                <div style="font-size: 12.5px; font-weight: 700; color: #1e293b;">Publikasi Berita</div>
                <div style="font-size: 11px; color: #94a3b8; margin-top: 1px;">Tulis berita</div>
            </div>
        </a>

        <a href="{{ route('admin.banners.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; background: #f8fafc; border: 1px solid #e9ecef; border-radius: 11px; text-decoration: none; transition: all 0.15s;">
            <div style="width: 38px; height: 38px; border-radius: 9px; background: #eff6ff; display: flex; align-items: center; justify-content: center; font-size: 15px; color: #2563eb; flex-shrink: 0;">
                <i class="fa-solid fa-sliders"></i>
            </div>
            <div>
                <div style="font-size: 12.5px; font-weight: 700; color: #1e293b;">Banner Home</div>
                <div style="font-size: 11px; color: #94a3b8; margin-top: 1px;">Kelola slider</div>
            </div>
        </a>

    </div>
</div>

@endsection
