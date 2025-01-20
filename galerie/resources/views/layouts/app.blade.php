<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Galerie')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Pokud používáš CSS -->
</head>
<style>
    body {
        margin: 0;
        padding: 0;
    }
    nav {
        background-color: #333;
        padding: 10px;
    }

    nav ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
    }

    nav ul li {
        margin-right: 20px;
    }

    nav ul li a {
        color: black;
        text-decoration: none;
    }

    footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 10px;
    }
</style>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Domů</a></li>
                <li><a href="{{ route('admin.index') }}">Admin</a></li>
                <li><a href="{{ route('album.show', 1) }}">Ukázkové Album</a></li>
                <!-- Přidej další odkazy dle potřeby -->
            </ul>
            <!-- Dropdown pro výběr alba -->
            <li>
                <form action="{{ route('home') }}" method="GET">
                    <select name="album_id" onchange="this.form.submit()">
                        <option value="">Všechna alba</option>
                        @foreach ($albums as $album)
                            <option value="{{ $album->id }}">{{ $album->name }}<a href="{{ route('album.show', $album->id) }}"></option>
                        @endforeach
                    </select>
                </form>
            </li>

            <!-- Vyhledávací formulář pro hledání obrázků -->
            <li>
                <form action="{{ route('home') }}" method="GET">
                    <input type="text" name="search" placeholder="Hledat obrázky" value="{{ request('search') }}">
                    <button type="submit">Hledat</button>
                </form>
            </li>
        </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>© {{ date('Y') }} Tvá Galerie. Všechna práva vyhrazena.</p>
    </footer>
</body>
</html>