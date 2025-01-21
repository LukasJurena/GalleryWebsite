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
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
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
        $images = Image::all();
        return view('admin.index', compact('albums', 'images'));
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
    public function editImage($id)
    {
        $image = Image::findOrFail($id);
        return response()->json($image);
    }

    // Aktualizace obrázku
    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'album_id' => 'nullable|exists:albums,id',
        ]);

        $image = Image::findOrFail($id);
        $image->update($request->only('title', 'description', 'album_id'));

        return redirect()->route('admin.index')->with('success', 'Obrázek byl aktualizován!');
    }

    // Mazání obrázku
    public function destroyImage($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();

        return redirect()->route('admin.index')->with('success', 'Obrázek byl smazán!');
    }

    // Editace alba
    public function editAlbum($id)
    {
        $album = Album::findOrFail($id);
        return response()->json($album);
    }

    // Aktualizace alba
    public function updateAlbum(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $album = Album::findOrFail($id);
        $album->update($request->only('name', 'description'));

        return redirect()->route('admin.albums')->with('success', 'Album bylo aktualizováno!');
    }

    // Mazání alba
    public function destroyAlbum($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();

        return redirect()->route('admin.albums')->with('success', 'Album bylo smazáno!');
    }
};
