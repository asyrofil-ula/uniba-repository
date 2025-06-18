@extends('landing.layouts.app')

@section('title', 'Cari Dokumen')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="mb-4">
        <h5 class="text-xl font-semibold">Cari Dokumen</h5>
        <p class="text-gray-600">Temukan dokumen yang telah dipublikasikan di repositori</p>
    </div>
    <div>
        <!-- Search Form -->
        <form action="{{ route('search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium">Kata Kunci</label>
                <input type="text" name="q" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Judul, abstrak, atau kata kunci" value="{{ request('q') }}">
            </div>
            <div>
                <label class="block text-sm font-medium">Jenis Dokumen</label>
                <select name="document_type_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <option value="">Semua Jenis</option>
                    @foreach($documentTypes as $type)
                        <option value="{{ $type->id }}" {{ request('document_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Fakultas</label>
                <select name="faculty_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <option value="">Semua Fakultas</option>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ request('faculty_id') == $faculty->id ? 'selected' : '' }}>
                            {{ $faculty->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium">Tahun</label>
                <select name="year" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    <i class="bi bi-search mr-1"></i> Cari
                </button>
            </div>
        </form>

        <!-- Search Results -->
        @if(request()->has('q') || request()->has('document_type_id') || request()->has('faculty_id') || request()->has('year'))
            <h5 class="mb-3 text-lg font-semibold">Hasil Pencarian</h5>
            
            @if($documents->count() > 0)
                <div class="space-y-4">
                    @foreach($documents as $document)
                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                        <div class="flex justify-between">
                            <h5 class="text-lg font-semibold">
                                <a href="{{ route('user.documents.show', $document->id) }}" class="text-blue-600 hover:underline">
                                    {{ $document->title }}
                                </a>
                            </h5>
                            <small class="text-gray-500">{{ $document->publication_year }}</small>
                        </div>
                        <p class="mt-2 text-gray-700">{{ Str::limit($document->abstract_id, 200) }}</p>
                        <div class="flex justify-between mt-2">
                            <small class="text-gray-500">
                                <i class="bi bi-person"></i> {{ $document->user->name }} | 
                                <i class="bi bi-tag"></i> {{ $document->documentType->name }} | 
                                <i class="bi bi-building"></i> {{ $document->faculty->name }}
                            </small>
                            <small>
                                <i class="bi bi-eye"></i> {{ $document->view_count }} | 
                                <i class="bi bi-download"></i> {{ $document->download_count }}
                            </small>
                        </div>
                        <div class="mt-2">
                            @foreach($document->keywords->take(5) as $keyword)
                                <span class="inline-block bg-blue-500 text-white text-xs font-semibold mr-1 px-2 py-1 rounded-full">{{ $keyword->keyword }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-4">
                    {{ $documents->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-search text-5xl text-gray-400"></i>
                    <h5 class="mt-3 text-lg font-semibold">Tidak ada dokumen ditemukan</h5>
                    <p class="text-gray-500">Coba dengan kata kunci atau filter yang berbeda</p>
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-search text-5xl text-gray-400"></i>
                <h5 class="mt-3 text-lg font-semibold">Mulai pencarian Anda</h5>
                <p class="text-gray-500">Gunakan form di atas untuk mencari dokumen di repositori</p>
            </div>
        @endif
    </div>
</div>
@endsection