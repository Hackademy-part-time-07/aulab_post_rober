<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CategoryController;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;

class ArticleController extends Controller
{

    

    

    
    
    
    

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
    


    public function showArticles(Category $category)
{
    $articles = $category->articles;

    return view('article.categories', compact('articles', 'category'));
}


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

    $imagePath = $request->file('image')->store('public/images');
    $article->image = 'storage/' . substr($imagePath, 7); // Eliminar "public/" del inicio de la ruta

    $article->user_id = $request->input('user_id');
    $article->save();

    // Obtener las categorías seleccionadas
    $categories = $request->input('category_id');
    $article->categories()->attach($categories);

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
