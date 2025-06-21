<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('landing.layouts.head')

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-emerald-100">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <!-- Logo Section -->
                <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                <div class="flex items-center space-x-4">
                    <div class=" w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg pulse-green">
                        <img src="{{ asset('/images/logo-uniba.png') }}" class=" w-8 h-8" alt="">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold gradient-text">Uniba Madura</h1>
                        <p class="text-sm text-gray-600">Bahaudin Digital Repository</p>
                    </div>
                </div>
                </a>

                <!-- Navigation Menu -->

                <nav class="hidden md:flex items-center space-x-8">
                    @if (Auth::check())
                        <a href="{{ route('user.dashboard') }}"
                            class="text-gray-700 hover:text-emerald-600 font-medium nav-link">Dashboard</a>
                        <a href="{{ route('user.documents.index') }}"
                            class="text-gray-700 hover:text-emerald-600 font-medium nav-link">Dokumen Saya</a>
{{--                        <a href="{{ route('search') }}"--}}
{{--                            class="text-gray-700 hover:text-emerald-600 font-medium nav-link">Cari Dokumen</a>--}}
                    @else
                        <a href="{{route('landing')}}" class="text-gray-700 hover:text-emerald-600 font-medium nav-link">Beranda</a>
                        <div class="relative group">
                            <button class="text-gray-700 hover:text-emerald-600 font-medium flex items-center nav-link">
                                Jelajahi <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>
                            <div
                                class="absolute top-full left-0 mt-2 w-48 bg-white/95 backdrop-blur-md rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-emerald-100">
                                <a href="{{route('all.documents')}}"
                                    class="block px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-t-xl">Semua Dokumen</a>
                                <a href="{{route('explore.faculties')}}"
                                    class="block px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-t-xl">Komunitas/Fakultas</a>
                                <a href="{{route('explore.years')}}"
                                    class="block px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600">Tahun
                                    Terbit</a>
                                <a href="{{route('explore.authors')}}"
                                    class="block px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600">Penulis</a>
                                <a href="{{route('explore.types')}}"
                                    class="block px-4 py-3 text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-b-xl">Jenis
                                    Dokumen</a>
                            </div>
                        </div>
                        <a href="{{route('faq')}}"
                            class="text-gray-700 hover:text-emerald-600 font-medium nav-link">Bantuan/FAQ</a>
                        <a href="{{route('about')}}" class="text-gray-700 hover:text-emerald-600 font-medium nav-link">Tentang
                            Kami</a>
                    @endif
                </nav>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-4">
                    @if (Auth::check())
                        <div class="relative">
                            <button id="userMenuButton" onclick="toggleDropdown()"
                                class="w-8 h-8 bg-emerald-600 rounded-full flex items-center justify-center hover:shadow-lg transition-all duration-300 font-medium transform hover:scale-105">
                               <i class="fas fa-user text-white text-xl"></i>
                            </button>
                            <div id="userDropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-50">
                                <a href="{{ route('profile.show') }}"
                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Lihat Profil</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a
                            href="{{ route('login') }}"class="accent-gradient text-white px-6 py-2 rounded-lg hover:shadow-lg transition-all duration-300 font-medium transform hover:scale-105">
                            Login
                        </a>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-teal-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About Repository -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-white-600 rounded-lg flex items-center justify-center">
                            <img src="{{ asset('images/logo-uniba.png') }}" alt="" class="">
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Bahaudin Digital Repository</h3>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Universitas Bahaudin Mudhary Madura<br>
                        Jl. Raya Lenteng, Batuan, Sumenep<br>
                        Madura, Jawa Timur 69451
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-envelope text-blue-400"></i>
                            <span class="text-gray-400">repository@unibamadura.ac.id</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-phone text-blue-400"></i>
                            <span class="text-gray-400">(0328) 677-188</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Jelajahi
                                Koleksi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Submit Karya</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Kebijakan
                                Konten</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Bantuan & FAQ</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Kontak Admin</a>
                        </li>
                    </ul>
                </div>

                <!-- Social Media -->
                <div>
                    <h3 class="font-bold text-lg mb-4">Terhubung dengan Kami</h3>
                    <div class="flex space-x-4 mb-6">
                        <a href="#"
                            class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-blue-800 rounded-full flex items-center justify-center hover:bg-blue-900 transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Ikuti media sosial kami untuk mendapatkan update terbaru tentang repositori dan kegiatan
                        akademik.
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    © 2024 Universitas Bahaudin Mudhary Madura. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </footer>
    @include('landing.layouts.script')

</body>

</html>
