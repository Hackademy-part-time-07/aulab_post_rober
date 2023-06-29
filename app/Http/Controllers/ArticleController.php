<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CategoryController;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;


class ArticleController extends Controller
{

    

    public function showArticles($categoryId)
{
    $category = Category::findOrFail($categoryId);
    $articles = Article::where('category_id', $category->id)->get();

    return view('article.categories', compact('category', 'articles'));
}

    
    
    
    

    /**
     * Display a listing of the resource.
     */
    

     public function index()
{
    $articles = Article::all();
    return view('article.index', compact('articles'));
}

     


    


    public function homepage()
    {
        $articles = Article::orderBy('created_at', 'desc')->take(4)->get();
        return view('welcome', compact('articles'));
    }
    


    /**
     * Show the form for creating a new resource.
     */
    

public function create()
{
    $users = User::all(); // Obtener todos los usuarios
    return view('article.create', compact('users')); // Pasar los usuarios a la vista
}




    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
{
    // Validación de los datos del formulario si es necesario

    $article = new Article;
    $article->title = $request->input('title');
    $article->subtitle = $request->input('subtitle');
    $article->body = $request->input('body');
    $article->image = $request->file('image')->store('images');
    $article->user_id = $request->input('user_id');
    $article->category_id = $request->input('category_id');
    $article->save();

    // Otras acciones después de guardar el artículo

    return redirect()->route('articles.index');
}



public function category()
{
    return $this->belongsTo(Category::class);
}



     

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }
    

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
