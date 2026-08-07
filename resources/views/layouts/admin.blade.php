<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - RSU Fikri Medika</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 antialiased font-sans flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#0e7c47] text-white flex-shrink-0 flex flex-col justify-between shadow-xl">
        <div>
            <!-- LOGO HEADER -->
            <div class="p-4 border-b border-[#096237] bg-white text-center">
                <img src="{{ asset('logodasboard.png') }}" 
                     alt="RSU Fikri Medika Logo" 
                     class="h-12 mx-auto w-auto object-contain">
                <div class="text-[10px] text-emerald-800 font-bold uppercase tracking-wider mt-1">Admin Panel CMS</div>
            </div>

            <!-- SIDEBAR NAV MENU -->
            <nav class="p-4 space-y-1 text-xs font-semibold text-gray-100">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-[#096237] text-white font-bold shadow-sm">
                    <i class="fa-solid fa-chart-line text-yellow-300 w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#096237]/60 transition-colors">
                    <i class="fa-solid fa-hospital-user w-5 text-emerald-300"></i>
                    <span>Profil Rumah Sakit</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#096237]/60 transition-colors">
                    <i class="fa-solid fa-user-doctor w-5 text-emerald-300"></i>
                    <span>Dokter</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#096237]/60 transition-colors">
                    <i class="fa-regular fa-calendar-check w-5 text-emerald-300"></i>
                    <span>Jadwal Dokter</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#096237]/60 transition-colors">
                    <i class="fa-solid fa-clinic-medical w-5 text-emerald-300"></i>
                    <span>Poli / Departemen</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#096237]/60 transition-colors">
                    <i class="fa-solid fa-briefcase-medical w-5 text-emerald-300"></i>
                    <span>Layanan</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#096237]/60 transition-colors">
                    <i class="fa-regular fa-newspaper w-5 text-emerald-300"></i>
                    <span>Berita</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#096237]/60 transition-colors">
                    <i class="fa-solid fa-file-medical w-5 text-emerald-300"></i>
                    <span>Artikel Kesehatan</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#096237]/60 transition-colors">
                    <i class="fa-solid fa-images w-5 text-emerald-300"></i>
                    <span>Galeri</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#096237]/60 transition-colors">
                    <i class="fa-solid fa-sliders w-5 text-emerald-300"></i>
                    <span>Banner Homepage</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-[#096237]/60 transition-colors">
                    <i class="fa-solid fa-address-book w-5 text-emerald-300"></i>
                    <span>Informasi Kontak</span>
                </a>
            </nav>
        </div>

        <!-- USER LOGOUT FOOTER -->
        <div class="p-4 border-t border-[#096237] bg-[#074728]">
            <div class="flex items-center justify-between">
                <div class="text-xs">
                    <div class="font-bold text-white">{{ Auth::user()?->name ?? 'Admin' }}</div>
                    <div class="text-[10px] text-emerald-200">{{ Auth::user()?->email }}</div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-colors" title="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-grow flex flex-col min-w-0 overflow-y-auto">
        <!-- TOPBAR -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between shadow-sm sticky top-0 z-10">
            <h1 class="text-lg font-bold text-gray-800">
                @yield('title', 'Dashboard Administrator')
            </h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-50 text-[#0e7c47] text-xs font-bold border border-emerald-200 hover:bg-emerald-100 flex items-center gap-1.5">
                    <i class="fa-solid fa-globe"></i> Lihat Website Publik
                </a>
            </div>
        </header>

        <!-- BODY CONTENT -->
        <main class="p-8 flex-grow">
            @yield('content')
        </main>
    </div>

</body>
</html>
