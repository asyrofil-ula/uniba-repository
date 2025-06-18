@extends('landing.layouts.app')

@section('title', 'Dokumen Saya')

@section('content')
    <div class="min-h-screen container mx-auto mt-8 sm:mt-12 px-4 py-8 ">
        <div class="bg-white w-full shadow rounded-lg">
            <div class="flex justify-between items-center p-4 border-b">
                <h5 class="text-lg font-semibold">Dokumen Saya</h5>
                <a href="{{ route('user.documents.create') }}"
                   class="inline-flex items-center px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Unggah Dokumen
                </a>
            </div>
            <div class="p-4">
                <!-- Filter -->
                <form action="{{ route('user.documents.index') }}" method="GET"
                      class="grid grid-cols-1  md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>
                                Under Review
                            </option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>
                                Published
                            </option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Dokumen</label>
                        <select name="document_type_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Semua Jenis</option>
                            @foreach($documentTypes as $type)
                                <option
                                    value="{{ $type->id }}" {{ request('document_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2H3V4zM3 8h18v10a1 1 0 01-1 1H4a1 1 0 01-1-1V8z"/>
                            </svg>
                            Filter
                        </button>
                    </div>
                </form>

                <!-- Tabel Dokumen -->
                @if($documents->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fakultas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($documents as $document)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($document->title, 50) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $document->documentType->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $document->faculty->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $document->publication_year }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($document->status == 'published')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Published</span>
                                        @elseif($document->status == 'under_review')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Under Review</span>
                                        @elseif($document->status == 'rejected')
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Rejected</span>
                                            @if($document->rejection_reason)
                                                <div
                                                    class="text-xs text-gray-500">{{ Str::limit($document->rejection_reason, 30) }}</div>
                                            @endif
                                        @else
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Draft</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('user.documents.show', $document->id) }}"
                                               class="inline-flex items-center px-2 py-1 text-blue-600 border border-blue-600 rounded hover:bg-blue-600 hover:text-white"
                                               title="Lihat">
                                                <i class="fas fa-eye mr-1"></i> Lihat
                                            </a>
                                            @if($document->status !== 'published')
                                                <a href="{{ route('user.documents.edit', $document->id) }}"
                                                   class="inline-flex items-center px-2 py-1 text-yellow-600 border border-yellow-600 rounded hover:bg-yellow-600 hover:text-white"
                                                   title="Edit">
                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-4">
                        {{ $documents->links() }}
                    </div>
                @else
                    <div class="text-center py-10">
                        <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor"
                             stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12h6m-3-3v6m-7 8a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        <h5 class="mt-4 text-lg font-semibold">Belum ada dokumen</h5>
                        <p class="text-gray-500">Mulai dengan mengunggah dokumen pertama Anda</p>
                        <a href="{{ route('user.documents.create') }}"
                           class="mt-4 inline-flex items-center px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Unggah Dokumen
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
