@extends('layouts.app')

@section('title', 'Penawaran Khusus & Paket Promo Kesehatan | RSU Fikri Medika Karawang')
@section('meta_description', 'Dapatkan penawaran khusus, diskon pemeriksaan, paket MCU, promo bersalin, dan paket kesehatan hemat di RSU Fikri Medika Karawang.')

@section('schema_jsonld')
<script type="application/ld+json">
{!! json_encode(app(\App\Services\SeoService::class)->generateBreadcrumbSchema([
    'Beranda' => url('/'),
    'Penawaran Khusus & Promo' => url('/informasi/penawaran-khusus')
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('content')
<h1 class="sr-only">Penawaran Khusus & Paket Promo Kesehatan RSU Fikri Medika Karawang</h1>
<div x-data="{ 
    selectedCategory: 'all',
    search: '{{ addslashes($query ?? '') }}'
}" class="bg-slate-50 min-h-screen">

    <!-- MAIN CONTAINER -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8">
        
        <!-- CATEGORY FILTER BAR -->
        <div class="bg-white p-3 sm:p-4 rounded-2xl sm:rounded-3xl shadow-sm border border-slate-200/80 flex items-center justify-between gap-3 overflow-x-auto">
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" 
                        @click="selectedCategory = 'all'" 
                        :class="selectedCategory === 'all' ? 'bg-[#0e7c47] text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap flex items-center gap-1.5">
                    <i class="fa-solid fa-layer-group text-xs"></i>
                    <span>Semua Paket ({{ $promos->count() }})</span>
                </button>

                @foreach($categories as $cat)
                <button type="button" 
                        @click="selectedCategory = '{{ addslashes($cat) }}'" 
                        :class="selectedCategory === '{{ addslashes($cat) }}' ? 'bg-[#0e7c47] text-white shadow-sm' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap">
                    {{ $cat }}
                </button>
                @endforeach
            </div>

            <div class="hidden lg:flex items-center gap-2 text-xs font-extrabold text-slate-500 pr-2 shrink-0">
                <i class="fa-solid fa-shield-halved text-[#0e7c47]"></i>
                <span>RSU Fikri Medika Official Promo</span>
            </div>
        </div>

        <!-- PROMO CARDS GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($promos as $promo)
            @php
                $pTitle = $promo->tr('title');
                $pShortDesc = $promo->tr('short_description');
                $pFeatures = is_array($promo->features) ? $promo->features : [];
                $waText = urlencode("Halo RSU Fikri Medika, saya tertarik dengan " . $pTitle . " dan ingin klaim promo ini.");
            @endphp
            <div x-show="(selectedCategory === 'all' || selectedCategory === '{{ addslashes($promo->category) }}') && (search === '' || '{{ addslashes(strtolower($pTitle . ' ' . $pShortDesc . ' ' . $promo->category)) }}'.includes(search.toLowerCase()))" 
                 class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-200/90 hover:border-emerald-300 transition-all duration-300 flex flex-col group hover:-translate-y-1.5">
                
                <!-- PROMO IMAGE / FLYER -->
                <div class="relative w-full aspect-16/10 bg-slate-900 overflow-hidden">
                    <img src="{{ $promo->image_url }}" alt="{{ $pTitle }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                    <!-- DISCOUNT PERCENTAGE -->
                    @if($promo->discount_percentage)
                    <div class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-yellow-400 text-gray-900 font-black text-xs shadow-md">
                        -{{ $promo->discount_percentage }}%
                    </div>
                    @endif
                </div>

                <!-- CARD BODY -->
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    
                    <div class="space-y-2.5">
                        <!-- CATEGORY & EXPIRATION -->
                        <div class="flex items-center justify-between text-[11px] font-bold">
                            <span class="px-2.5 py-0.5 rounded-lg bg-emerald-50 text-[#0e7c47] border border-emerald-100 uppercase tracking-wider">
                                {{ $promo->category }}
                            </span>
                            <span class="text-slate-500 flex items-center gap-1">
                                <i class="fa-regular fa-clock text-[#0e7c47]"></i>
                                <span>{{ $promo->valid_until_formatted }}</span>
                            </span>
                        </div>

                        <!-- TITLE -->
                        <h3 class="font-black text-slate-900 text-base sm:text-lg leading-snug group-hover:text-[#0e7c47] transition-colors line-clamp-2">
                            {{ $pTitle }}
                        </h3>

                        <!-- SHORT DESCRIPTION -->
                        @if($pShortDesc)
                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-normal">
                            {{ $pShortDesc }}
                        </p>
                        @endif

                        <!-- FEATURES BULLETS -->
                        @if(!empty($pFeatures))
                        <div class="pt-2 border-t border-slate-100 space-y-1.5">
                            @foreach($pFeatures as $feat)
                            <div class="flex items-start gap-2 text-xs font-semibold text-slate-700">
                                <i class="fa-solid fa-circle-check text-[#0e7c47] text-xs mt-0.5 shrink-0"></i>
                                <span>{{ $feat }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- PRICING & ACTION BUTTON -->
                    <div class="pt-4 border-t border-slate-100 space-y-3">
                        <div>
                            @if($promo->original_price)
                            <div class="text-xs text-slate-400 line-through font-semibold">
                                {{ $promo->original_price }}
                            </div>
                            @endif
                            <div class="text-xl font-black text-[#0e7c47]">
                                {{ $promo->promo_price ?: 'Hubungi Marketing' }}
                            </div>
                        </div>

                        <!-- DIRECT CTA BUTTON -->
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $promo->whatsapp_number ?: '089678211575') }}?text={{ $waText }}" 
                           target="_blank" 
                           style="background-color: #0e7c47; color: #ffffff;"
                           class="w-full py-3 rounded-2xl font-extrabold text-xs shadow-xs hover:bg-[#096237] transition-all flex items-center justify-center gap-2 active:scale-95 cursor-pointer">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>Klaim Promo via WhatsApp</span>
                        </a>
                    </div>

                </div>
            </div>
            @empty
            <div class="col-span-full bg-white p-12 rounded-3xl border border-slate-200 text-center space-y-3">
                <i class="fa-solid fa-tag text-4xl text-slate-300"></i>
                <h3 class="font-black text-slate-800 text-lg">Belum Ada Promo yang Sesuai</h3>
                <p class="text-xs text-slate-500">Silakan pilih kategori lain atau hubungi customer care untuk penawaran terkini.</p>
            </div>
            @endforelse
        </div>

        <!-- MARKETING & KEMITRAAN DIRECT SECTION -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-slate-200 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                <div>
                    <span class="text-xs font-extrabold text-red-600 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-bullhorn"></i>
                        <span>Layanan Kerjasama & Konsultasi Promo</span>
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Konsultasi Paket Khusus & Corporate Gathering</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Butuh penawaran paket MCU massal untuk karyawan perusahaan, asuransi, atau komunitas keluarga? Hubungi tim Marketing kami:</p>
                </div>
            </div>

            <!-- MARKETING TEAM CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                <a href="https://wa.me/6281316720656?text=Halo%20Ulfah%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20paket%20promo%20kesehatan" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 hover:border-emerald-300 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Ulfah</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0813-1672-0656</div>
                    </div>
                </a>

                <a href="https://wa.me/6285714285901?text=Halo%20Ken%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20paket%20promo%20kesehatan" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 hover:border-emerald-300 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Ken</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0857-1428-5901</div>
                    </div>
                </a>

                <a href="https://wa.me/6285879121294?text=Halo%20Adel%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20paket%20promo%20kesehatan" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 hover:border-emerald-300 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Adel</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0858-7912-1294</div>
                    </div>
                </a>

                <a href="https://wa.me/6282123872110?text=Halo%20Itje%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20paket%20promo%20kesehatan" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 hover:border-emerald-300 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Itje</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0821-2387-2110</div>
                    </div>
                </a>

                <a href="https://wa.me/628988965646?text=Halo%20Rina%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20paket%20promo%20kesehatan" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 hover:border-emerald-300 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Rina</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0898-8965-646</div>
                    </div>
                </a>

                <a href="https://wa.me/6281384656298?text=Halo%20Ai%20(Marketing%20RSU%20Fikri%20Medika),%20saya%20ingin%20konsultasi%20paket%20promo%20kesehatan" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 hover:border-emerald-300 transition-all duration-200 flex items-center gap-3 group shadow-2xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-base font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="font-extrabold text-slate-900 text-xs group-hover:text-[#0e7c47] transition-colors truncate">Ai</div>
                        <div class="text-[11px] text-slate-500 font-mono mt-0.5 truncate">0813-8465-6298</div>
                    </div>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
