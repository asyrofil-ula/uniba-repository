@extends('landing.layouts.app')
@section('title', 'Dokumen Jenis ' . $type->name)

@section('content')
    <main class="container mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold text-emerald-700 mb-6">Jenis Dokumen: {{ $type->name }}</h1>

        @if($documents->isEmpty())
            <p class="text-gray-600">Belum ada dokumen untuk jenis ini.</p>
        @else
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($documents as $doc)
                    <a href="{{ route('document.show', $doc->id) }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                        <h3 class="font-semibold text-lg text-gray-800">{{ $doc->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Oleh {{ $doc->author->name }} - {{ $doc->publication_year }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </main>
@endsection
