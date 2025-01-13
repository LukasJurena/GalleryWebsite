<!-- resources/views/gallery/show.blade.php -->

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $image->title }}</title>
</head>
<body>

    <h1>{{ $image->title }}</h1>
    <img src="{{ asset('storage/' . $image->src) }}" alt="{{ $image->alt }}" width="600">
    <p>{{ $image->description }}</p>
    <p><strong>Kategorie:</strong> {{ $image->category }}</p>

    <a href="{{ route('home') }}">Zpět na galerii</a>

</body>
</html>