<!-- resources/views/gallery/index.blade.php -->
@extends('layouts.app')
@section('content')
<body>

    <h1>Galerie</h1>

    <!-- Filtrování podle alba -->
    <!--
    <form action="{{ route('home') }}" method="GET">
        <select name="album_id">
            <option value="">Všechna alba</option>
            @foreach ($albums as $album)
                <option value="{{ $album->id }}">{{ $album->name }}</option>
            @endforeach
        </select>
        <input type="text" name="search" placeholder="Hledat obrázky">
        <button type="submit">Filtruj</button>
    </form>
    
    <div class="gallery">
        @foreach ($images as $image)
            <div class="gallery-item">
                <a href="{{ route('album.show', $image->id) }}">
                    <img src="{{ asset('storage/' . $image->src) }}" alt="{{ $image->alt }}" width="300" height="200">
                </a>
                <p>{{ $image->title }}</p>
            </div>
        @endforeach
    </div>-->
    <div class="albums-gallery">
        @foreach ($albums as $album)
            <div class="album-item">
                <a href="{{ route('album.show', $album->id) }}">
                    @if ($album->images->isNotEmpty())
                        <!-- Zobrazení prvního obrázku alba -->
                        <img src="{{ asset('storage/' . $album->images->first()->src) }}" alt="{{ $album->images->first()->alt }}" width="300" height="200">
                    @else
                        <!-- Placeholder, pokud album nemá žádné obrázky -->
                        <img src="{{ asset('placeholder.jpg') }}" alt="No image available" width="300" height="200">
                    @endif
                </a>
                <p>{{ $album->name }}</p>
            </div>
        @endforeach
    </div>
    <!-- Stránkování -->
    {{ $images->links() }}

@endsection
