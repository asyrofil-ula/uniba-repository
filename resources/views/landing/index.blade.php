@extends('landing.layouts.app')

@section('title', 'Bahaudin Digital Repository')
@section('content')

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/20 to-teal-800/20"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-5xl mx-auto">
                <h1 class="text-5xl md:text-7xl font-bold mb-8 animate-float leading-tight">
                    Selamat Datang di <span class="text-yellow-300">Bahaudin</span> Digital Repository
                </h1>
                <p class="text-xl md:text-2xl mb-8 opacity-95 font-light">
                    Pusat Arsip dan Publikasi Karya Ilmiah Digital Uniba Madura
                </p>
                <p class="text-lg mb-12 opacity-90 italic font-light">
                    "Jendela Pengetahuan, Etalase Karya Intelektual Universitas"
                </p>
                <!-- Search Bar -->
               <div class="max-w-4xl mx-auto mb-8">
                    <div class="glass-effect rounded-2xl p-8">
                        <form action="{{ route('search') }}" method="GET">
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1">
                                    <input type="text" name="q" placeholder="Cari skripsi, tesis, jurnal, artikel..."
                                        class="w-full px-6 py-4 text-lg rounded-xl border-2 border-transparent text-gray-800 search-glow focus:outline-none focus:ring-0 transition-all duration-300"
                                        value="{{ request('q') }}">
                                </div>
                                <button type="submit"
                                    class="bg-yellow-500 hover:bg-yellow-400 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <i class="fas fa-search mr-2"></i> Cari
                                </button>
                            </div>
                        </form>
                        <div class="mt-6 text-center">
                            <button id="openModalBtn"
                                class="text-white hover:text-yellow-300 font-semibold transition-all duration-300">
                                <i class="fas fa-sliders-h mr-2"></i> Pencarian Lanjutan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal advance search --}}
        <!-- Modal Background -->
        <div id="advancedSearchModal"
            class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
            <!-- Modal Content -->
            <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-8 relative">
                <button onclick="closeModal()"
                    class="absolute top-4 right-4 text-gray-500 hover:text-red-600 text-xl font-bold">
                    &times;
                </button>
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Pencarian Lanjutan</h2>
                <form action="{{ route('search') }}" method="GET" class="space-y-4">
                    <div>
                        <label class="block font-medium text-gray-700">Judul</label>
                        <input type="text" name="title"
                            class="w-full px-4 py-2 text-gray-800 border rounded-lg focus:outline-none focus:outline-none focus:ring-0 transition-all duration-300"
                            placeholder="Masukkan judul...">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Penulis</label>
                        <input type="text" name="author"
                            class="w-full px-4 py-2 text-gray-800 border rounded-lg focus:ring-2 focus:ring-emerald-400 focus:outline-none focus:ring-0 transition-all duration-300"
                            placeholder="Nama penulis...">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Tahun Publikasi</label>
                        <input type="number" name="year"
                            class="w-full px-4 py-2 text-gray-800 border rounded-lg focus:ring-2 focus:ring-emerald-400 focus:outline-none focus:ring-0 transition-all duration-300"
                            placeholder="Contoh: 2024">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Jenis Dokumen</label>
                        <select name="document_type_id" class="w-full px-4 py-2 text-gray-800 border rounded-lg focus:outline-none focus:ring-0 transition-all duration-300" id="document_type_id">
                            <option class="text-gray-400 " disabled value="" selected >Semua Jenis</option>
                            @foreach ($types as $item)
                                <option class="text-gray-800" value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition">Cari</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Decorative Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-yellow-300/20 rounded-full blur-2xl"></div>
    </section>
    <!-- Statistics Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-emerald-50/30">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center stats-card rounded-2xl p-8 card-hover">
                    <div
                        class="w-20 h-20 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-file-alt text-emerald-600 text-3xl"></i>
                    </div>
                    <h3 class="text-4xl font-bold gradient-text mb-3">15,847</h3>
                    <p class="text-gray-600 font-medium">Dokumen Terindeks</p>
                </div>
                <div class="text-center stats-card rounded-2xl p-8 card-hover">
                    <div class="w-20 h-20 bg-teal-100 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-building text-teal-600 text-3xl"></i>
                    </div>
                    <h3 class="text-4xl font-bold gradient-text mb-3">12</h3>
                    <p class="text-gray-600 font-medium">Komunitas/Fakultas</p>
                </div>
                <div class="text-center stats-card rounded-2xl p-8 card-hover">
                    <div class="w-20 h-20 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-download text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-4xl font-bold gradient-text mb-3">45,230</h3>
                    <p class="text-gray-600 font-medium">Unduhan Bulan Ini</p>
                </div>
                <div class="text-center stats-card rounded-2xl p-8 card-hover">
                    <div class="w-20 h-20 bg-lime-100 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-users text-lime-600 text-3xl"></i>
                    </div>
                    <h3 class="text-4xl font-bold gradient-text mb-3">3,456</h3>
                    <p class="text-gray-600 font-medium">Penulis Terdaftar</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Browse Collections -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center gradient-text mb-16">Jelajahi Koleksi</h2>
            <!-- Browse by Faculty -->
            <div class="mb-16">
                <h3 class="text-3xl font-semibold text-gray-800 mb-8">Berdasarkan Fakultas</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 text-center cursor-pointer group border border-emerald-100 card-hover">
                        <div
                            class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-emerald-200 transition-colors shadow-md">
                            <i class="fas fa-cogs text-emerald-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Fakultas Teknik</h4>
                        <p class="text-sm text-gray-600">2,345 dokumen</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 text-center cursor-pointer group border border-emerald-100 card-hover">
                        <div
                            class="w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-teal-200 transition-colors shadow-md">
                            <i class="fas fa-chart-line text-teal-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Fakultas Ekonomi</h4>
                        <p class="text-sm text-gray-600">1,876 dokumen</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 text-center cursor-pointer group border border-emerald-100 card-hover">
                        <div
                            class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-green-200 transition-colors shadow-md">
                            <i class="fas fa-users text-green-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Fakultas Ilmu Sosial</h4>
                        <p class="text-sm text-gray-600">1,234 dokumen</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 text-center cursor-pointer group border border-emerald-100 card-hover">
                        <div
                            class="w-16 h-16 bg-lime-100 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-lime-200 transition-colors shadow-md">
                            <i class="fas fa-graduation-cap text-lime-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Fakultas Pendidikan</h4>
                        <p class="text-sm text-gray-600">987 dokumen</p>
                    </div>
                </div>
            </div>
            <!-- Browse by Document Type -->
            <div>
                <h3 class="text-3xl font-semibold text-gray-800 mb-8">Berdasarkan Jenis Dokumen</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center cursor-pointer border border-emerald-100 card-hover">
                        <i class="fas fa-book text-emerald-600 text-3xl mb-4"></i>
                        <h4 class="font-bold text-gray-800 mb-2">Skripsi</h4>
                        <p class="text-sm text-gray-600">8,567 dokumen</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center cursor-pointer border border-emerald-100 card-hover">
                        <i class="fas fa-scroll text-teal-600 text-3xl mb-4"></i>
                        <h4 class="font-bold text-gray-800 mb-2">Tesis</h4>
                        <p class="text-sm text-gray-600">3,456 dokumen</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center cursor-pointer border border-emerald-100 card-hover">
                        <i class="fas fa-award text-green-600 text-3xl mb-4"></i>
                        <h4 class="font-bold text-gray-800 mb-2">Disertasi</h4>
                        <p class="text-sm text-gray-600">234 dokumen</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center cursor-pointer border border-emerald-100 card-hover">
                        <i class="fas fa-newspaper text-lime-600 text-3xl mb-4"></i>
                        <h4 class="font-bold text-gray-800 mb-2">Jurnal</h4>
                        <p class="text-sm text-gray-600">2,890 dokumen</p>
                    </div>
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center cursor-pointer border border-emerald-100 card-hover">
                        <i class="fas fa-file-contract text-cyan-600 text-3xl mb-4"></i>
                        <h4 class="font-bold text-gray-800 mb-2">Laporan</h4>
                        <p class="text-sm text-gray-600">700 dokumen</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Recent Submissions -->
    <section class="py-20 bg-gradient-to-br from-emerald-50/50 to-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center gradient-text mb-16">Publikasi Terbaru</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="bg-white rounded-2xl p-8 hover:shadow-xl transition-all duration-300 border border-emerald-100 card-hover">
                    <div class="flex items-start space-x-6">
                        <div
                            class="w-20 h-24 accent-gradient rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-file-pdf text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3
                                class="font-bold text-gray-800 mb-3 hover:text-emerald-600 cursor-pointer text-lg leading-tight">
                                Implementasi Machine Learning dalam Prediksi Cuaca
                            </h3>
                            <p class="text-sm text-gray-600 mb-2 font-medium">Ahmad Fauzi</p>
                            <p class="text-sm text-gray-500 mb-3">2024 • Skripsi</p>
                            <div class="flex items-center text-xs text-gray-500 space-x-4">
                                <span class="flex items-center"><i class="fas fa-eye mr-1"></i> 245 views</span>
                                <span class="flex items-center"><i class="fas fa-download mr-1"></i> 89 downloads</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl p-8 hover:shadow-xl transition-all duration-300 border border-emerald-100 card-hover">
                    <div class="flex items-start space-x-6">
                        <div
                            class="w-20 h-24 bg-gradient-to-br from-teal-600 to-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-file-pdf text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3
                                class="font-bold text-gray-800 mb-3 hover:text-emerald-600 cursor-pointer text-lg leading-tight">
                                Analisis Ekonomi Digital pada UMKM di Era Pandemi
                            </h3>
                            <p class="text-sm text-gray-600 mb-2 font-medium">Siti Nurhaliza</p>
                            <p class="text-sm text-gray-500 mb-3">2024 • Tesis</p>
                            <div class="flex items-center text-xs text-gray-500 space-x-4">
                                <span class="flex items-center"><i class="fas fa-eye mr-1"></i> 189 views</span>
                                <span class="flex items-center"><i class="fas fa-download mr-1"></i> 67 downloads</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-2xl p-8 hover:shadow-xl transition-all duration-300 border border-emerald-100 card-hover">
                    <div class="flex items-start space-x-6">
                        <div
                            class="w-20 h-24 bg-gradient-to-br from-green-600 to-teal-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-file-pdf text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3
                                class="font-bold text-gray-800 mb-3 hover:text-emerald-600 cursor-pointer text-lg leading-tight">
                                Pengaruh Media Sosial terhadap Perilaku Konsumen
                            </h3>
                            <p class="text-sm text-gray-600 mb-2 font-medium">Budi Santoso</p>
                            <p class="text-sm text-gray-500 mb-3">2024 • Jurnal</p>
                            <div class="flex items-center text-xs text-gray-500 space-x-4">
                                <span class="flex items-center"><i class="fas fa-eye mr-1"></i> 312 views</span>
                                <span class="flex items-center"><i class="fas fa-download mr-1"></i> 145 downloads</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-12">
                <button
                    class="accent-gradient text-white px-8 py-4 rounded-xl hover:shadow-lg transition-all duration-300 font-semibold transform hover:scale-105">
                    Lihat Semua Publikasi Terbaru
                </button>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 hero-gradient text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-800/20 to-teal-900/20"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-5xl font-bold mb-8">Punya Karya Ilmiah? Bagikan di Sini!</h2>
            <p class="text-xl mb-12 max-w-4xl mx-auto opacity-95 font-light leading-relaxed">
                Bantu perluas cakrawala pengetahuan dengan mengarsipkan karya Anda di repositori kami.
                Karya Anda akan lebih mudah ditemukan dan dirujuk oleh peneliti di seluruh dunia.
            </p>
            <button
                class="bg-yellow-500 hover:bg-yellow-400 text-white px-10 py-5 rounded-xl text-lg font-bold transition-all duration-300 transform hover:scale-105 shadow-xl">
                <i class="fas fa-upload mr-3"></i>
                Submit Karya Anda Sekarang
            </button>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute top-10 left-20 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute bottom-10 right-20 w-32 h-32 bg-yellow-300/20 rounded-full blur-2xl"></div>
    </section>

    <!-- News & Announcements -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-emerald-50/30">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center gradient-text mb-16">Berita & Pengumuman</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-emerald-100 card-hover">
                    <div class="text-sm text-emerald-600 font-bold mb-3 px-3 py-1 bg-emerald-50 rounded-full inline-block">
                        PENGUMUMAN</div>
                    <h3 class="font-bold text-gray-800 mb-4 text-xl">Pembaruan Kebijakan Upload Dokumen</h3>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">Mulai 1 Januari 2025, semua dokumen yang diunggah
                        harus menyertakan abstrak dalam bahasa Inggris...</p>
                    <div class="text-xs text-gray-500 font-medium">15 Desember 2024</div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-emerald-100 card-hover">
                    <div class="text-sm text-teal-600 font-bold mb-3 px-3 py-1 bg-teal-50 rounded-full inline-block">BERITA
                    </div>
                    <h3 class="font-bold text-gray-800 mb-4 text-xl">Repositori Mencapai 15,000 Dokumen</h3>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">Pencapaian luar biasa! Bahaudin Digital
                        Repository kini telah mengarsipkan lebih dari 15,000 karya ilmiah...</p>
                    <div class="text-xs text-gray-500 font-medium">10 Desember 2024</div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-emerald-100 card-hover">
                    <div class="text-sm text-green-600 font-bold mb-3 px-3 py-1 bg-green-50 rounded-full inline-block">
                        EVENT</div>
                    <h3 class="font-bold text-gray-800 mb-4 text-xl">Workshop Penulisan Karya Ilmiah Digital</h3>
                    <p class="text-gray-600 text-sm mb-6 leading-relaxed">Daftarkan diri Anda dalam workshop penulisan dan
                        publikasi karya ilm
                    </p>
                    <div class="text-xs text-gray-500 font-medium">5 Desember 2024</div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script>
    const modal = document.getElementById('advancedSearchModal');
    const openModalBtn = document.getElementById('openModalBtn');

    openModalBtn.addEventListener('click', function () {
        modal.classList.remove('hidden');
    });

    function closeModal() {
        modal.classList.add('hidden');
    }

    // Tutup modal jika klik di luar konten
    window.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Tutup modal jika tekan tombol ESC
    window.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

</script>

@endpush