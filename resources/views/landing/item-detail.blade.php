@extends('landing.layouts.app')

@section('title', $document->title . ' - Bahaudin Digital Repository')

@section('content')
    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Bagian Atas (Judul dan Info Dasar) -->
            <div class="p-6 border-b">
                <div class="flex flex-col md:flex-row items-start">
                    <!-- Thumbnail dan Download -->
                    <div class="md:w-1/4 mb-6 md:mb-0 md:mr-6">
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-400 rounded-lg">
                            <i class="fas fa-file-pdf text-6xl"></i>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('document.download', $document->id) }}"
                                class="w-full inline-block bg-red-600 hover:bg-red-700 text-white py-2 rounded-md mb-2"
                                onclick="incrementDownloadCount()">
                                <i class="fas fa-download mr-2"></i> Unduh PDF
                                {{ number_format($document->file_size / 1024, 2) }} MB)
                            </a>
                            <p class="text-xs text-gray-500">Unduhan: <span
                                    id="downloadCount">{{ $document->download_count }}</span> kali</p>
                        </div>
                    </div>

                    <!-- Informasi Dokumen -->
                    <div class="md:w-3/4">
                        <span
                            class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium mb-4">
                            {{ $document->documentType->name }}
                        </span>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">{{ $document->title }}</h1>

                        <!-- Penulis -->
                        <div class="flex items-center text-gray-600 mb-4 flex-wrap">
                            <i class="fas fa-user-graduate mr-2"></i>
                            <span>Oleh:
                                @foreach ($document->authors as $author)
                                    <a href="{{ route('search', ['author' => $author->name]) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $author->name }}{{ !$loop->last ? ',' : '' }}
                                    </a>
                                @endforeach
                            </span>
                        </div>

                        <!-- Metadata -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <div>
                                <p class="text-sm text-gray-500">Tahun Terbit</p>
                                <p class="font-medium">{{ $document->publication_year }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Fakultas</p>
                                <a href="{{ route('search', ['faculty_id' => $document->faculty_id]) }}"
                                    class="font-medium text-blue-600 hover:underline">
                                    {{ $document->faculty->name }}
                                </a>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Program Studi</p>
                                <a href="{{ route('search', ['department_id' => $document->department_id]) }}"
                                    class="font-medium text-blue-600 hover:underline">
                                    {{ $document->department->name }}
                                </a>
                            </div>
{{--                            <div>--}}
{{--                                <p class="text-sm text-gray-500">Pembimbing</p>--}}
{{--                                <p class="font-medium">--}}
{{--                                    @if (isset($document->supervisors) && $document->supervisors->isNotEmpty())--}}
{{--                                        {{ $document->supervisors->first()->name }}--}}
{{--                                        @if ($document->supervisors->count() > 1)--}}
{{--                                            +{{ $document->supervisors->count() - 1 }} lainnya--}}
{{--                                        @endif--}}
{{--                                    @else--}}
{{--                                        ---}}
{{--                                    @endif--}}
{{--                                </p>--}}
{{--                            </div>--}}
                        </div>

                        <!-- Kata Kunci -->
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach ($document->keywords as $keyword)
                                <a href="{{ route('search', ['q' => $keyword->keyword]) }}"
                                    class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm hover:bg-blue-200">
                                    {{ $keyword->keyword }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Aksi -->
                        <div class="flex flex-wrap gap-4">
                            <button class="flex items-center text-gray-700 hover:text-blue-700" id="saveButton">
                                <i class="far fa-bookmark mr-1"></i> Simpan
                            </button>
                            <button class="flex items-center text-gray-700 hover:text-blue-700" onclick="shareDocument()">
                                <i class="fas fa-share-alt mr-1"></i> Bagikan
                            </button>
                            <div class="relative group">
                                <button class="flex items-center text-gray-700 hover:text-blue-700">
                                    <i class="fas fa-quote-right mr-1"></i> Kutip
                                </button>
                                <div
                                    class="absolute left-0 mt-2 w-64 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block border">
                                    <button onclick="copyCitation('apa')"
                                        class="w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50">Format
                                        APA</button>
                                    <button onclick="copyCitation('mla')"
                                        class="w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50">Format
                                        MLA</button>
                                    <button onclick="copyCitation('chicago')"
                                        class="w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50">Format
                                        Chicago</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigasi -->
            <div class="border-b">
                <nav class="flex overflow-x-auto" id="documentTabs">
                    <button data-tab="abstract"
                        class="px-6 py-3 border-b-2 border-blue-600 text-blue-600 font-medium tab-button active">Abstrak</button>
                    <button data-tab="details"
                        class="px-6 py-3 text-gray-600 hover:text-blue-600 font-medium tab-button">Detail</button>
                    <button data-tab="file"
                        class="px-6 py-3 text-gray-600 hover:text-blue-600 font-medium tab-button">File</button>
                    <button data-tab="statistics"
                        class="px-6 py-3 text-gray-600 hover:text-blue-600 font-medium tab-button">Statistik</button>
                    <button data-tab="related"
                        class="px-6 py-3 text-gray-600 hover:text-blue-600 font-medium tab-button">Karya Terkait</button>
                </nav>
            </div>

            <!-- Konten Tab (Abstrak) -->
            <div id="abstract" class="tab-content p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Abstrak</h2>

                <div class="mb-8">
                    <h3 class="font-medium text-gray-700 mb-2">Bahasa Indonesia</h3>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $document->abstract_id }}
                    </p>
                </div>

                @if ($document->abstract_en)
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">English Abstract</h3>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $document->abstract_en }}
                        </p>
                    </div>
                @endif
            </div>

            <!-- Konten Tab (Detail) -->
            <div id="details" class="tab-content p-6 hidden">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Dokumen</h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-medium text-gray-700 mb-3">Informasi Utama</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Status</span>
                                <span class="font-medium capitalize">{{ str_replace('_', ' ', $document->status) }}</span>
                            </div>
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Tanggal Unggah</span>
                                <span class="font-medium">{{ $document->created_at->format('d F Y') }}</span>
                            </div>

                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Bahasa</span>
                                <span class="font-medium">
                                    @if ($document->language == 'id')
                                        Indonesia
                                    @elseif($document->language == 'en')
                                        English
                                    @else
                                        Keduanya
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-medium text-gray-700 mb-3">Penulis</h3>
                        <ul class="space-y-2">
                            @foreach ($document->authors as $author)
                                <li class="flex items-center border-b pb-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium mr-3">
                                        {{ substr($author->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $author->name }}</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $author->pivot->is_corresponding ? 'Corresponding Author' : 'Co-Author' }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                @if (isset($document->supervisors) && $document->supervisors->isNotEmpty())

                    <div class="mt-6">
                        <h3 class="font-medium text-gray-700 mb-3">Pembimbing</h3>
                        <ul class="grid md:grid-cols-2 gap-4">
                            @foreach ($document->supervisors as $supervisor)
                                <li class="flex items-center border rounded-lg p-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-medium mr-3">
                                        {{ substr($supervisor->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $supervisor->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $supervisor->pivot->role }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Konten Tab (File) -->
            <div id="file" class="tab-content p-6 hidden">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi File</h2>

                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-file-pdf text-4xl text-red-500 mr-4"></i>
                        <div>
                            <h3 class="font-medium text-gray-800">{{ $document->file_name }}</h3>
                            <p class="text-sm text-gray-600">{{ $document->file_mime_type }} •
                               {{ number_format($document->file_size / 1024, 2) }} MB</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Pratinjau Dokumen</h4>
                            <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg flex items-center justify-center">
                                <iframe src="{{ asset('storage/' . $document->file_path) }}#toolbar=0&view=fitH"
                                    class="w-full h-64 border-0"></iframe>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-medium text-gray-700 mb-2">Detail File</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Format</span>
                                    <span class="font-medium">PDF (Portable Document Format)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Versi</span>
                                    <span class="font-medium">1.0</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ukuran</span>
                                    <span class="font-medium">{{ number_format($document->file_size / 1024, 2) }} MB</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Halaman</span>
                                    <span class="font-medium">{{ $document->pages ?? 'Tidak diketahui' }}</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('document.download', $document->id) }}"
                                    class="inline-block bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md"
                                    onclick="incrementDownloadCount()">
                                    <i class="fas fa-download mr-2"></i> Unduh Dokumen
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Konten Tab (Statistik) -->
            <div id="statistics" class="tab-content p-6 hidden">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik</h2>

                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <h3 class="text-3xl font-bold text-blue-600 mb-1">{{ $document->view_count }}</h3>
                        <p class="text-gray-600">Total Dilihat</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <h3 class="text-3xl font-bold text-green-600 mb-1">{{ $document->download_count }}</h3>
                        <p class="text-gray-600">Total Unduhan</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4 text-center">
                        <h3 class="text-3xl font-bold text-purple-600 mb-1">{{ $document->citation_count ?? 0 }}</h3>
                        <p class="text-gray-600">Total Sitasi</p>
                    </div>
                </div>

                <div class="bg-white border rounded-lg p-4">
                    <h3 class="font-medium text-gray-700 mb-4">Grafik Kunjungan 30 Hari Terakhir</h3>
                    <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                        <canvas id="visit-chart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Konten Tab (Karya Terkait) -->
            <div id="related" class="tab-content p-6 hidden">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Karya Terkait</h2>

                @if ($relatedDocuments->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-book-open text-3xl mb-3"></i>
                        <p>Tidak ada karya terkait yang ditemukan</p>
                    </div>
                @else
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach ($relatedDocuments as $related)
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <h3 class="font-bold text-blue-800 hover:underline mb-1">
                                    <a href="{{ route('document.show', $related->id) }}">{{ $related->title }}</a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-2">
                                    Oleh: {{ $related->authors->pluck('name')->join(', ') }}
                                    ({{ $related->publication_year }})
                                    - {{ $related->documentType->name }}
                                </p>
                                <p class="text-gray-700 text-sm line-clamp-2">
                                    {{ Str::limit($related->abstract_id, 150) }}
                                </p>
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @foreach ($related->keywords->take(3) as $keyword)
                                        <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs">
                                            {{ $keyword->keyword }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('search', ['faculty_id' => $document->faculty_id, 'document_type_id' => $document->document_type_id]) }}"
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-md">
                            Lihat Semua Karya Serupa
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        // Tab navigation
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active', 'border-b-2', 'border-blue-600',
                        'text-blue-600');
                    btn.classList.add('text-gray-600', 'hover:text-blue-600');
                });

                // Add active class to clicked button
                this.classList.add('active', 'border-b-2', 'border-blue-600', 'text-blue-600');
                this.classList.remove('text-gray-600', 'hover:text-blue-600');

                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });

                // Show selected tab content
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });

        // Save document
        document.getElementById('saveButton').addEventListener('click', function() {
            // Implement save functionality here
            alert('Fitur penyimpanan akan diimplementasikan');
        });

        // Share document
        function shareDocument() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $document->title }}',
                    text: 'Lihat dokumen ini di Bahaudin Digital Repository',
                    url: window.location.href
                }).catch(err => {
                    console.log('Error sharing:', err);
                });
            } else {
                // Fallback for browsers that don't support Web Share API
                alert('Bagikan tautan ini: ' + window.location.href);
            }
        }

        // Copy citation
        function copyCitation(format) {
            let citation = '';

            switch (format) {
                case 'apa':
                    citation =
                        `{{ $document->authors->first()->name }} ({{ $document->publication_year }}). {{ $document->title }}. {{ $document->faculty->name }}.`;
                    break;
                case 'mla':
                    citation =
                        `{{ $document->authors->first()->name }}. "{{ $document->title }}." {{ $document->faculty->name }}, {{ $document->publication_year }}.`;
                    break;
                case 'chicago':
                    citation =
                        `{{ $document->authors->first()->name }}. {{ $document->publication_year }}. "{{ $document->title }}." {{ $document->faculty->name }}.`;
                    break;
            }

            navigator.clipboard.writeText(citation).then(() => {
                alert('Kutipan berhasil disalin ke clipboard');
            }).catch(err => {
                console.error('Gagal menyalin kutipan:', err);
            });
        }

        // Increment download count
        function incrementDownloadCount() {
            fetch(`/api/documents/{{ $document->id }}/increment-download`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('downloadCount').textContent = data.downloads;
                    }
                });
        }
    </script>
@endpush
