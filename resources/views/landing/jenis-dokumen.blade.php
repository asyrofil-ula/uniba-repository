@extends('landing.layouts.app')
@section('title', 'Jelajahi Berdasarkan Jenis Dokumen')

@section('content')
    <main class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-emerald-700 mb-8">Jelajahi Berdasarkan Jenis Dokumen</h1>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($types as $type)
                <a href="{{ route('type.documents', $type->id) }}"
                   class="block bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $type->name }}</h3>
                    <p class="text-gray-600 text-sm mt-2">{{ $type->documents_count }} dokumen</p>
                </a>
            @endforeach
        </div>
    </main>
@endsection
