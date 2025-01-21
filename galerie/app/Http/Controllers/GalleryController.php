<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Album;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // Domovská stránka - zobrazení všech obrázků
    public function index(Request $request)
    {
        $albums = Album::all(); // Načítání všech alb pro výběr
        $query = Image::query();

        // Filtrování podle alba
        if ($request->has('album_id') && $request->album_id) {
            $query->where('album_id', $request->album_id);
        }

        // Vyhledávání podle názvu nebo popisu
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Řazení podle data přidání (nebo jiného atributu)
        $images = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('gallery.index', compact('images', 'albums')); // Zajistí, že 'albums' bude k dispozici v šabloně
    }
    public function showImage($id)
    {
        $image = Image::findOrFail($id);
        return view('gallery.show', compact('image'));
    }
    // Stránka s albem (zobrazení obrázků v konkrétním albu)
    
    public function showAlbum($id)
    {
        $album = Album::with('images')->findOrFail($id);
        return view('gallery.album', compact('album'));
    }

    // Administrativní sekce pro správu alb
    public function adminAlbums()
    {
        $albums = Album::all();
        return view('admin.albums', compact('albums'));
    }

    // Vytvoření nového alba
    public function storeAlbum(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Album::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.albums')->with('success', 'Album bylo úspěšně vytvořeno!');
    }

    // Administrativní sekce pro nahrávání obrázků
    public function admin()
    {
        $albums = Album::all();
        
        return view('admin.index', compact('albums'));
    }

    // Uložení nového obrázku do databáze
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'album_id' => 'nullable|exists:albums,id',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        // Automatické generování alt textu
        $altText = $request->title;
        if ($request->description) {
            $altText .= ' - ' . $request->description;
        }

        Image::create([
            'title' => $request->title,
            'alt' => $altText,
            'description' => $request->description,
            'album_id' => $request->album_id,
            'src' => $imagePath,
        ]);

        return redirect()->route('admin.index')->with('success', 'Obrázek úspěšně přidán!');
    }
};
