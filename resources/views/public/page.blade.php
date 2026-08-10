@extends('layouts.app')

@section('content')


<!-- MAIN CONTENT CONTAINER -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- LEFT MAIN DETAILS -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 pb-4 mb-6 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-[#0e7c47]/10 text-[#0e7c47] flex items-center justify-center text-xl font-bold">
                        <i class="fa-solid {{ $category === 'Layanan' ? 'fa-user-nurse' : 'fa-circle-info' }}"></i>
                    </div>
                    <div>
                        <span class="text-xs uppercase tracking-wider text-[#0e7c47] font-bold">{{ $category }} RSU Fikri Medika</span>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $title }}</h2>
                    </div>
                </div>

                <div class="prose max-w-none text-gray-600 leading-relaxed space-y-4 text-sm sm:text-base">
                    <p>
                        Selamat datang di halaman resmi <strong>{{ $title }}</strong> RSU Fikri Medika Karawang. 
                        Kami berkomitmen untuk memberikan pelayanan terbaik, tercepat, dan berstandar medis tinggi dengan mengedepankan empati dan prinsip-prinsip Islami.
                    </p>
                    <p>
                        Fasilitas dan layanan kami terus ditunjang oleh dokter spesialis berpengalaman, perawat profesional, serta peralatan medis canggih 24 jam untuk menjamin kenyamanan dan keselamatan pasien.
                    </p>
                </div>

                <!-- CARDS GRID DUMMY SAMPLE DETAILS FOR THE SLUG -->
                <div class="mt-8 pt-6 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-emerald-50/50 border border-emerald-100 flex items-start gap-3">
                        <i class="fa-solid fa-clock text-[#0e7c47] text-lg mt-0.5"></i>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">{{ __('Operasional') }}</h4>
                            <p class="text-xs text-gray-600 mt-0.5">Siaga 24 Jam / 7 Hari Seminggu</p>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl bg-emerald-50/50 border border-emerald-100 flex items-start gap-3">
                        <i class="fa-solid fa-[#0e7c47] fa-headset text-[#0e7c47] text-lg mt-0.5"></i>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm">{{ __('Pendaftaran & Info') }}</h4>
                            <p class="text-xs text-gray-600 mt-0.5">(0267) 8454123 / WA: 0812-3456-7890</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA BANNER -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-6 sm:p-8 text-white shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg sm:text-xl font-bold">{{ __('Butuh Bantuan & Konsultasi Medis?') }}</h3>
                    <p class="text-xs sm:text-sm text-red-100 mt-1">{{ __('Hubungi Call Center Emergency atau Pendaftaran Poliklinik RSU Fikri Medika.') }}</p>
                </div>
                <a href="https://wa.me/6281234567890" target="_blank" class="px-5 py-3 rounded-xl bg-yellow-400 text-gray-900 font-bold text-xs sm:text-sm hover:bg-yellow-300 transition-colors shadow flex items-center gap-2 shrink-0">
                    <i class="fa-brands fa-whatsapp text-base"></i>
                    <span>Hubungi Whatsapp</span>
                </a>
            </div>
        </div>

        <!-- RIGHT SIDEBAR MENU -->
        <div class="space-y-6">
            <!-- LAYANAN LAINNYA / INFORMASI LAINNYA MENU -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-base font-bold text-gray-900 pb-3 border-b border-gray-100 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-list text-[#0e7c47]"></i>
                    <span>{{ $category }} {{ __('Lainnya') }}</span>
                </h3>

                @if($category === 'Layanan')
                <div class="space-y-2 text-sm font-semibold">
                    <a href="{{ url('/layanan/igd') }}" class="block px-4 py-2.5 rounded-xl transition-colors {{ $slug === 'igd' ? 'bg-[#0e7c47] text-white' : 'bg-gray-50 text-gray-700 hover:bg-emerald-50 hover:text-[#0e7c47]' }}">
                        IGD (24 Jam)
                    </a>
                    <a href="{{ url('/layanan/rawat-jalan') }}" class="block px-4 py-2.5 rounded-xl transition-colors {{ $slug === 'rawat-jalan' ? 'bg-[#0e7c47] text-white' : 'bg-gray-50 text-gray-700 hover:bg-emerald-50 hover:text-[#0e7c47]' }}">
                        Instalasi Rawat Jalan
                    </a>
                    <a href="{{ url('/layanan/rawat-inap') }}" class="block px-4 py-2.5 rounded-xl transition-colors {{ $slug === 'rawat-inap' ? 'bg-[#0e7c47] text-white' : 'bg-gray-50 text-gray-700 hover:bg-emerald-50 hover:text-[#0e7c47]' }}">
                        Instalasi Rawat Inap
                    </a>
                    <a href="{{ url('/layanan/penunjang-medik') }}" class="block px-4 py-2.5 rounded-xl transition-colors {{ $slug === 'penunjang-medik' ? 'bg-[#0e7c47] text-white' : 'bg-gray-50 text-gray-700 hover:bg-emerald-50 hover:text-[#0e7c47]' }}">
                        Penunjang Medik
                    </a>
                    <a href="{{ url('/layanan/unggulan') }}" class="block px-4 py-2.5 rounded-xl transition-colors {{ $slug === 'unggulan' ? 'bg-[#0e7c47] text-white' : 'bg-gray-50 text-gray-700 hover:bg-emerald-50 hover:text-[#0e7c47]' }}">
                        Layanan Unggulan
                    </a>
                </div>
                @else
                <div class="space-y-2 text-sm font-semibold">
                    <a href="{{ url('/informasi/artikel-kesehatan') }}" class="block px-4 py-2.5 rounded-xl transition-colors {{ $slug === 'artikel-kesehatan' ? 'bg-[#0e7c47] text-white' : 'bg-gray-50 text-gray-700 hover:bg-emerald-50 hover:text-[#0e7c47]' }}">
                        Artikel Kesehatan
                    </a>
                    <a href="{{ url('/informasi/event') }}" class="block px-4 py-2.5 rounded-xl transition-colors {{ $slug === 'event' ? 'bg-[#0e7c47] text-white' : 'bg-gray-50 text-gray-700 hover:bg-emerald-50 hover:text-[#0e7c47]' }}">
                        Event & Kegiatan
                    </a>
                    <a href="{{ url('/informasi/penawaran-khusus') }}" class="block px-4 py-2.5 rounded-xl transition-colors {{ $slug === 'penawaran-khusus' ? 'bg-[#0e7c47] text-white' : 'bg-gray-50 text-gray-700 hover:bg-emerald-50 hover:text-[#0e7c47]' }}">
                        Penawaran Khusus
                    </a>
                    <a href="{{ url('/informasi/aduan-layanan') }}" class="block px-4 py-2.5 rounded-xl transition-colors {{ $slug === 'aduan-layanan' ? 'bg-[#0e7c47] text-white' : 'bg-gray-50 text-gray-700 hover:bg-emerald-50 hover:text-[#0e7c47]' }}">
                        Aduan Layanan
                    </a>
                    <a href="{{ url('/informasi/ikm') }}" class="block px-4 py-2.5 rounded-xl transition-colors {{ $slug === 'ikm' ? 'bg-[#0e7c47] text-white' : 'bg-gray-50 text-gray-700 hover:bg-emerald-50 hover:text-[#0e7c47]' }}">
                        Indeks Kepuasan Masyarakat
                    </a>
                </div>
                @endif
            </div>
        </div>

    </div>
</section>
@endsection
