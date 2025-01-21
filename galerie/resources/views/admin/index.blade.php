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
            <h2>Nahrát nový obrázek</h2>
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

            <!-- Seznam obrázků -->
            <h2>Seznam obrázků</h2>
            <ul>
                @foreach ($images as $image)
                    <li>
                        <strong>{{ $image->title }}</strong>
                        <br>{{ $image->description ?? 'Bez popisu' }}
                        <br><img src="{{ asset('storage/' . $image->src) }}" alt="{{ $image->alt }}" width="100">
                        <br>
                        <button class="edit-image-btn" data-id="{{ $image->id }}">Upravit</button>
                        <form action="{{ route('admin.images.destroy', $image->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Smazat</button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <hr>

            <!-- Seznam alb -->
            <h2>Seznam alb</h2>
            <ul>
                @foreach ($albums as $album)
                    <li>
                        <strong>{{ $album->name }}</strong> - {{ $album->description ?? 'Bez popisu' }}
                        <br>
                        <button class="edit-album-btn" data-id="{{ $album->id }}">Upravit</button>
                        <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">Smazat</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Modální okno pro úpravu obrázku -->
    <div id="editImageModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Upravit obrázek</h2>
            <form id="editImageForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text" name="title" id="imageTitle" placeholder="Název obrázku" required>
                <input type="text" name="alt" id="imageAlt" placeholder="Alternativní text" required>
                <textarea name="description" id="imageDescription" placeholder="Popis obrázku"></textarea>
                <select name="album_id" id="imageAlbum">
                    <option value="">Bez alba</option>
                    @foreach ($albums as $album)
                        <option value="{{ $album->id }}">{{ $album->name }}</option>
                    @endforeach
                </select>
                <button type="submit">Uložit změny</button>
            </form>
        </div>
    </div>

    <!-- Modální okno pro úpravu alba -->
    <div id="editAlbumModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Upravit album</h2>
            <form id="editAlbumForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="text" name="name" id="albumName" placeholder="Název alba" required>
                <textarea name="description" id="albumDescription" placeholder="Popis alba"></textarea>
                <button type="submit">Uložit změny</button>
            </form>
        </div>
    </div>

    <script>
        // Script pro otevření modálního okna a zpracování formuláře
        document.querySelectorAll('.edit-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                const imageId = this.getAttribute('data-id');
                const formAction = `{{ url('admin/images') }}/${imageId}/edit`; // Dynamicky nastavíme URL pro formulář

                // Načteme data obrázku do formuláře
                fetch(formAction)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('imageTitle').value = data.title;
                        document.getElementById('imageAlt').value = data.alt;
                        document.getElementById('imageDescription').value = data.description;
                        document.getElementById('imageAlbum').value = data.album_id;

                        // Nastavení akce formuláře pro editaci obrázku
                        document.getElementById('editImageForm').action = `{{ url('admin/images') }}/${imageId}`;

                        // Otevření modálního okna
                        document.getElementById('editImageModal').style.display = 'block';
                    });
            });
        });

        document.querySelectorAll('.edit-album-btn').forEach(button => {
            button.addEventListener('click', function() {
                const albumId = this.getAttribute('data-id');
                const formAction = `{{ url('admin/albums') }}/${albumId}/edit`; // Dynamicky nastavíme URL pro formulář

                // Načteme data alba do formuláře
                fetch(formAction)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('albumName').value = data.name;
                        document.getElementById('albumDescription').value = data.description;

                        // Nastavení akce formuláře pro editaci alba
                        document.getElementById('editAlbumForm').action = `{{ url('admin/albums') }}/${albumId}`;

                        // Otevření modálního okna
                        document.getElementById('editAlbumModal').style.display = 'block';
                    });
            });
        });

        // Zavření modálních oken
        document.querySelectorAll('.close').forEach(span => {
            span.addEventListener('click', function() {
                this.closest('.modal').style.display = 'none';
            });
        });

        // Kliknutí mimo modální okno
        window.onclick = function(event) {
            if (event.target == document.getElementById('editImageModal')) {
                document.getElementById('editImageModal').style.display = 'none';
            }
            if (event.target == document.getElementById('editAlbumModal')) {
                document.getElementById('editAlbumModal').style.display = 'none';
            }
        };
    </script>
@endsection