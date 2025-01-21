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
        display: flex;
        flex-direction: column;
        min-height: 100vh;
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
        /* Styl pro hlavní seznam */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Skrytý seznam pod hlavním tlačítkem */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* Styl pro jednotlivé položky seznamu */
    .dropdown-content li {
        padding: 8px 16px;
        text-align: left;
    }

    .dropdown-content li a {
        text-decoration: none;
        color: black;
        display: block;
    }

    /* Zobrazení seznamu při hoveru */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Styl hlavního tlačítka */
    .dropdown-toggle {
        background-color: #4CAF50;
        color: white;
        padding: 10px 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    .dropdown-toggle:hover {
        background-color: #45a049;
    }
    main {
        flex: 1;
    }
    footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 10px;
        position: relative; /* Přepnuto na relativní, aby nedocházelo k překrývání */
        bottom: 0;
    }
</style>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('home') }}">Domů</a></li>
                <li>
                    <div class="dropdown">
                        <button class="dropdown-toggle">Alba</button>
                        <ul class="dropdown-content">
                            @foreach ($albums as $album)
                                <li><a href="{{ route('album.show', $album->id) }}">{{ $album->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                <li>
                    <form action="{{ route('home') }}" method="GET">
                        <input type="text" name="search" placeholder="Hledat obrázky" value="{{ request('search') }}">
                        <button type="submit">Hledat</button>
                    </form>
                </li>
                <!-- Přidej další odkazy dle potřeby -->
            </ul>
            <!-- Dropdown pro výběr alba -->
            <!-- Vyhledávací formulář pro hledání obrázků -->
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <ul></ul>
        <li><p>© {{ date('Y') }} Tvá Galerie. Všechna práva vyhrazena.</p></li>
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        </ul>
    </footer>
</body>
</html>