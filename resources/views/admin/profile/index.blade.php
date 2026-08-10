@extends('layouts.admin')

@section('title', 'Manajemen Profil Rumah Sakit')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-[#0e7c47] font-bold text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-sm space-y-6">
        <div class="border-b border-gray-100 pb-4">
            <h2 class="text-xl font-black text-slate-900">Kelola Profil RSU Fikri Medika</h2>
            <p class="text-xs text-gray-500 mt-1">Perbarui nama rumah sakit, nomor telepon darurat, email, dan alamat operasional.</p>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">Nama Rumah Sakit</label>
                    <input type="text" name="name" value="{{ old('name', $profile?->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">Email Resmi</label>
                    <input type="email" name="email" value="{{ old('email', $profile?->email) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">Telepon Informas/CS</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile?->phone) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">Telepon IGD 24 Jam</label>
                    <input type="text" name="emergency_phone" value="{{ old('emergency_phone', $profile?->emergency_phone) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">WhatsApp Pendaftaran</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $profile?->whatsapp) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">Jam Operasional</label>
                    <input type="text" name="operating_hours" value="{{ old('operating_hours', $profile?->operating_hours) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                <textarea name="address" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">{{ old('address', $profile?->address) }}</textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white font-bold text-xs uppercase tracking-wider shadow-md transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
