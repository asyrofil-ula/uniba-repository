@extends('landing.layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Mahasiswa</h1>
        <p class="text-gray-600">Kelola dan pantau status dokumen akademik Anda</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Documents -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Dokumen</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['uploaded_documents'] }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-colors duration-300">
                        <i class="fas fa-file text-2xl text-blue-600"></i>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                    <span>Dokumen tersimpan</span>
                </div>
            </div>
        </div>

        <!-- Published Documents -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Dipublikasi</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['published_documents'] }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-200 transition-colors duration-300">
                        <i class="fas fa-check-circle text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-check text-green-500 mr-1"></i>
                    <span>Telah dipublikasi</span>
                </div>
            </div>
        </div>

        <!-- Pending Review -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Menunggu Review</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_documents'] }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center group-hover:bg-yellow-200 transition-colors duration-300">
                        <i class="fas fa-clock text-2xl text-yellow-600"></i>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-hourglass text-yellow-500 mr-1"></i>
                    <span>Sedang direview</span>
                </div>
            </div>
        </div>

        <!-- Rejected Documents -->
        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 mb-1">Ditolak</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['rejected_documents'] }}</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center group-hover:bg-red-200 transition-colors duration-300">
                        <i class="fas fa-circle-xmark text-2xl text-red-600"></i>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-x text-red-500 mr-1"></i>
                    <span>Perlu revisi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Documents Section -->
    <div class="bg-white rounded-2xl shadow-lg mb-8 border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">Dokumen Terbaru</h2>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-clock"></i>
                    <span>Update terkini</span>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            @if($recentDocuments->count() > 0)
                <div class="overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($recentDocuments as $document)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-gray-900">{{ Str::limit($document->title, 50) }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $document->documentType->name }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-500">
                                        {{ $document->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($document->status == 'published')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Published
                                            </span>
                                        @elseif($document->status == 'under_review')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>Under Review
                                            </span>
                                        @elseif($document->status == 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-x-circle mr-1"></i>Rejected
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-file-earmark mr-1"></i>Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <a href="{{ route('user.documents.show', $document->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-colors duration-200">
                                            <i class="fas fa-eye mr-1.5"></i>Lihat
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-earmark-text text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada dokumen</h3>
                    <p class="text-gray-500 mb-6">Mulai dengan mengunggah dokumen pertama Anda untuk membangun repositori</p>
                    <a href="{{ route('user.documents.create') }}" 
                       class="inline-flex items-center px-6 py-3 text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Unggah Dokumen Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Bottom Grid Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Upload Guide -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-lightbulb text-blue-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Panduan Unggah Dokumen</h2>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-bold text-blue-600">1</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Format File</h3>
                            <p class="text-sm text-gray-600">Pastikan dokumen dalam format PDF dengan ukuran maksimal 10MB untuk kualitas optimal</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-bold text-green-600">2</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Metadata Lengkap</h3>
                            <p class="text-sm text-gray-600">Isi semua informasi yang diperlukan termasuk judul, abstrak, dan kata kunci yang relevan</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-bold text-yellow-600">3</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Proses Review</h3>
                            <p class="text-sm text-gray-600">Dokumen akan direview oleh admin dalam 1-3 hari kerja sebelum dipublikasikan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Repository Statistics -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-bar-chart text-green-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Statistik Repositori</h2>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file text-blue-600"></i>
                            </div>
                            <span class="font-medium text-gray-700">Total Dokumen</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl font-bold text-gray-900">{{ \App\Models\Document::where('status', 'published')->count() }}</span>
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-arrow-up text-white text-xs"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-purple-600"></i>
                            </div>
                            <span class="font-medium text-gray-700">Dokumen Fakultas {{ Auth::user()->faculty->name ?? ' -' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl font-bold text-gray-900">{{ \App\Models\Document::where('status', 'published')->where('faculty_id', Auth::user()->faculty_id)->count() }}</span>
                            <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-green-600"></i>
                            </div>
                            <span class="font-medium text-gray-700">Total Pengguna</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-2xl font-bold text-gray-900">{{ \App\Models\User::count() }}</span>
                            <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-plus text-white text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection