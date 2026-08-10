<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Administrator - RSU Fikri Medika</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-[#0e7c47] via-[#096237] to-[#0e7c47] min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border border-emerald-100 p-8 sm:p-10 space-y-6">
        
        <!-- HEADER WITH OFFICIAL LOGO -->
        <div class="text-center space-y-3">
            <img src="{{ asset('logodasboard.png') }}" 
                 alt="RSU Fikri Medika Logo" 
                 class="h-16 mx-auto w-auto object-contain">
            <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Login Panel Administrator</p>
        </div>

        <!-- ERROR ALERT -->
        @if ($errors->any())
            <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-semibold space-y-1">
                @foreach ($errors->all() as $error)
                    <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- LOGIN FORM -->
        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Email Administrator</label>
                <div class="relative">
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder="admin@rsufikrimedika.com" 
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] focus:border-[#0e7c47] outline-none">
                    <i class="fa-regular fa-envelope absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Password</label>
                <div class="relative">
                    <input type="password" 
                           name="password" 
                           required 
                           placeholder="••••••••" 
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] focus:border-[#0e7c47] outline-none">
                    <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-gray-400 text-sm"></i>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs text-gray-600">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#0e7c47] focus:ring-[#0e7c47]">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white font-bold text-sm shadow-lg shadow-emerald-900/30 transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span>Masuk Ke Dashboard</span>
            </button>
        </form>

        <div class="text-center pt-4 border-t border-gray-100 text-xs text-gray-400">
            &copy; {{ date('Y') }} RSU Fikri Medika Administrator.
        </div>

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
