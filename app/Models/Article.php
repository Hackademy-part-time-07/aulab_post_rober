<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'body',
        'image',
        'user_id',
        'category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category');
    }

    public function getVisibilityAttribute()
    {
        return $this->attributes['visibility'] ?? 'private';
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function updateTags(Request $request, Article $article)
{
    $validatedData = $request->validate([
        'tags' => 'required|string',
    ]);

    $tags = explode(',', $validatedData['tags']);
    $article->retag($tags);

    return redirect()->route('articles.index')->with('success', 'Tags actualizados exitosamente.');
}


    
}
