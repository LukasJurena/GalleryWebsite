<!-- resources/views/gallery/album.blade.php -->
@extends('layouts.app')
@section('content')
<body>

    <h1>{{ $album->name }}</h1>
    <p>{{ $album->description }}</p>

    <div class="gallery">
        {{-- Debug výstup --}}
        <pre>{{ var_dump($album->images) }}</pre>
        
        @foreach ($album->images as $image)
            <div class="gallery-item">
                <a href="{{ route('image.show', $image->id) }}">
                    <img src="{{ asset('storage/' . $image->src) }}" alt="{{ $image->alt }}" width="300" height="200">
                </a>
                <p>{{ $image->title }}</p>
            </div>
        @endforeach
    </div>
@endsection

