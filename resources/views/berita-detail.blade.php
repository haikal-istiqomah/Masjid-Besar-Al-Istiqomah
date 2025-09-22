@extends('layouts.public')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">

    <h1 class="text-4xl font-bold text-gray-800 mb-4">
        {{ $berita->judul }}
    </h1>

    <div class="text-gray-500 mb-6">
        <span>Dipublikasikan pada {{ $berita->created_at->format('d F Y') }}</span>
        <span class="mx-2">&bull;</span>
        <span>Kategori: {{ $berita->kategori }}</span>
    </div>

    <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-auto rounded-lg mb-8">

    <div class="prose max-w-none">
        {!! nl2br(e($berita->konten)) !!}
    </div>

</div>
@endsection