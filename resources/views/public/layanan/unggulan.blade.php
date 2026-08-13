@extends('layouts.app')

@section('content')

<!-- MAIN CONTENT CONTAINER -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="w-full space-y-8">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                <div class="w-12 h-12 rounded-xl bg-[#0e7c47]/10 text-[#0e7c47] flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-star text-[#0e7c47]"></i>
                </div>
                <div>
                    <span class="text-xs uppercase tracking-wider text-[#0e7c47] font-bold">Fasilitas Utama RS</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Layanan Unggulan RSU Fikri Medika</h2>
                </div>
            </div>

            <p class="text-gray-600 text-sm leading-relaxed">
                RSU Fikri Medika Karawang menyediakan berbagai fasilitas layanan unggulan yang didukung oleh dokter spesialis berpengalaman, perawat profesional, serta peralatan medis canggih 24 jam untuk memberikan pelayanan kesehatan terbaik, cepat, dan terpercaya bagi Anda dan keluarga.
            </p>

            <!-- GRID OF ALL SERVICES MANAGED IN ADMIN (3 COLUMNS FULL WIDTH) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pt-2">
                @foreach($services as $serv)
                @php
                    $sName = $serv->tr('name');
                    $sSlug = $serv->slug ?: \Illuminate\Support\Str::slug($sName);
                    $sImg = !empty($serv->image) ? (\Illuminate\Support\Str::startsWith($serv->image, ['http://', 'https://']) ? $serv->image : asset($serv->image)) : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=600&q=80';
                @endphp
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 transition-all duration-300 flex flex-col group border border-slate-100">
                    <div class="relative h-48 overflow-hidden bg-gray-100">
                        <img src="{{ $sImg }}" 
                             alt="{{ $sName }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy"
                             decoding="async">
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded-full bg-[#0e7c47] text-yellow-300 text-[10px] font-bold shadow-md">
                                Unggulan
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-base font-bold text-[#0e7c47] group-hover:text-[#096237] transition-colors mb-2">
                                {{ $sName }}
                            </h3>
                            <p class="text-gray-600 text-xs leading-relaxed mb-4 line-clamp-3">
                                {{ $serv->tr('short_description') }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-[11px] font-semibold text-emerald-700 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i> Buka 24 Jam
                            </span>
                            <a href="{{ url('/layanan/' . $sSlug) }}" class="text-xs font-bold text-[#0e7c47] hover:text-amber-600 flex items-center gap-1">
                                <span>Detail</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- CTA BANNER -->
        <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-6 sm:p-8 text-white shadow-lg flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="text-lg sm:text-xl font-bold">Butuh Bantuan & Konsultasi Medis?</h3>
                <p class="text-xs sm:text-sm text-red-100 mt-1">Hubungi Call Center Emergency atau Pendaftaran Poliklinik RSU Fikri Medika.</p>
            </div>
            <a href="https://wa.me/6281234567890" target="_blank" class="px-5 py-3 rounded-xl bg-yellow-400 text-gray-900 font-bold text-xs sm:text-sm hover:bg-yellow-300 transition-colors shadow flex items-center gap-2 shrink-0">
                <i class="fa-brands fa-whatsapp text-base"></i>
                <span>Hubungi Whatsapp</span>
            </a>
        </div>
    </div>
</section>
@endsection
