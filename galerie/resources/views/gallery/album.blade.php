<!-- resources/views/gallery/album.blade.php -->
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $album->name }}</title>
</head>
<body>

    <h1>{{ $album->name }}</h1>
    <p>{{ $album->description }}</p>

    <div class="gallery">
        @foreach ($album->images as $image)
            <div class="gallery-item">
                <a href="{{ route('image.show', $image->id) }}">
                    <img src="{{ asset('storage/' . $image->src) }}" alt="{{ $image->alt }}" width="300" height="200">
                </a>
                <p>{{ $image->title }}</p>
            </div>
        @endforeach
    </div>
    
</body>
</html>
