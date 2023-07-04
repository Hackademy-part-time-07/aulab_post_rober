<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Tag;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function index()
{
    $articles = Article::whereNotNull('category_id')
                       ->where('category_id', '!=', 0)
                       ->get();

    return view('article.index', compact('articles'));
}

public function showArticlesByTag($tagId)
{
    $tag = Tag::findOrFail($tagId);
    $articles = $tag->articles;

    return view('tags', compact('articles'));
}
public function addTag(Request $request, $articleId)
{
    // Obtener el nombre de la etiqueta del formulario
    $tagName = $request->input('tag_name');

    // Verificar si la etiqueta ya existe en la base de datos
    $tag = Tag::where('name', $tagName)->first();

    if (!$tag) {
        // Si la etiqueta no existe, crear una nueva instancia
        $tag = new Tag();
        $tag->name = $tagName;
        $tag->save();
    }

    // Obtener el artículo al que se desea agregar la etiqueta
    $article = Article::findOrFail($articleId);

    // Verificar si el artículo ya tiene la etiqueta
    if (!$article->tags->contains($tag->id)) {
        // Si el artículo no tiene la etiqueta, agregarla
        $article->tags()->attach($tag->id);
    }

    // Redirigir a la página de administración de artículos o realizar alguna otra acción
    return redirect()->route('dashboardrev')->with('success', 'Etiqueta agregada correctamente al artículo.');
}


    public function home()
{
    $articles = Article::whereNotNull('category_id')
                       ->where('category_id', '!=', 0)
                       ->latest()
                       ->take(5)
                       ->get();

    return view('home', compact('articles'));
}

public function showArticlesCategory(Category $category)
{
    $articles = $category->articles()
        ->join('article_category as ac1', 'articles.id', '=', 'ac1.article_id')
        ->join('article_category as ac2', 'articles.id', '=', 'ac2.article_id')
        ->where('ac1.category_id', '=', $category->id)
        ->get();

    return view('article.categories', compact('articles', 'category'));
}


public function search(Request $request)
{
    $searchTerm = $request->input('search');

    $articles = Article::where('title', 'like', '%'.$searchTerm.'%')
        ->orWhere('subtitle', 'like', '%'.$searchTerm.'%')
        ->orWhere('body', 'like', '%'.$searchTerm.'%')
        ->orWhereHas('user', function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%'.$searchTerm.'%');
        })
        ->select('articles.*') // Seleccionar todos los campos de articles
        ->get();

    return view('search', compact('articles', 'searchTerm'));
}



public function searchArticles(Request $request)
{
    $dateFilter = $request->input('date_filter');

    // Calcular la fecha límite en función del intervalo seleccionado
    $limitDate = null;
    $currentDate = Carbon::now();

    switch ($dateFilter) {
        case '1_hour':
            $limitDate = $currentDate->subHour();
            break;
        case '12_hours':
            $limitDate = $currentDate->subHours(12);
            break;
        case '24_hours':
            $limitDate = $currentDate->subDay();
            break;
        case '3_days':
            $limitDate = $currentDate->subDays(3);
            break;
        case '7_days':
            $limitDate = $currentDate->subWeek();
            break;
        case '15_days':
            $limitDate = $currentDate->subDays(15);
            break;
        case '1_month':
            $limitDate = $currentDate->subMonth();
            break;
        case '3_months':
            $limitDate = $currentDate->subMonths(3);
            break;
        case '1_year':
            $limitDate = $currentDate->subYear();
            break;
    }

    // Filtrar los artículos según la fecha límite
    $articles = Article::where('created_at', '>', $limitDate)->get();

    return view('admin.articles', compact('articles'));
}




    public function showByAuthor(User $author)
    {
        $articles = $author->articles; // Obtén los artículos del autor

        return view('article.categories', compact('articles', 'author'));
    }



    public function create()
{
    $user = auth()->user(); // Obtener el usuario autenticado
    return view('article.create', compact('user'));
}



    public function dashboard()
    {
        $users = User::where('is_revisor', false)->get();
        $posts = Post::where('is_published', true)
            ->whereNull('reviewed_at')
            ->get();
        return view('dashboardrev')->with('users', $users)->with('posts', $posts);
    }


    public function dashboardrev()
    {
        $articles = Article::whereHas('user', function ($query) {
            $query->where('is_writer', true)
                ->where('is_revisor', false);
        })->get();
    
        return view('dashboardrev', compact('articles'));
    }
    


    public function store(Request $request)
    {
        // Verificar si el usuario autenticado es un escritor oficial
        if (auth()->check() && auth()->user()->is_writer == 1) {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'title' => 'required',
                'subtitle' => 'required',
                'body' => 'required',
                'image' => 'required|image',
                'category_id' => 'required|array',
                'user_id' => 'required|exists:users,id', // Asegurar que el user_id exista en la tabla users
                'tags' => 'nullable|string' // Tags ingresados por el usuario (opcional)
                // Otros campos validados...
            ]);
    
            // Crear una instancia del artículo y asignar los valores
            $article = new Article;
            $article->title = $validatedData['title'];
            $article->subtitle = $validatedData['subtitle'];
            $article->body = $validatedData['body'];
            $article->user_id = $validatedData['user_id'];
    
            $imagePath = $request->file('image')->store('public/images');
            $article->image = 'storage/' . substr($imagePath, 7);
    
            // Guardar el artículo en la base de datos
            $article->save();
    
            // Asociar las categorías seleccionadas al artículo
            $categories = $validatedData['category_id'];
            $article->categories()->attach($categories);
    
            // Obtener los tags ingresados por el usuario
            $tags = explode(',', $validatedData['tags']);
    
            // Asociar los tags al artículo
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $article->tags()->attach($tag);
            }
    
            return redirect()->route('articles.index');
        } else {
            // Usuario no autorizado para crear artículos
            return redirect()->route('articles.index')->with('warning', 'Solo los escritores oficiales pueden crear artículos. Si quieres colaborar, por favor contáctanos en la sección de carreras.');
        }
    }
    
    


    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('article.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'body' => 'required',
            'image' => 'image',
            'category_id' => 'required|array',
        ]);

        $article->title = $request->input('title');
        $article->subtitle = $request->input('subtitle');
        $article->body = $request->input('body');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $article->image = 'storage/' . substr($imagePath, 7);
        }

        $article->categories()->sync($request->input('category_id'));
        $article->save();

        return redirect()->route('articles.show', $article);
    }

    public function destroy(Article $article)
    {
        $article->categories()->detach();
        $article->delete();

        return redirect()->route('articles.index');
    }
}
