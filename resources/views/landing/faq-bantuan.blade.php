@extends('landing.layouts.app')
@section('title', 'Bantuan / FAQ')

@section('content')
    <main class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-emerald-700 mb-8">Bantuan & Pertanyaan Umum</h1>

        <div class="bg-white p-6 rounded-lg shadow-sm space-y-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Bagaimana cara mengunduh dokumen?</h3>
                <p class="text-gray-700 mt-2">Klik tombol “Unduh” pada halaman detail dokumen yang Anda buka.</p>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Apakah saya harus login?</h3>
                <p class="text-gray-700 mt-2">Untuk menjelajahi dan melihat dokumen tidak perlu login, namun mengunggah dokumen membutuhkan akun.</p>
            </div>
            <!-- Tambahkan FAQ lainnya sesuai kebutuhan -->
        </div>
    </main>
@endsection
