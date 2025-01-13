<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // Domovská stránka - zobrazení všech obrázků
    public function index(Request $request)
    {
        $query = Image::query();

        // Filtrování podle kategorie
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Vyhledávání podle názvu nebo popisu
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Řazení podle data přidání (nebo jiného atributu)
        $images = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('gallery.index', compact('images'));
    }

    // Stránka s albem (detail jednoho obrázku)
    public function show($id)
    {
        $image = Image::findOrFail($id);
        return view('gallery.show', compact('image'));
    }

    // Administrativní sekce pro nahrávání obrázků
    public function admin()
    {
        return view('admin.index');
    }

    // Uložení nového obrázku do databáze
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'alt' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        Image::create([
            'title' => $request->title,
            'alt' => $request->alt,
            'description' => $request->description,
            'category' => $request->category,
            'src' => $imagePath,
        ]);

        return redirect()->route('admin')->with('success', 'Obrázek úspěšně přidán!');
    }
}

