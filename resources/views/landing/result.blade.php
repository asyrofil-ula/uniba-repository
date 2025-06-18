@extends('landing.layouts.app')

@section('title', 'Hasil Pencarian - Bahaudin Digital Repository')
@section('content')
    <main class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar Filter -->
            <aside class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white p-6 rounded-lg shadow-sm sticky top-4">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Filter Hasil</h3>

                    <!-- Search Form -->
                    <form action="{{ route('search') }}" method="GET">
                        <div class="mb-6">
                            <h4 class="font-medium mb-3 text-gray-700">Kata Kunci</h4>
                            <input type="text" name="q" value="{{ request('q') }}"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                   placeholder="Cari dokumen...">
                        </div>

                        <!-- Filter Tahun -->
                        <div class="mb-6">
                            <h4 class="font-medium mb-3 text-gray-700">Tahun Terbit</h4>
                            <div class="px-2">
                                <input type="range" name="year" min="{{ $minYear }}" max="{{ date('Y') }}"
                                    value="{{ request('year', date('Y')) }}"
                                    class="w-full mb-2" id="yearRange">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>{{ $minYear }}</span>
                                    <span id="yearValue">{{ request('year', date('Y')) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Fakultas -->
                        <div class="mb-6">
                            <h4 class="font-medium mb-3 text-gray-700">Fakultas</h4>
                            <div class="space-y-2">
                                @foreach($faculties as $faculty)
                                <label class="flex items-center">
                                    <input type="checkbox" name="faculty_id[]" value="{{ $faculty->id }}"
                                        class="rounded text-green-600 mr-2"
                                        {{ in_array($faculty->id, (array)request('faculty_id', [])) ? 'checked' : '' }}>
                                    <span class="text-gray-700">{{ $faculty->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter Jenis Dokumen -->
                        <div class="mb-6">
                            <h4 class="font-medium mb-3 text-gray-700">Jenis Dokumen</h4>
                            <div class="space-y-2">
                                @foreach($documentTypes as $type)
                                <label class="flex items-center">
                                    <input type="checkbox" name="document_type_id[]" value="{{ $type->id }}"
                                        class="rounded text-green-600 mr-2"
                                        {{ in_array($type->id, (array)request('document_type_id', [])) ? 'checked' : '' }}>
                                    <span class="text-gray-700">{{ $type->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white py-2 rounded-md">
                            Terapkan Filter
                        </button>
                        @if(request()->hasAny(['year', 'faculty_id', 'document_type_id']))
                        <a href="{{ route('search', ['q' => request('q')]) }}"
                           class="mt-2 w-full text-center block text-sm text-green-700 hover:text-green-900">
                            Reset Filter
                        </a>
                        @endif
                    </form>
                </div>
            </aside>

            <!-- Hasil Pencarian -->
            <div class="flex-grow">
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2 md:mb-0">
                            Hasil Pencarian untuk "{{ request('q') }}"
                            <span class="text-lg font-normal text-gray-600">({{ $documents->total() }} hasil ditemukan)</span>
                        </h2>
                        <div class="w-full md:w-auto">
                            <label class="mr-2 text-gray-700">Urutkan:</label>
                            <select id="sortSelect" class="border rounded px-3 py-1 w-full md:w-auto">
                                <option value="relevance" {{ request('sort') == 'relevance' ? 'selected' : '' }}>Relevansi</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Tanggal Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Tanggal Terlama</option>
                                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Paling Populer</option>
                            </select>
                        </div>
                    </div>

                    @if($documents->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 text-lg">Tidak ada dokumen yang ditemukan dengan kriteria pencarian Anda.</p>
                        <a href="{{ route('search') }}" class="text-green-600 hover:underline mt-2 inline-block">
                            Coba pencarian lain
                        </a>
                    </div>
                    @else
                        @foreach($documents as $document)
                        <div class="border-b pb-6 mb-6">
                            <div class="flex items-start">
                                <div class="mr-4 text-green-600">
                                    <i class="fas fa-file-pdf text-3xl"></i>
                                </div>
                                <div class="flex-grow">
                                    <h3 class="text-xl font-bold text-green-800 hover:underline mb-1">
                                        <a href="{{ route('document.show', $document->id) }}">{{ $document->title }}</a>
                                    </h3>
                                    <p class="text-gray-600 mb-2">
                                        Oleh:
                                        @foreach($document->authors as $author)
                                            <a href="{{ route('search', ['author' => $author->name]) }}"
                                               class="text-green-600 hover:underline">
                                                {{ $author->name }}{{ !$loop->last ? ',' : '' }}
                                            </a>
                                        @endforeach
                                        ({{ $document->publication_year }})
                                    </p>
                                    <p class="text-gray-700 mb-3">
                                        {{ Str::limit($document->abstract_id, 250) }}
                                    </p>
                                    <div class="flex flex-wrap gap-2 text-sm">
                                        @foreach($document->keywords->take(5) as $keyword)
                                            <a href="{{ route('search', ['q' => $keyword->keyword]) }}"
                                               class="bg-green-100 text-green-800 px-2 py-1 rounded hover:bg-green-200">
                                                {{ $keyword->keyword }}
                                            </a>
                                        @endforeach
                                    </div>
                                    <div class="mt-3 flex flex-wrap items-center text-sm text-gray-500">
                                        <span class="mr-4"><i class="fas fa-eye mr-1"></i> {{ $document->view_count }} dilihat</span>
                                        <span class="mr-4"><i class="fas fa-download mr-1"></i> {{ $document->download_count }} unduhan</span>
                                        <a href="{{ route('search', ['faculty_id' => $document->faculty_id]) }}"
                                           class="mr-4 hover:text-green-600">
                                            <i class="fas fa-university mr-1"></i> {{ $document->faculty->name }}
                                        </a>
                                        <a href="{{ route('search', ['document_type_id' => $document->document_type_id]) }}"
                                           class="hover:text-green-600">
                                            <i class="fas fa-tag mr-1"></i> {{ $document->documentType->name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="flex justify-center mt-8">
                            {{ $documents->appends(request()->query())->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    // Update year value display
    document.getElementById('yearRange').addEventListener('input', function() {
        document.getElementById('yearValue').textContent = this.value;
    });

    // Sort select change handler
    document.getElementById('sortSelect').addEventListener('change', function() {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', this.value);
        window.location.href = url.toString();
    });
</script>
@endpush
