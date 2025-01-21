<!-- GalleryWebsite/galerie/resources/views/admin/index.blade.php -->
@extends('layouts.app')
@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    h1, h2 {
        color: #333;
        text-align: center;
    }

    .container {
        max-width: 900px;
        margin: 20px auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    input, textarea, select, button {
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }

    label {
        font-size: 1rem;
        margin-bottom: 5px;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    hr {
        margin: 30px 0;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    li {
        background-color: #f9f9f9;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
    }

    strong {
        color: #333;
    }

    .album-info {
        font-size: 0.9rem;
        color: #777;
    }

    .auth-form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

</style>
    <h1>Administrace - Nahrání obrázku</h1>

    @if (!session('authenticated'))
        <div class="auth-form">
            <form action="{{ route('admin.authenticate') }}" method="POST">
                @csrf
                <label for="password">Zadejte heslo:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Ověřit</button>
            </form>
        </div>
    @else
        <div class="container">
            <!-- Formulář pro nahrání obrázku -->
            <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="title" placeholder="Název obrázku" required>
                <input type="text" name="alt" placeholder="Alternativní text" required>
                <textarea name="description" placeholder="Popis obrázku"></textarea>
                <select name="album_id">
                    <option value="">Bez alba</option>
                    @foreach ($albums as $album)
                        <option value="{{ $album->id }}">{{ $album->name }}</option>
                    @endforeach
                </select>

                <input type="file" name="image" accept="image/*" required>
                <button type="submit">Přidat obrázek</button>
            </form>

            <hr>

            <!-- Formulář pro vytvoření nového alba -->
            <h2>Vytvořit nové album</h2>
            <form action="{{ route('admin.albums.store') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Název alba" required>
                <textarea name="description" placeholder="Popis alba"></textarea>
                <button type="submit">Vytvořit album</button>
            </form>

            <hr>

            <!-- Seznam existujících alb -->
            <h2>Seznam alb</h2>
            <ul>
                @foreach ($albums as $album)
                    <li>
                        <strong>{{ $album->name }}</strong> - {{ $album->description ?? 'Bez popisu' }}
                        <br><span class="album-info">Vytvořeno: {{ $album->created_at->format('d.m.Y H:i') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
