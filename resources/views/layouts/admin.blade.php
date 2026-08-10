<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin CMS') - RSU Fikri Medika</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; background-color: #f1f5f9; }
        [x-cloak] { display: none !important; }
        .admin-sidebar { background-color: #062c19 !important; color: #ffffff !important; }
        .admin-sidebar-header { background-color: #ffffff !important; border-bottom: 1px solid #042012 !important; }
        .admin-active-link { background: linear-gradient(135deg, #0e7c47 0%, #096237 100%) !important; color: #ffffff !important; border: 1px solid rgba(255,255,255,0.2) !important; box-shadow: 0 4px 12px rgba(0,0,0,0.25) !important; }
        .admin-inactive-link { color: #a7f3d0 !important; }
        .admin-inactive-link:hover { background-color: rgba(14, 124, 71, 0.4) !important; color: #ffffff !important; }
        .admin-topbar { background-color: #ffffff !important; border-bottom: 1px solid #e2e8f0 !important; }
        .admin-card { background-color: #ffffff !important; border: 1px solid #e2e8f0 !important; border-radius: 1rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased font-sans flex min-h-screen">

    <!-- SIDEBAR -->
    <aside style="background-color: #062c19; color: #ffffff;" class="admin-sidebar w-72 flex-shrink-0 flex flex-col justify-between shadow-2xl z-30 relative border-r border-emerald-950 font-sans">
        <div class="flex flex-col h-full overflow-y-auto">
            
            <!-- BRAND LOGO HEADER -->
            <div style="background-color: #ffffff;" class="p-4 border-b border-emerald-900/40 text-center flex flex-col items-center justify-center gap-1 shadow-xs">
                <img src="{{ asset('logodasboard.png') }}" 
                     alt="RSU Fikri Medika Logo" 
                     class="h-11 w-auto object-contain">
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="mt-1 px-3 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5">
                    <span style="background-color: #10b981;" class="w-2 h-2 rounded-full inline-block animate-pulse"></span>
                    <span>Admin CMS Control</span>
                </div>
            </div>

            <!-- NAVIGATION GROUPS -->
            <nav class="p-4 space-y-5 text-xs font-semibold">
                
                <!-- GROUP 1: UTAMA -->
                <div>
                    <div style="color: #6ee7b7;" class="px-3 text-[10px] font-black uppercase tracking-widest mb-2 flex items-center justify-between">
                        <span>UTAMA</span>
                        <span style="background-color: rgba(255,255,255,0.1);" class="h-px flex-grow ml-2"></span>
                    </div>

                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" 
                           @if(request()->routeIs('admin.dashboard'))
                           style="background: linear-gradient(135deg, #0e7c47 0%, #096237 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.25);"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold shadow-md"
                           @else
                           style="color: #d1fae5;"
                           class="admin-inactive-link flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all"
                           @endif>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-chart-pie text-sm w-5 {{ request()->routeIs('admin.dashboard') ? 'text-yellow-300' : 'text-emerald-400' }}"></i>
                                <span>Dashboard Summary</span>
                            </div>
                            @if(request()->routeIs('admin.dashboard'))
                            <span style="background-color: #fde047;" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                            @endif
                        </a>

                        <a href="{{ route('admin.profile.index') }}" 
                           @if(request()->routeIs('admin.profile.*'))
                           style="background: linear-gradient(135deg, #0e7c47 0%, #096237 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.25);"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold shadow-md"
                           @else
                           style="color: #d1fae5;"
                           class="admin-inactive-link flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all"
                           @endif>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-hospital text-sm w-5 {{ request()->routeIs('admin.profile.*') ? 'text-yellow-300' : 'text-emerald-400' }}"></i>
                                <span>Profil Rumah Sakit</span>
                            </div>
                            @if(request()->routeIs('admin.profile.*'))
                            <span style="background-color: #fde047;" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                            @endif
                        </a>

                        <a href="{{ route('admin.contact.index') }}" 
                           @if(request()->routeIs('admin.contact.*'))
                           style="background: linear-gradient(135deg, #0e7c47 0%, #096237 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.25);"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold shadow-md"
                           @else
                           style="color: #d1fae5;"
                           class="admin-inactive-link flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all"
                           @endif>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-address-book text-sm w-5 {{ request()->routeIs('admin.contact.*') ? 'text-yellow-300' : 'text-emerald-400' }}"></i>
                                <span>Informasi Kontak</span>
                            </div>
                            @if(request()->routeIs('admin.contact.*'))
                            <span style="background-color: #fde047;" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- GROUP 2: LAYANAN MEDIS -->
                <div>
                    <div style="color: #6ee7b7;" class="px-3 text-[10px] font-black uppercase tracking-widest mb-2 flex items-center justify-between">
                        <span>LAYANAN MEDIS</span>
                        <span style="background-color: rgba(255,255,255,0.1);" class="h-px flex-grow ml-2"></span>
                    </div>

                    <div class="space-y-1">
                        <a href="{{ route('admin.doctors.index') }}" 
                           @if(request()->routeIs('admin.doctors.*'))
                           style="background: linear-gradient(135deg, #0e7c47 0%, #096237 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.25);"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold shadow-md"
                           @else
                           style="color: #d1fae5;"
                           class="admin-inactive-link flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all"
                           @endif>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-user-doctor text-sm w-5 {{ request()->routeIs('admin.doctors.*') ? 'text-yellow-300' : 'text-emerald-400' }}"></i>
                                <span>Dokter Spesialis</span>
                            </div>
                            @if(request()->routeIs('admin.doctors.*'))
                            <span style="background-color: #fde047;" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                            @endif
                        </a>

                        <a href="{{ route('admin.schedules.index') }}" 
                           @if(request()->routeIs('admin.schedules.*'))
                           style="background: linear-gradient(135deg, #0e7c47 0%, #096237 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.25);"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold shadow-md"
                           @else
                           style="color: #d1fae5;"
                           class="admin-inactive-link flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all"
                           @endif>
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-calendar-check text-sm w-5 {{ request()->routeIs('admin.schedules.*') ? 'text-yellow-300' : 'text-emerald-400' }}"></i>
                                <span>Jadwal Dokter</span>
                            </div>
                            @if(request()->routeIs('admin.schedules.*'))
                            <span style="background-color: #fde047;" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                            @endif
                        </a>

                        <a href="{{ route('admin.polyclinics.index') }}" 
                           @if(request()->routeIs('admin.polyclinics.*'))
                           style="background: linear-gradient(135deg, #0e7c47 0%, #096237 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.25);"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold shadow-md"
                           @else
                           style="color: #d1fae5;"
                           class="admin-inactive-link flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all"
                           @endif>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-clinic-medical text-sm w-5 {{ request()->routeIs('admin.polyclinics.*') ? 'text-yellow-300' : 'text-emerald-400' }}"></i>
                                <span>Poli / Departemen</span>
                            </div>
                            @if(request()->routeIs('admin.polyclinics.*'))
                            <span style="background-color: #fde047;" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                            @endif
                        </a>

                        <a href="{{ route('admin.services.index') }}" 
                           @if(request()->routeIs('admin.services.*'))
                           style="background: linear-gradient(135deg, #0e7c47 0%, #096237 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.25);"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold shadow-md"
                           @else
                           style="color: #d1fae5;"
                           class="admin-inactive-link flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all"
                           @endif>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-briefcase-medical text-sm w-5 {{ request()->routeIs('admin.services.*') ? 'text-yellow-300' : 'text-emerald-400' }}"></i>
                                <span>Fasilitas & Layanan</span>
                            </div>
                            @if(request()->routeIs('admin.services.*'))
                            <span style="background-color: #fde047;" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- GROUP 3: MEDIA & PUBLIKASI -->
                <div>
                    <div style="color: #6ee7b7;" class="px-3 text-[10px] font-black uppercase tracking-widest mb-2 flex items-center justify-between">
                        <span>MEDIA & PUBLIKASI</span>
                        <span style="background-color: rgba(255,255,255,0.1);" class="h-px flex-grow ml-2"></span>
                    </div>

                    <div class="space-y-1">
                        <a href="{{ route('admin.news.index') }}" 
                           @if(request()->routeIs('admin.news.*'))
                           style="background: linear-gradient(135deg, #0e7c47 0%, #096237 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.25);"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold shadow-md"
                           @else
                           style="color: #d1fae5;"
                           class="admin-inactive-link flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all"
                           @endif>
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-newspaper text-sm w-5 {{ request()->routeIs('admin.news.*') ? 'text-yellow-300' : 'text-emerald-400' }}"></i>
                                <span>Berita RS</span>
                            </div>
                            @if(request()->routeIs('admin.news.*'))
                            <span style="background-color: #fde047;" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                            @endif
                        </a>

                        <a href="{{ route('admin.articles.index') }}" 
                           @if(request()->routeIs('admin.articles.*'))
                           style="background: linear-gradient(135deg, #0e7c47 0%, #096237 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.25);"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold shadow-md"
                           @else
                           style="color: #d1fae5;"
                           class="admin-inactive-link flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all"
                           @endif>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-file-medical text-sm w-5 {{ request()->routeIs('admin.articles.*') ? 'text-yellow-300' : 'text-emerald-400' }}"></i>
                                <span>Artikel Kesehatan</span>
                            </div>
                            @if(request()->routeIs('admin.articles.*'))
                            <span style="background-color: #fde047;" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                            @endif
                        </a>

                        <a href="{{ route('admin.galleries.index') }}" 
                           @if(request()->routeIs('admin.galleries.*'))
                           style="background: linear-gradient(135deg, #0e7c47 0%, #096237 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.25);"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold shadow-md"
                           @else
                           style="color: #d1fae5;"
                           class="admin-inactive-link flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all"
                           @endif>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-images text-sm w-5 {{ request()->routeIs('admin.galleries.*') ? 'text-yellow-300' : 'text-emerald-400' }}"></i>
                                <span>Galeri Foto</span>
                            </div>
                            @if(request()->routeIs('admin.galleries.*'))
                            <span style="background-color: #fde047;" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                            @endif
                        </a>

                        <a href="{{ route('admin.banners.index') }}" 
                           @if(request()->routeIs('admin.banners.*'))
                           style="background: linear-gradient(135deg, #0e7c47 0%, #096237 100%); color: #ffffff; border: 1px solid rgba(255,255,255,0.25);"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-bold shadow-md"
                           @else
                           style="color: #d1fae5;"
                           class="admin-inactive-link flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all"
                           @endif>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-sliders text-sm w-5 {{ request()->routeIs('admin.banners.*') ? 'text-yellow-300' : 'text-emerald-400' }}"></i>
                                <span>Banner Homepage</span>
                            </div>
                            @if(request()->routeIs('admin.banners.*'))
                            <span style="background-color: #fde047;" class="w-1.5 h-1.5 rounded-full inline-block"></span>
                            @endif
                        </a>
                    </div>
                </div>

            </nav>
        </div>

        <!-- USER ACCOUNT FOOTER CARD -->
        <div style="background-color: #042012; border-top: 1px solid #0c4a2a;" class="p-4 shrink-0">
            <div class="flex items-center gap-3">
                <div style="background: linear-gradient(135deg, #fde047 0%, #f59e0b 100%); color: #022c22;" class="w-9 h-9 rounded-xl flex items-center justify-center font-black text-xs shrink-0 shadow-sm">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="min-w-0">
                    <div style="color: #ffffff;" class="font-extrabold text-xs truncate">{{ Auth::user()?->name ?? 'Super Admin' }}</div>
                    <div style="color: #a7f3d0;" class="text-[10px] truncate">{{ Auth::user()?->email }}</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT CONTAINER -->
    <div class="flex-grow flex flex-col min-w-0 overflow-y-auto">
        
        <!-- TOP NAVIGATION BAR -->
        <header style="background-color: #ffffff; border-bottom: 1px solid #e2e8f0;" class="px-8 py-4 flex items-center justify-between shadow-xs sticky top-0 z-20">
            <!-- BREADCRUMBS & PAGE TITLE -->
            <div>
                <div class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-0.5">
                    <i style="color: #0e7c47;" class="fa-solid fa-house text-[11px]"></i>
                    <span>CMS Portal</span>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                    <span style="color: #0e7c47;" class="font-black uppercase tracking-wider text-[11px]">@yield('title', 'Dashboard')</span>
                </div>
                <h1 class="text-xl font-black text-slate-900 tracking-tight">
                    @yield('title', 'Dashboard Administrator')
                </h1>
            </div>

            <!-- TOPBAR RIGHT ACTION BUTTONS -->
            <div class="flex items-center gap-3">
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; color: #475569;" class="hidden sm:flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-bold">
                    <i style="color: #0e7c47;" class="fa-regular fa-clock"></i>
                    <span>{{ date('d M Y') }}</span>
                </div>

                <a href="{{ route('home') }}" target="_blank" style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #0e7c47;" class="px-4 py-2 rounded-xl text-xs font-extrabold hover:bg-emerald-100 hover:shadow-md flex items-center gap-2 transition-all">
                    <i class="fa-solid fa-globe"></i>
                    <span>Lihat Website</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>

                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" style="background-color: #fef2f2; border: 1px solid #fecaca; color: #dc2626;" class="px-4 py-2 rounded-xl text-xs font-extrabold hover:bg-red-100 hover:shadow-md flex items-center gap-2 transition-all cursor-pointer">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- DYNAMIC PAGE BODY -->
        <main class="p-6 sm:p-8 flex-grow">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer style="background-color: #ffffff; border-top: 1px solid #e2e8f0;" class="px-8 py-4 text-center text-xs text-slate-400 font-semibold">
            &copy; {{ date('Y') }} RSU Fikri Medika Administrator Panel.
        </footer>
    </div>

    <script>
        // Force server re-validation when pressing browser Back/Forward buttons
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
