<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
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


    public function home()
{
    $articles = Article::whereNotNull('category_id')
                       ->where('category_id', '!=', 0)
                       ->latest()
                       ->take(5)
                       ->get();

    return view('home', compact('articles'));
}


public function showArticles(Category $category)
{
    $articles = $category->articles()
                         ->whereNotNull('category_id')
                         ->where('category_id', '!=', 0)
                         ->get();

    return view('article.categories', compact('articles', 'category'));
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
