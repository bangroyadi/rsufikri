@extends('layouts.app')

@section('content')




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

        <!-- RIGHT SHOWCASE CARD IMAGE (GEDUNG 2) -->
        <div class="lg:col-span-5 relative">
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-white p-2">
                <img src="{{ asset('gedung2_web.jpg') }}" 
                     alt="Gedung RSU Fikri Medika" 
                     class="w-full h-80 sm:h-96 object-cover rounded-2xl"
                     loading="lazy"
                     decoding="async">
                
                <!-- FLOATING BADGE -->
                <div class="absolute bottom-6 left-6 right-6 bg-slate-900/80 backdrop-blur-md border border-white/20 p-4 rounded-2xl text-white shadow-xl flex items-center justify-between">
                    <div>
                        <div class="text-[10px] text-yellow-300 font-extrabold uppercase tracking-wider">Gedung Utama</div>
                        <div class="text-sm font-bold text-white">RSU Fikri Medika Karawang</div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-emerald-600 text-white text-[11px] font-bold">
                        <i class="fa-solid fa-location-dot text-[10px]"></i> Karawang
                    </span>
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

        <!-- ELEGANT CLEAR WHITE VISI SHOWCASE CARD (NO PHOTO, CLEAR THEME, RS HIGHLIGHT) -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 lg:p-12 text-slate-900 shadow-xl relative overflow-hidden border border-gray-100">
            
            <div class="max-w-4xl mx-auto space-y-8 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 text-[#0e7c47] text-xs font-black uppercase tracking-wider border border-emerald-200 shadow-xs">
                    <i class="fa-solid fa-compass text-sm text-[#0e7c47]"></i>
                    <span>Visi Utama RSU Fikri Medika</span>
                </div>

                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black leading-relaxed text-slate-900 max-w-3xl mx-auto">
                    "Menjadikan rumah sakit swasta yang menyediakan layanan <span class="text-[#0e7c47] underline decoration-[#0e7c47]/30 decoration-wavy decoration-2">berkualitas</span>, <span class="text-[#0e7c47] underline decoration-[#0e7c47]/30 decoration-wavy decoration-2">unggul</span>, dan <span class="text-[#0e7c47] underline decoration-[#0e7c47]/30 decoration-wavy decoration-2">terpercaya</span> di Karawang."
                </h3>

                <!-- 3 CORE RS HIGHLIGHT PILLARS -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 text-left">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-gray-100 hover:border-emerald-200 transition-all hover:shadow-md group">
                        <div class="w-12 h-12 rounded-2xl bg-[#0e7c47] text-white flex items-center justify-center text-xl font-bold mb-4 shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-star text-yellow-300"></i>
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-base mb-1">Berkualitas</h4>
                        <p class="text-xs text-gray-500 font-medium leading-relaxed">
                            Standar mutu pelayanan medis tinggi, ditunjang oleh dokter spesialis & perawat berpengalaman.
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-gray-100 hover:border-emerald-200 transition-all hover:shadow-md group">
                        <div class="w-12 h-12 rounded-2xl bg-[#0e7c47] text-white flex items-center justify-center text-xl font-bold mb-4 shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-award text-yellow-300"></i>
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-base mb-1">Unggul</h4>
                        <p class="text-xs text-gray-500 font-medium leading-relaxed">
                            Fasilitas medis modern, IGD 24 jam, kamar perawatan nyaman, dan unit penunjang terpadu.
                        </p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-gray-100 hover:border-emerald-200 transition-all hover:shadow-md group">
                        <div class="w-12 h-12 rounded-2xl bg-[#0e7c47] text-white flex items-center justify-center text-xl font-bold mb-4 shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-hand-holding-heart text-yellow-300"></i>
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-base mb-1">Terpercaya</h4>
                        <p class="text-xs text-gray-500 font-medium leading-relaxed">
                            Pelayanan yang berpusat pada keselamatan pasien dengan mengedepankan nilai-nilai kedokteran Islami.
                        </p>
                    </div>
                </div>

            </div>
        </div>


    </div>


</section>
@endsection
