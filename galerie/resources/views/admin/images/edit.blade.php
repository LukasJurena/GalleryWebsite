@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Upravit obrázek</h1>

    <form action="{{ route('admin.images.update', $image->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="title" value="{{ old('title', $image->title) }}" placeholder="Název obrázku" required>
        <textarea name="description" placeholder="Popis obrázku">{{ old('description', $image->description) }}</textarea>

        <select name="album_id">
            <option value="">Bez alba</option>
            @foreach ($albums as $album)
                <option value="{{ $album->id }}" {{ $image->album_id == $album->id ? 'selected' : '' }}>{{ $album->name }}</option>
            @endforeach
        </select>

        <input type="file" name="image" accept="image/*">
        <button type="submit">Upravit obrázek</button>
    </form>

    <form action="{{ route('admin.images.destroy', $image->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" style="background-color: red;">Smazat obrázek</button>
    </form>
</div>
@endsection
