<!-- resources/views/gallery/index.blade.php -->

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie</title>
</head>
<body>

    <h1>Galerie</h1>

    <!-- Filtrování podle kategorie -->
    <form action="{{ route('home') }}" method="GET">
        <select name="category">
            <option value="">Všechny kategorie</option>
            <option value="Nature">Příroda</option>
            <option value="City">Města</option>
            <option value="People">Lidé</option>
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
    </div>

    <!-- Stránkování -->
    {{ $images->links() }}

</body>
</html>