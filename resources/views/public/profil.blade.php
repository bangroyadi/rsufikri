@extends('layouts.app')

@section('content')
<!-- BREADCRUMB & REAL HOSPITAL HERO BANNER -->
<section class="relative text-white py-16 px-4 sm:px-6 lg:px-8 overflow-hidden shadow-xl bg-cover bg-center" style="background-image: url('{{ asset('banner-profil.png') }}');">
    <!-- DARK GREEN OVERLAY WITH ACCENT GLOW -->
    <div class="absolute inset-0 bg-gradient-to-r from-[#063e23]/95 via-[#0e7c47]/85 to-[#042817]/90 backdrop-blur-[2px]"></div>
    <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-yellow-400/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        <!-- BREADCRUMB -->
        <div class="flex items-center gap-2 text-xs sm:text-sm text-yellow-300 mb-4 font-semibold">
            <a href="{{ route('home') }}" class="hover:underline flex items-center gap-1">
                <i class="fa-solid fa-house text-xs"></i> {{ __('Beranda') }}
            </a>
            <i class="fa-solid fa-chevron-right text-[10px] text-emerald-200"></i>
            <span class="text-emerald-100">{{ __('Tentang Kami') }}</span>
            <i class="fa-solid fa-chevron-right text-[10px] text-emerald-200"></i>
            <span class="text-white font-bold">{{ __('Profil, Visi, Misi & Motto') }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 text-yellow-300 text-xs font-black border border-yellow-300/40 backdrop-blur-md mb-3 shadow-sm">
                    <i class="fa-solid fa-quote-left text-xs"></i> MOTTO UTAMA RSU FIKRI MEDIKA
                </div>
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight drop-shadow-md text-white">
                    "Kesehatan Anda Prioritas Layanan Utama Kami"
                </h1>
            </div>
            
            <!-- ACCREDITATION & LEGALITY BADGE CARD -->
            <div class="lg:col-span-4 flex lg:justify-end">
                <div class="bg-white/15 backdrop-blur-md border-2 border-white/20 p-6 rounded-2xl text-center shadow-2xl w-full max-w-xs transform hover:scale-105 transition-transform">
                    <div class="w-14 h-14 bg-gradient-to-tr from-yellow-400 to-amber-300 text-slate-950 rounded-2xl flex items-center justify-center mx-auto text-2xl font-black mb-3 shadow-lg shadow-yellow-400/30">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h3 class="font-black text-white text-lg">Terakreditasi Paripurna</h3>
                    <p class="text-xs text-yellow-300 font-bold mt-1">Komisi Akreditasi Rumah Sakit (KARS)</p>
                    <span class="inline-block mt-3 px-3.5 py-1 rounded-xl bg-emerald-950/80 text-emerald-200 text-xs font-extrabold border border-emerald-400/30 shadow-xs">
                        ⭐ Standar Mutu Medis Nasional ⭐
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- MAIN CONTENT SECTION -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-16">

    <!-- SEJARAH & SEKILAS PROFIL -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
        <!-- LEFT TEXT CONTENT -->
        <div class="lg:col-span-7 space-y-5">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-emerald-100/70 text-[#0e7c47] text-xs font-bold">
                <i class="fa-solid fa-building-hospital"></i> Profil Perusahaan
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight leading-snug">
                Rumah Sakit Umum Fikri Medika Karawang
            </h2>
            <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                <strong>Fikri Medika GROUP</strong> yang bernaung di bawah <strong>PT. Karya Mandiri Medika Utama</strong> adalah perusahaan yang bergerak di bidang pelayanan jasa kesehatan, yang dimulai dengan berdirinya sarana pelayanan kesehatan berupa Klinik & Rumah Bersalin.
            </p>
            <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                Seiring berjalannya waktu dan meningkatnya kebutuhan masyarakat akan fasilitas medis komprehensif, Fikri Medika berkembang pesat menjadi Rumah Sakit Umum (RSU) yang menyediakan layanan medis terpadu, rawat jalan, rawat inap, IGD 24 Jam, serta berbagai layanan medis spesialis dengan standar mutu dan keselamatan pasien tinggi.
            </p>

            <!-- HIGHLIGHT POINTS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div class="flex items-start gap-3 p-3.5 rounded-xl bg-emerald-50/60 border border-emerald-100">
                    <i class="fa-solid fa-circle-check text-[#0e7c47] text-lg mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Badan Hukum Resmi</h4>
                        <p class="text-xs text-gray-600 mt-0.5">PT. Karya Mandiri Medika Utama.</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-3.5 rounded-xl bg-emerald-50/60 border border-emerald-100">
                    <i class="fa-solid fa-hand-holding-medical text-[#0e7c47] text-lg mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Fasilitas Lengkap</h4>
                        <p class="text-xs text-gray-600 mt-0.5">Pelayanan Hemodialisa, Fisioterapi, MCU, & IGD 24 Jam.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT SHOWCASE CARD -->
        <div class="lg:col-span-5 relative">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-gradient-to-br from-[#0e7c47] to-[#096237] text-white p-8 space-y-6">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-3xl text-yellow-300">
                    <i class="fa-solid fa-hospital-user"></i>
                </div>
                <div>
                    <span class="text-xs text-emerald-200 font-semibold uppercase tracking-wider">Identitas Pelayanan</span>
                    <h3 class="text-xl font-bold text-white mt-1">Layanan Medis Berkualitas & Terpercaya</h3>
                </div>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Kami terus berkomitmen meningkatkan kualitas pelayanan kesehatan melalui dokter spesialis berpengalaman, teknologi medis terkini, dan keramahan profesional bagi setiap pasien.
                </p>
                <div class="pt-4 border-t border-emerald-600/40 flex items-center justify-between text-xs font-semibold text-yellow-300">
                    <span><i class="fa-solid fa-location-dot"></i> Karawang, Jawa Barat</span>
                    <span><i class="fa-solid fa-clock"></i> Siaga 24 Jam</span>
                </div>
            </div>
        </div>
    </div>

    <!-- VISI & MISI SECTION (OFFICIAL TEXT) -->
    <div class="space-y-10 pt-4">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="inline-block px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold">
                Landasan Utama
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-gray-900">Visi & Misi Rumah Sakit</h2>
            <p class="text-gray-600 text-sm">Pedoman resmi RSU Fikri Medika dalam melayani masyarakat.</p>
        </div>

        <!-- HIGHLY ATTRACTIVE & HUMAN-CENTERED VISI SHOWCASE CARD -->
        <div class="bg-gradient-to-br from-[#084829] via-[#0e7c47] to-[#042d19] rounded-3xl p-6 sm:p-8 lg:p-10 text-white shadow-2xl relative overflow-hidden border-2 border-emerald-400/30">
            
            <!-- BACKGROUND GLOW & ACCENTS -->
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-yellow-400/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute left-10 -bottom-20 w-80 h-80 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                
                <!-- LEFT COLUMN: VISI TEXT & CORE PILLARS -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 text-yellow-300 text-xs font-black uppercase tracking-wider border border-yellow-300/40 backdrop-blur-md shadow-xs">
                        <i class="fa-solid fa-compass text-sm text-yellow-400 animate-pulse"></i>
                        <span>Visi Utama RSU Fikri Medika</span>
                    </div>

                    <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black leading-snug text-white drop-shadow-md">
                        "Menjadikan rumah sakit swasta yang menyediakan layanan <span class="text-yellow-300 underline decoration-yellow-400/60 decoration-wavy decoration-2">berkualitas</span>, <span class="text-yellow-300 underline decoration-yellow-400/60 decoration-wavy decoration-2">unggul</span>, dan <span class="text-yellow-300 underline decoration-yellow-400/60 decoration-wavy decoration-2">terpercaya</span> di Karawang."
                    </h3>

                    <!-- 3 INTERACTIVE FEATURE BADGES -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                        <div class="flex items-center gap-2.5 p-3 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-md">
                            <div class="w-8 h-8 rounded-xl bg-yellow-400 text-slate-950 flex items-center justify-center text-sm font-black shrink-0 shadow-sm">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-white text-xs">Berkualitas</h4>
                                <p class="text-[10px] text-emerald-100 font-medium">Standar Mutu Medis</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5 p-3 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-md">
                            <div class="w-8 h-8 rounded-xl bg-yellow-400 text-slate-950 flex items-center justify-center text-sm font-black shrink-0 shadow-sm">
                                <i class="fa-solid fa-award"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-white text-xs">Unggul</h4>
                                <p class="text-[10px] text-emerald-100 font-medium">Fasilitas Modern</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2.5 p-3 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-md">
                            <div class="w-8 h-8 rounded-xl bg-yellow-400 text-slate-950 flex items-center justify-center text-sm font-black shrink-0 shadow-sm">
                                <i class="fa-solid fa-hand-holding-heart"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-white text-xs">Terpercaya</h4>
                                <p class="text-[10px] text-emerald-100 font-medium">Karakter Islami</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: HUMAN ELEMENT DOCTOR PORTRAIT CARD -->
                <div class="lg:col-span-5 relative flex justify-center">
                    <div class="relative w-full max-w-sm rounded-3xl overflow-hidden border-4 border-white/20 shadow-2xl group">
                        
                        <!-- DOCTOR PHOTO -->
                        <img src="{{ asset('visi-doctor.png') }}" 
                             alt="Tim Medis RSU Fikri Medika" 
                             class="w-full h-72 sm:h-80 object-cover object-top transform group-hover:scale-105 transition-transform duration-500">

                        <!-- GRADIENT OVERLAY ON PHOTO -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/20 to-transparent"></div>

                        <!-- FLOATING CAPTION ON PHOTO -->
                        <div class="absolute bottom-4 left-4 right-4 p-3.5 rounded-2xl bg-white/15 backdrop-blur-md border border-white/20 text-white space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-black text-yellow-300 uppercase tracking-wider flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                    <span>Tim Medis Siap Melayani</span>
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-yellow-400 text-slate-950">24/7 Siaga</span>
                            </div>
                            <p class="text-[11px] text-emerald-100 font-medium leading-snug">
                                Melayani dengan kehangatan profesionalisme & nilai-nilai kedokteran Islami.
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- MISI CARDS (3 OFFICIAL POINTS) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-extrabold">
                        1
                    </div>
                    <h4 class="font-bold text-gray-900 text-base">Pelayanan Medis Terbaik</h4>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Memberikan pelayanan kesehatan dan medis terbaik kepada masyarakat secara profesional dan berkelanjutan.
                    </p>
                </div>
                <div class="pt-3 border-t border-gray-100 text-xs font-semibold text-[#0e7c47]">
                    <i class="fa-solid fa-check-circle"></i> Mutu Medis Terjamin
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-extrabold">
                        2
                    </div>
                    <h4 class="font-bold text-gray-900 text-base">Kesejahteraan Stakeholder</h4>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Mewujudkan kesejahteraan bagi seluruh stakeholder (pasien, dokter, karyawan, serta mitra kerja).
                    </p>
                </div>
                <div class="pt-3 border-t border-gray-100 text-xs font-semibold text-[#0e7c47]">
                    <i class="fa-solid fa-check-circle"></i> Hubungan Harmonis
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl font-extrabold">
                        3
                    </div>
                    <h4 class="font-bold text-gray-900 text-base">Kepedulian Sosial & Bangsa</h4>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        Peduli kepada lingkungan, masyarakat, dan bangsa melalui kontribusi nyata dalam bidang kesehatan.
                    </p>
                </div>
                <div class="pt-3 border-t border-gray-100 text-xs font-semibold text-[#0e7c47]">
                    <i class="fa-solid fa-check-circle"></i> Tanggung Jawab Sosial
                </div>
            </div>
        </div>
    </div>

    <!-- PELAYANAN UNGGULAN SPOTLIGHT -->
    <div class="space-y-8 pt-4">
        <div class="text-center max-w-xl mx-auto space-y-2">
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-[#0e7c47] text-xs font-bold">Fasilitas Utama</span>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Pelayanan Unggulan RSU Fikri Medika</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-3 hover:border-emerald-200 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl">
                    <i class="fa-solid fa-vial-circle-check"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-base">Pelayanan Hemodialisa</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Rumah sakit kami telah dilengkapi pelayanan Hemodialisa (cuci darah) dengan fasilitas lengkap dan ruangan yang nyaman.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-3 hover:border-emerald-200 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl">
                    <i class="fa-solid fa-person-walking-rehab"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-base">Fisioteraphi & Rehab Medik</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Terapi fisik profesional untuk membantu pemulihan dan mengatasi masalah pada bagian tubuh yang nyeri atau terganggu.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-3 hover:border-emerald-200 transition-all">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl">
                    <i class="fa-solid fa-notes-medical"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-base">Medical Check Up (MCU)</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Paket pendaftaran Medical Check Up perorangan maupun MCU Eksternal perusahaan langsung di lokasi industri.
                </p>
            </div>
        </div>
    </div>

    <!-- CTA BANNER (ELEGANT HOSPITAL GREEN THEME) -->
    <div class="bg-gradient-to-r from-[#0a5c34] via-[#0e7c47] to-[#084b2a] rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 border-2 border-emerald-500/20 relative overflow-hidden">
        <!-- BACKGROUND DECORATIVE GLOW -->
        <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-yellow-400/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="space-y-2 text-center md:text-left relative z-10">
            <span class="px-3.5 py-1 rounded-full bg-white/15 text-yellow-300 text-xs font-black uppercase tracking-wider border border-yellow-300/30 backdrop-blur-md">
                Layanan Terpercaya
            </span>
            <h3 class="text-xl sm:text-2xl font-black tracking-tight drop-shadow-xs">
                Konsultasikan Kesehatan Anda Bersama Dokter Kami
            </h3>
            <p class="text-xs sm:text-sm text-emerald-100 max-w-xl font-medium">
                Dapatkan pelayanan medis terbaik dari dokter spesialis RSU Fikri Medika Karawang.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 shrink-0 relative z-10">
            <a href="{{ url('/jadwal-dokter') }}" class="px-5 py-3 rounded-xl bg-white text-[#0e7c47] font-extrabold text-xs sm:text-sm hover:bg-emerald-50 transition-colors shadow flex items-center justify-center gap-2">
                <i class="fa-solid fa-calendar-days text-[#0e7c47]"></i>
                <span>Jadwal Dokter</span>
            </a>
            <a href="{{ url('/buat-janji') }}" class="px-5 py-3 rounded-xl bg-yellow-400 text-slate-950 font-black text-xs sm:text-sm hover:bg-yellow-300 transition-colors shadow flex items-center justify-center gap-2">
                <i class="fa-solid fa-heart-pulse text-red-600"></i>
                <span>Buat Janji Online</span>
            </a>
        </div>
    </div>

</section>
@endsection
