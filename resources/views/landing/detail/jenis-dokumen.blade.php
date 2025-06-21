@extends('landing.layouts.app')
@section('title', 'Dokumen Jenis ' . $type->name)

@section('content')
    <main class="container mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold text-emerald-700 mb-6">Jenis Dokumen: {{ $type->name }}</h1>

        @if($documents->isEmpty())
            <p class="text-gray-600">Belum ada dokumen untuk jenis ini.</p>
        @else
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($documents as $document)
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
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
                </div>
                @endforeach

            </div>

        @endif
    </main>
@endsection
