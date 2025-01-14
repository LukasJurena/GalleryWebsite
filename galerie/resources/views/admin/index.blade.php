<!-- resources/views/admin/index.blade.php -->

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Nahrání obrázku</title>
</head>
<body>
    <h1>Administrace - Nahrání obrázku</h1>

    @if (!session('authenticated'))
        <form action="{{ route('admin.authenticate') }}" method="POST">
            @csrf
            <label for="password">Zadejte heslo:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Ověřit</button>
        </form>
    @else
        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="title" placeholder="Název obrázku" required>
            <input type="text" name="alt" placeholder="Alternativní text" required>
            <textarea name="description" placeholder="Popis obrázku"></textarea>
            <select name="category">
                <option value="Nature">Příroda</option>
                <option value="City">Města</option>
                <option value="People">Lidé</option>
            </select>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">Přidat obrázek</button>
        </form>
    @endif
</body>
</html>
