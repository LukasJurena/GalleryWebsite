<!-- resources/views/gallery/index.blade.php -->
@extends('layouts.app')
@section('content')
<body>

    <h1>Galerie</h1>

    <!-- Filtrování podle alba a vyhledávání -->
<!--
    <form action="{{ route('home') }}" method="GET">
        <select name="album_id" onchange="this.form.submit()">
            <option value="">Všechna alba</option>
            @foreach ($albums as $album)
                <option value="{{ $album->id }}" {{ request('album_id') == $album->id ? 'selected' : '' }}>
                    {{ $album->name }}
                </option>
            @endforeach
        </select>
        <input type="text" name="search" placeholder="Hledat obrázky" value="{{ request('search') }}">
        <button type="submit">Hledat</button>
    </form>
-->
    <!-- Zobrazení obrázků -->
    @if (request('search') || request('album_id'))
        <div class="gallery">
            @forelse ($images as $image)
                <div class="gallery-item">
                    <a href="{{ route('gallery.show', $image->id) }}">
                        <img src="{{ asset('storage/' . $image->src) }}" alt="{{ $image->alt }}" width="300" height="200">
                    </a>
                    <p>{{ $image->title }}</p>
                </div>
            @empty
                <p>Žádné obrázky nenalezeny.</p>
            @endforelse
        </div>
    @else
        <!-- Zobrazení alb, pokud není hledání ani filtr -->
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
    @endif

    <!-- Stránkování -->
    @if (request('search') || request('album_id'))
        {{ $images->links() }}
    @endif

@endsection