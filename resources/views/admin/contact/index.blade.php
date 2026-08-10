@extends('layouts.admin')

@section('title', 'Manajemen Informasi Kontak')

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
            <h2 class="text-xl font-black text-slate-900">Kelola Informasi Kontak & Peta Lokasi</h2>
            <p class="text-xs text-gray-500 mt-1">Perbarui nomor telepon, nomor IGD, WhatsApp, email, dan embed Google Maps.</p>
        </div>

        <form action="{{ route('admin.contact.update') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">Nomor Telepon CS</label>
                    <input type="text" name="phone" value="{{ old('phone', $profile?->phone) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">Telepon Darurat IGD 24 Jam</label>
                    <input type="text" name="emergency_phone" value="{{ old('emergency_phone', $profile?->emergency_phone) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">WhatsApp Customer Support</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $profile?->whatsapp) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">Email Informasi</label>
                    <input type="email" name="email" value="{{ old('email', $profile?->email) }}" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">Alamat Lengkap RS</label>
                <textarea name="address" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-[#0e7c47] outline-none">{{ old('address', $profile?->address) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-extrabold text-gray-700 uppercase tracking-wider mb-2">Embed Code Google Maps (&lt;iframe ...&gt;)</label>
                <textarea name="maps_embed" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-xs font-mono focus:ring-2 focus:ring-[#0e7c47] outline-none">{{ old('maps_embed', $profile?->maps_embed) }}</textarea>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0e7c47] hover:bg-[#096237] text-white font-bold text-xs uppercase tracking-wider shadow-md transition-all">
                    Simpan Perubahan Kontak
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
