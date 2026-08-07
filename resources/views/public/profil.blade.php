@extends('layouts.app')

@section('content')
<!-- BREADCRUMB & HERO BANNER -->
<section class="relative bg-gradient-to-r from-[#0e7c47] via-[#096237] to-[#084b2a] text-white py-14 px-4 sm:px-6 lg:px-8 overflow-hidden shadow-inner">
    <!-- BACKGROUND DECORATIVE GLOW -->
    <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-yellow-400/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute left-10 top-0 w-72 h-72 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none"></div>

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
                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 text-yellow-300 text-xs font-bold border border-yellow-300/30 backdrop-blur-sm mb-3">
                    <i class="fa-solid fa-hospital-user text-xs"></i> PT. Karya Mandiri Medika Utama
                </span>
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                    Profil, Visi, Misi & Motto
                </h1>
                <p class="mt-3 text-sm sm:text-base text-emerald-100 leading-relaxed max-w-3xl">
                    RSU Fikri Medika Karawang berkomitmen memberikan pelayanan medis terbaik, berkualitas, unggul, dan terpercaya bagi seluruh masyarakat.
                </p>
            </div>
            
            <!-- ACCREDITATION & LEGALITY BADGE CARD -->
            <div class="lg:col-span-4 flex lg:justify-end">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl text-center shadow-2xl w-full max-w-xs">
                    <div class="w-14 h-14 bg-yellow-400 text-gray-900 rounded-full flex items-center justify-center mx-auto text-2xl font-bold mb-3 shadow-lg shadow-yellow-400/30">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h3 class="font-bold text-white text-base">Terakreditasi Paripurna</h3>
                    <p class="text-xs text-yellow-200 mt-1">Komisi Akreditasi Rumah Sakit (KARS)</p>
                    <span class="inline-block mt-3 px-3 py-1 rounded-lg bg-emerald-900/60 text-emerald-200 text-[11px] font-semibold border border-emerald-500/30">
                        Standar Mutu Medis Nasional
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MOTTO HIGHLIGHT BANNER -->
<section class="relative -mt-7 z-20 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
    <div class="bg-gradient-to-r from-yellow-400 via-amber-400 to-yellow-500 rounded-2xl shadow-xl p-6 text-gray-900 flex flex-col sm:flex-row items-center justify-between gap-4 border-2 border-yellow-300">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gray-900 text-yellow-400 flex items-center justify-center text-2xl shrink-0 shadow-md">
                <i class="fa-solid fa-quote-left"></i>
            </div>
            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-gray-800">Motto Utama RSU Fikri Medika</span>
                <h3 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight mt-0.5">
                    "Kesehatan Anda Prioritas Layanan Utama Kami"
                </h3>
            </div>
        </div>
        <a href="{{ url('/buat-janji') }}" class="px-5 py-2.5 rounded-xl bg-gray-900 text-white text-xs sm:text-sm font-bold hover:bg-gray-800 transition-colors shadow shrink-0 flex items-center gap-2">
            <i class="fa-solid fa-heart-pulse text-red-500"></i>
            <span>Daftar / Buat Janji</span>
        </a>
    </div>
</section>

<!-- STATS COUNTER BAR -->
<section class="pt-8 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 grid grid-cols-2 md:grid-cols-4 gap-6 divide-y md:divide-y-0 md:divide-x divide-gray-100">
        <div class="flex items-center gap-4 pt-2 md:pt-0">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-bed-pulse"></i>
            </div>
            <div>
                <h4 class="text-2xl font-extrabold text-gray-900">150+</h4>
                <p class="text-xs text-gray-500 font-medium">Tempat Tidur Rawat Inap</p>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2 md:pt-0 md:pl-6">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
            <div>
                <h4 class="text-2xl font-extrabold text-gray-900">50+</h4>
                <p class="text-xs text-gray-500 font-medium">Dokter Spesialis & Subspesialis</p>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2 md:pt-0 md:pl-6">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-truck-medical"></i>
            </div>
            <div>
                <h4 class="text-2xl font-extrabold text-gray-900">24/7</h4>
                <p class="text-xs text-gray-500 font-medium">Layanan IGD & Ambulans Siaga</p>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2 md:pt-0 md:pl-6">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#0e7c47] flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-star text-yellow-500"></i>
            </div>
            <div>
                <h4 class="text-2xl font-extrabold text-gray-900">98.6%</h4>
                <p class="text-xs text-gray-500 font-medium">Tingkat Kepuasan Pasien</p>
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

        <!-- VISI BANNER CARD -->
        <div class="bg-gradient-to-r from-[#0e7c47] via-[#096237] to-[#074728] rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute right-0 top-0 w-80 h-80 bg-yellow-400/10 rounded-full blur-2xl"></div>
            <div class="relative z-10 max-w-4xl space-y-3">
                <div class="flex items-center gap-3 text-yellow-300 font-bold text-sm">
                    <i class="fa-solid fa-compass text-lg"></i>
                    <span>VISI RSU FIKRI MEDIKA</span>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold leading-relaxed text-white">
                    "Menjadikan rumah sakit swasta yang menyediakan layanan berkualitas, unggul, dan terpercaya di Karawang."
                </h3>
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

    <!-- CTA BANNER -->
    <div class="bg-gradient-to-r from-red-600 via-red-600 to-red-700 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2 text-center md:text-left">
            <span class="px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold uppercase tracking-wider">Layanan Terpercaya</span>
            <h3 class="text-xl sm:text-2xl font-extrabold">Konsultasikan Kesehatan Anda Bersama Dokter Kami</h3>
            <p class="text-xs sm:text-sm text-red-100 max-w-xl">
                Dapatkan pelayanan medis terbaik dari dokter spesialis RSU Fikri Medika Karawang.
            </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 shrink-0">
            <a href="{{ url('/jadwal-dokter') }}" class="px-5 py-3 rounded-xl bg-white text-gray-900 font-bold text-xs sm:text-sm hover:bg-gray-100 transition-colors shadow flex items-center justify-center gap-2">
                <i class="fa-solid fa-calendar-days text-[#0e7c47]"></i>
                <span>Jadwal Dokter</span>
            </a>
            <a href="{{ url('/buat-janji') }}" class="px-5 py-3 rounded-xl bg-yellow-400 text-gray-900 font-bold text-xs sm:text-sm hover:bg-yellow-300 transition-colors shadow flex items-center justify-center gap-2">
                <i class="fa-solid fa-heart-pulse text-red-600"></i>
                <span>Buat Janji Online</span>
            </a>
        </div>
    </div>

</section>
@endsection
