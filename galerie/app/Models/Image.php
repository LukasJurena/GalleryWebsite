<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'src', 'alt', 'description', 'category', 'album_id'];

    protected $attributes = [
        'alt' => 'Výchozí alternativní text',
    ];
    
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    
}
