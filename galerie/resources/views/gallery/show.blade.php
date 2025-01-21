<!-- resources/views/gallery/show.blade.php -->
@extends('layouts.app')
@section('content')
<body>

    <h1>{{ $image->title }}</h1>
    <img src="{{ asset('storage/' . $image->src) }}" alt="{{ $image->alt }}" width="600">
    <p>{{ $image->description }}</p>
    <p><strong>Kategorie:</strong> {{ $image->category }}</p>

    <!-- Odkaz zpět na album -->
    <a href="{{ route('album.show', $image->album_id) }}">Zpět na album</a>

@endsection
