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
                <h3 class="text-xl font-semibold text-gray-800">Apakah saya harus login untuk mengakses fitur?</h3>
                <p class="text-gray-700 mt-2">Untuk menjelajahi dan melihat detail dokumen tidak perlu login. Namun, untuk mengunggah dan mengelola dokumen, Anda diwajibkan untuk memiliki akun dan login terlebih dahulu.</p>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Bagaimana cara mencari dokumen tertentu?</h3>
                <p class="text-gray-700 mt-2">Gunakan fitur pencarian yang tersedia di halaman utama. Anda bisa mencari berdasarkan judul, penulis, tahun, atau kata kunci yang relevan dengan dokumen yang Anda cari.</p>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Format file apa saja yang didukung untuk diunggah?</h3>
                <p class="text-gray-700 mt-2">Saat ini kami hanya mendukung format file PDF untuk memastikan kompatibilitas dan keamanan. Pastikan dokumen Anda sudah dalam format PDF sebelum diunggah.</p>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Apa yang harus saya lakukan jika lupa kata sandi?</h3>
                <p class="text-gray-700 mt-2">Pada halaman login, klik tautan "Lupa Kata Sandi?". Anda akan diminta untuk memasukkan alamat email yang terdaftar, dan kami akan mengirimkan instruksi untuk mereset kata sandi Anda.</p>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Siapa yang bisa saya hubungi jika menemukan masalah?</h3>
                <p class="text-gray-700 mt-2">Jika Anda mengalami kendala teknis atau memiliki pertanyaan lebih lanjut, silakan hubungi tim dukungan kami melalui halaman "Kontak" atau kirim email ke support@example.com.</p>
            </div>
        </div>
    </main>
@endsection
