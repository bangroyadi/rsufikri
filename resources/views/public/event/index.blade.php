@extends('layouts.app')

@section('title', 'Agenda & Event Kesehatan - RSU Fikri Medika')

@section('content')
<div x-data="{ 
    selectedCategory: 'all',
    statusFilter: 'all',
    search: '{{ addslashes($query ?? '') }}'
}" class="bg-slate-50 min-h-screen">

    <!-- MAIN CONTAINER -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 space-y-8">

        <!-- TITLE & HEADER SECTION -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-gray-100 space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-[#0e7c47] text-xs font-black uppercase tracking-wider">
                <i class="fa-solid fa-calendar-check text-[#0e7c47]"></i>
                <span>Agenda & Kegiatan Edukasi Medis</span>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                Event, Seminar Medis & Bakti Sosial Rumah Sakit
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal max-w-3xl">
                Komitmen RSU Fikri Medika dalam mengedukasi masyarakat, meningkatkan kapasitas klinis tenaga medis, serta berbagi kepedulian melalui program bakti sosial dan seminar kesehatan terkini.
            </p>
        </div>

        <!-- FEATURED / SPOTLIGHT EVENT (IF EXISTS) -->
        @if($featuredEvent)
        @php
            $fTitle = $featuredEvent->tr('title');
            $fShortDesc = $featuredEvent->tr('short_description');
            $fDesc = $featuredEvent->tr('description');
            $fSpeakers = is_array($featuredEvent->speakers) ? $featuredEvent->speakers : [];
            $fBenefits = is_array($featuredEvent->benefits) ? $featuredEvent->benefits : [];
            $fWaText = urlencode("Halo RSU Fikri Medika, saya ingin mendaftar untuk agenda Spotlight: " . $fTitle);
        @endphp
        <div class="relative bg-white rounded-3xl shadow-xs hover:shadow-md border border-gray-100 overflow-hidden transition-all duration-300">
            <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">
                
                <!-- IMAGE BANNER (5 COLS) -->
                <div class="lg:col-span-5 relative bg-slate-900 min-h-[260px] sm:min-h-[340px] overflow-hidden">
                    <img src="{{ $featuredEvent->image_url }}" alt="{{ $fTitle }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                    
                    <!-- FEATURED BADGE -->
                    <div class="absolute top-4 left-4 px-3 py-1 rounded-full bg-amber-400 text-slate-950 font-black text-xs shadow-xs uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-star text-amber-900"></i>
                        <span>Spotlight Agenda</span>
                    </div>

                    <!-- DATE BADGE -->
                    <div class="absolute bottom-4 left-4 right-4 p-3 rounded-2xl bg-slate-900/90 backdrop-blur-md border border-white/10 text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-black flex flex-col items-center justify-center text-xs leading-none shadow-xs">
                                <span>{{ $featuredEvent->event_date_short['day'] }}</span>
                                <span class="text-[9px] font-semibold uppercase">{{ $featuredEvent->event_date_short['month'] }}</span>
                            </div>
                            <div>
                                <div class="text-xs font-bold">{{ $featuredEvent->event_date_formatted }}</div>
                                <div class="text-[11px] text-emerald-300 flex items-center gap-1">
                                    <i class="fa-regular fa-clock text-[10px]"></i>
                                    <span>{{ $featuredEvent->start_time ?: '08:30 WIB' }} - {{ $featuredEvent->end_time ?: 'Selesai' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTENT (7 COLS) -->
                <div class="lg:col-span-7 p-6 sm:p-8 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 rounded-lg bg-emerald-50 text-[#0e7c47] font-black text-xs uppercase tracking-wider border border-emerald-100">
                                {{ $featuredEvent->category }}
                            </span>
                            <span class="px-3 py-1 rounded-lg bg-slate-50 text-slate-700 font-bold text-xs border border-gray-100 flex items-center gap-1">
                                <i class="fa-solid fa-ticket text-emerald-600"></i>
                                <span>{{ $featuredEvent->price_type ?: 'Gratis' }}</span>
                            </span>
                            @if($featuredEvent->quota)
                            <span class="px-3 py-1 rounded-lg bg-slate-50 text-slate-700 font-bold text-xs border border-gray-100 flex items-center gap-1">
                                <i class="fa-solid fa-users text-blue-600"></i>
                                <span>Kuota: {{ $featuredEvent->quota }}</span>
                            </span>
                            @endif
                        </div>

                        <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-snug">
                            {{ $fTitle }}
                        </h2>

                        @if($fShortDesc)
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            {{ $fShortDesc }}
                        </p>
                        @endif

                        <!-- SPEAKERS -->
                        @if(!empty($fSpeakers))
                        <div class="pt-2 border-t border-gray-100 space-y-2">
                            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                                <i class="fa-solid fa-user-doctor text-[#0e7c47]"></i>
                                <span>Narasumber / Dokter Pembicara:</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach($fSpeakers as $speaker)
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-gray-100 flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-[#0e7c47] flex items-center justify-center font-bold text-xs shrink-0">
                                        <i class="fa-solid fa-stethoscope"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-xs text-slate-900 truncate">{{ $speaker['name'] ?? '' }}</div>
                                        <div class="text-[10px] text-slate-500 truncate">{{ $speaker['role'] ?? '' }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- LOCATION -->
                        <div class="text-xs font-semibold text-slate-700 flex items-start gap-2 pt-1">
                            <i class="fa-solid fa-location-dot text-red-500 text-sm mt-0.5 shrink-0"></i>
                            <span>{{ $featuredEvent->location }}</span>
                        </div>
                    </div>

                    <!-- CTA ROW -->
                    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <!-- BENEFITS LIST -->
                        @if(!empty($fBenefits))
                        <div class="flex flex-wrap items-center gap-1.5">
                            @foreach(array_slice($fBenefits, 0, 3) as $ben)
                            <span class="px-2.5 py-1 rounded-md bg-emerald-50 text-[#0e7c47] text-[11px] font-bold border border-emerald-100 flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-xs"></i>
                                <span>{{ $ben }}</span>
                            </span>
                            @endforeach
                        </div>
                        @endif

                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $featuredEvent->whatsapp_contact ?: '089678211575') }}?text={{ $fWaText }}" 
                           target="_blank" 
                           style="background-color: #0e7c47; color: #ffffff;"
                           class="w-full sm:w-auto px-6 py-3 rounded-2xl font-black text-xs shadow-xs hover:bg-[#096237] transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-95 shrink-0">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>Daftar / Reservasi Kursi</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
        @endif

        <!-- FILTER & SEARCH BAR -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl shadow-xs border border-gray-100 space-y-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                
                <!-- CATEGORY PILLS -->
                <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-1 md:pb-0">
                    <button type="button" 
                            @click="selectedCategory = 'all'" 
                            :class="selectedCategory === 'all' ? 'bg-[#0e7c47] text-white shadow-xs' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-gray-100'"
                            class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap flex items-center gap-1.5">
                        <i class="fa-solid fa-layer-group text-xs"></i>
                        <span>Semua Kategori ({{ $events->count() }})</span>
                    </button>

                    @foreach($categories as $cat)
                    <button type="button" 
                            @click="selectedCategory = '{{ addslashes($cat) }}'" 
                            :class="selectedCategory === '{{ addslashes($cat) }}' ? 'bg-[#0e7c47] text-white shadow-xs' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-gray-100'"
                            class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all cursor-pointer whitespace-nowrap">
                        {{ $cat }}
                    </button>
                    @endforeach
                </div>

                <!-- SEARCH INPUT -->
                <div class="relative w-full md:w-72 shrink-0">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" 
                           x-model="search" 
                           placeholder="Cari judul event, dokter..." 
                           class="w-full pl-9 pr-4 py-2 text-xs rounded-xl bg-slate-50 border border-gray-200/70 focus:outline-none focus:border-[#0e7c47] focus:bg-white transition-all">
                </div>

            </div>
        </div>

        <!-- EVENTS GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($events as $event)
            @php
                $eTitle = $event->tr('title');
                $eShortDesc = $event->tr('short_description');
                $eSpeakers = is_array($event->speakers) ? $event->speakers : [];
                $eBenefits = is_array($event->benefits) ? $event->benefits : [];
                $eWaText = urlencode("Halo RSU Fikri Medika, saya ingin mendaftar / bertanya mengenai agenda: " . $eTitle);
            @endphp
            <div x-show="(selectedCategory === 'all' || selectedCategory === '{{ addslashes($event->category) }}') && (search === '' || '{{ addslashes(strtolower($eTitle . ' ' . $eShortDesc . ' ' . $event->location . ' ' . $event->category)) }}'.includes(search.toLowerCase()))" 
                 class="bg-white rounded-3xl overflow-hidden shadow-xs hover:shadow-lg border border-gray-100 hover:border-emerald-200 transition-all duration-300 flex flex-col group hover:-translate-y-1">
                
                <!-- EVENT IMAGE / POSTER -->
                <div class="relative w-full aspect-16/10 bg-slate-900 overflow-hidden">
                    <img src="{{ $event->image_url }}" alt="{{ $eTitle }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>

                    <!-- DATE BADGE ON TOP LEFT -->
                    <div class="absolute top-3 left-3 px-3 py-1 rounded-xl bg-slate-900/90 backdrop-blur-sm text-white border border-white/15 shadow-xs flex items-center gap-2 text-xs font-extrabold">
                        <div class="text-emerald-400 font-black">{{ $event->event_date_short['day'] }} {{ $event->event_date_short['month'] }}</div>
                        <span class="text-white/60">|</span>
                        <div class="text-[11px] text-white/90 font-medium">{{ $event->start_time ?: '08:30' }}</div>
                    </div>

                    <!-- STATUS BADGE ON TOP RIGHT -->
                    <div class="absolute top-3 right-3">
                        @if($event->status === 'ongoing')
                        <span class="px-2.5 py-0.5 rounded-full bg-red-600 text-white font-black text-[10px] shadow-xs uppercase tracking-wider animate-pulse">
                            🔴 Live
                        </span>
                        @elseif($event->status === 'completed')
                        <span class="px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 font-black text-[10px] shadow-xs uppercase tracking-wider">
                            ⚪ Selesai
                        </span>
                        @else
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-600 text-white font-black text-[10px] shadow-xs uppercase tracking-wider">
                            🟢 Akan Datang
                        </span>
                        @endif
                    </div>

                    <!-- LOCATION IN OVERLAY -->
                    <div class="absolute bottom-2.5 left-3 right-3 text-[11px] text-white font-semibold flex items-center gap-1.5 truncate">
                        <i class="fa-solid fa-location-dot text-emerald-400 shrink-0"></i>
                        <span class="truncate">{{ $event->location }}</span>
                    </div>
                </div>

                <!-- CARD BODY -->
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    
                    <div class="space-y-3">
                        <!-- CATEGORY & PRICE TYPE -->
                        <div class="flex items-center justify-between text-[11px] font-bold">
                            <span class="px-2.5 py-0.5 rounded-lg bg-emerald-50 text-[#0e7c47] border border-emerald-100 uppercase tracking-wider">
                                {{ $event->category }}
                            </span>
                            <span class="text-slate-600 font-extrabold">
                                {{ $event->price_type ?: 'Gratis / Free' }}
                            </span>
                        </div>

                        <!-- TITLE -->
                        <h3 class="font-black text-slate-900 text-base leading-snug group-hover:text-[#0e7c47] transition-colors line-clamp-2">
                            {{ $eTitle }}
                        </h3>

                        <!-- SHORT DESCRIPTION -->
                        @if($eShortDesc)
                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed font-normal">
                            {{ $eShortDesc }}
                        </p>
                        @endif

                        <!-- SPEAKERS -->
                        @if(!empty($eSpeakers))
                        <div class="pt-2 border-t border-gray-100 space-y-1">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Narasumber:</div>
                            @foreach(array_slice($eSpeakers, 0, 2) as $spk)
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-800">
                                <i class="fa-solid fa-user-doctor text-[#0e7c47] text-xs shrink-0"></i>
                                <span class="truncate">{{ $spk['name'] ?? '' }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- BENEFITS PILLS -->
                        @if(!empty($eBenefits))
                        <div class="pt-2 border-t border-gray-100 space-y-1">
                            @foreach(array_slice($eBenefits, 0, 2) as $ben)
                            <div class="flex items-start gap-1.5 text-xs font-semibold text-slate-700">
                                <i class="fa-solid fa-circle-check text-emerald-600 text-xs mt-0.5 shrink-0"></i>
                                <span class="line-clamp-1">{{ $ben }}</span>
                            </div>
                            @endforeach
                            @if(count($eBenefits) > 2)
                            <div class="text-[10px] font-bold text-[#0e7c47] pt-0.5">
                                + {{ count($eBenefits) - 2 }} fasilitas lainnya
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>

                    <!-- ACTION BUTTON -->
                    <div class="pt-4 border-t border-gray-100 space-y-2">
                        <div class="flex items-center justify-between text-[11px] text-slate-500 font-semibold">
                            <span>Kuota: <strong>{{ $event->quota ?: 'Terbuka' }}</strong></span>
                            <span>{{ $event->event_date_formatted }}</span>
                        </div>

                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $event->whatsapp_contact ?: '089678211575') }}?text={{ $eWaText }}" 
                           target="_blank" 
                           style="background-color: #0e7c47; color: #ffffff;"
                           class="w-full py-2.5 rounded-xl font-extrabold text-xs shadow-xs hover:bg-[#096237] transition-all flex items-center justify-center gap-1.5 active:scale-95 cursor-pointer">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                            <span>Daftar / Reservasi Event</span>
                        </a>
                    </div>

                </div>
            </div>
            @empty
            <div class="col-span-full bg-white p-12 rounded-3xl border border-gray-100 text-center space-y-3 shadow-xs">
                <i class="fa-solid fa-calendar-xmark text-4xl text-slate-300"></i>
                <h3 class="font-black text-slate-800 text-lg">Belum Ada Agenda Event yang Sesuai</h3>
                <p class="text-xs text-slate-500">Silakan pilih kategori lain atau hubungi panitia untuk informasi kegiatan mendatang.</p>
            </div>
            @endforelse
        </div>

        <!-- CORPORATE & COMMUNITY HEALTH EDUCATION COLLABORATION SECTION -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xs border border-gray-100 space-y-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6">
                <div>
                    <span class="text-xs font-extrabold text-[#0e7c47] uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-handshake-angle"></i>
                        <span>Kemitraan Edukasi & Bakti Sosial</span>
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-1">Kerjasama Seminar Kesehatan & Health Talk Instansi</h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-0.5">Ingin menyelenggarakan Health Talk, pelatihan P3K / BLS untuk tim K3 perusahaan, atau skrining kesehatan di instansi/komunitas Anda bersama dokter spesialis RSU Fikri Medika? Hubungi tim Marketing kami:</p>
                </div>
            </div>

            <!-- MARKETING TEAM CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <a href="https://wa.me/6281316720656?text=Halo%20Ibu%20Ulfah%20(Marketing%20RSU%20Fikri%20Medika),%20kami%20ingin%20mengajukan%20kerjasama%20seminar%20kesehatan%20/%20event" target="_blank" class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group shadow-2xs">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm group-hover:text-[#0e7c47] transition-colors">Ibu Ulfah</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">0813-1672-0656</div>
                    </div>
                </a>

                <a href="https://wa.me/6281384656298?text=Halo%20Ibu%20Ai%20(Marketing%20RSU%20Fikri%20Medika),%20kami%20ingin%20mengajukan%20kerjasama%20seminar%20kesehatan%20/%20event" target="_blank" class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group shadow-2xs">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm group-hover:text-[#0e7c47] transition-colors">Ibu Ai</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">0813-8465-6298</div>
                    </div>
                </a>

                <a href="https://wa.me/628988965646?text=Halo%20Ibu%20Rina%20(Marketing%20RSU%20Fikri%20Medika),%20kami%20ingin%20mengajukan%20kerjasama%20seminar%20kesehatan%20/%20event" target="_blank" class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group shadow-2xs">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm group-hover:text-[#0e7c47] transition-colors">Ibu Rina</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">0898-8965-646</div>
                    </div>
                </a>

                <a href="https://wa.me/6281382895002?text=Halo%20Ibu%20Itje%20(Marketing%20RSU%20Fikri%20Medika),%20kami%20ingin%20mengajukan%20kerjasama%20seminar%20kesehatan%20/%20event" target="_blank" class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-gray-100 hover:border-emerald-200 transition-all duration-200 flex items-center gap-3.5 group shadow-2xs">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-[#0e7c47] group-hover:bg-[#0e7c47] group-hover:text-white transition-colors flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm group-hover:text-[#0e7c47] transition-colors">Ibu Itje</div>
                        <div class="text-xs text-slate-500 font-mono mt-0.5">0813-8289-5002</div>
                    </div>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
