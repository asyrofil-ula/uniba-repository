@extends('landing.layouts.app')

@section('title', $document->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $document->title }}</h1>
            <div class="flex items-center mt-2">
                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    {{ $document->status == 'published' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $document->status == 'under_review' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $document->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ str_replace('_', ' ', $document->status) }}
                </span>
                <span class="ml-2 text-sm text-gray-500">Diunggah pada {{ $document->created_at->format('d M Y') }}</span>
            </div>
        </div>
        <div>
            @if($document->status != 'published')
                <a href="{{ route('user.documents.edit', $document->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 mr-2">Edit</a>
            @endif
            <a href="{{ route('user.documents.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Kembali</a>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3">
            <!-- Document Details -->
            <div class="col-span-2 p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-medium text-gray-800 mb-3">Informasi Dokumen</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Jenis Dokumen</p>
                            <p class="font-medium">{{ $document->documentType->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Fakultas</p>
                            <p class="font-medium">{{ $document->faculty->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jurusan</p>
                            <p class="font-medium">{{ $document->department->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tahun Publikasi</p>
                            <p class="font-medium">{{ $document->publication_year }}</p>
                        </div>
                        {{-- <div>
                            <p class="text-sm text-gray-500">Bahasa</p>
                            <p class="font-medium">
                                @if($document->language == 'id') Indonesia
                                @elseif($document->language == 'en') English
                                @else Keduanya
                                @endif
                            </p>
                        </div> --}}
                        <div>
                            <p class="text-sm text-gray-500">Ukuran File</p>
                            <p class="font-medium">{{ number_format($document->file_size / 1024, 2) }} MB</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h2 class="text-lg font-medium text-gray-800 mb-3">Abstrak</h2>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h3 class="font-medium text-gray-700 mb-2">Bahasa Indonesia</h3>
                        <p class="text-gray-600">{{ $document->abstract_id }}</p>
                        
                        @if($document->abstract_en)
                            <h3 class="font-medium text-gray-700 mt-4 mb-2">English</h3>
                            <p class="text-gray-600">{{ $document->abstract_en }}</p>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-medium text-gray-800 mb-3">Kata Kunci</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($document->keywords as $keyword)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $keyword->keyword }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- File Preview and Download -->
            <div class="border-t md:border-t-0 md:border-l border-gray-200 p-6 bg-gray-50">
                <div class="mb-6">
                    <h2 class="text-lg font-medium text-gray-800 mb-3">File Dokumen</h2>
                    <div class="bg-white p-4 rounded-md shadow-sm border border-gray-200">
                        <div class="flex items-center">
                            <svg class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <div class="ml-3">
                                <p class="font-medium">{{ $document->file_name }}</p>
                                <p class="text-sm text-gray-500">{{ $document->file_mime_type }} • {{ number_format($document->file_size / 1024, 2) }} MB</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="w-full inline-flex justify-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh Dokumen
                            </a>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-lg font-medium text-gray-800 mb-3">Penulis</h2>
                    <ul class="space-y-2">
                        @foreach($document->authors as $author)
                            <li class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium">
                                    {{ substr($author->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium">{{ $author->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $author->email }}</p>
                                </div>
                                @if($author->pivot->is_corresponding)
                                    <span class="ml-auto px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Corresponding</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection