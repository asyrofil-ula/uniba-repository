@extends('landing.layouts.app')
@section('title', 'Jelajahi Berdasarkan Penulis')

@section('content')
    <main class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-emerald-700 mb-8">Jelajahi Dokumen Berdasarkan Penulis</h1>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($authors as $author)
                <a href="{{ route('author.documents', $author->id) }}"
                   class="block bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $author->user->name }}</h3>
                    <p class="text-gray-600 text-sm mt-2">{{ $author->document_count }} dokumen</p>
                </a>
            @endforeach
        </div>
    </main>
@endsection
