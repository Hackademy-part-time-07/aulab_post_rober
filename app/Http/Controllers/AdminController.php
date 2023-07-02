<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tag;


class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $query = User::query();

        // Verificar si se envió un valor de búsqueda
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%$search%");
        }

        // Obtener los últimos dos usuarios registrados en la base de datos
        $users = $query->latest()->take(10)->get();

        // Retornar la vista del panel de administración con los datos necesarios
        return view('admin.dashboard', ['users' => $users]);
    }


    
public function toggleVisibility(Request $request, $id)
{
    $article = Article::findOrFail($id);

    if (auth()->user()->is_revisor) {
        $article->visibility = $request->has('visibility') ? 'public' : 'private';
        $article->save();
    }

    return redirect()->route('dashboardrev');
}

public function index()
{
    $articles = Article::whereNull('category_id')->get();

    return view('admin.dashboard', ['articles' => $articles]);
}

public function updateCategory(Request $request, $id)
{
    $article = Article::findOrFail($id);
    $article->category_id = $request->input('category_id');
    $article->save();

    return redirect()->route('home')->with('success', 'Categoría actualizada correctamente');
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

    return view('dashboardrev')->with('articles', $articles);
}

public function searchByTag($tagId)
{
    $tag = Tag::findOrFail($tagId);

    // Obtener todas las noticias relacionadas con el tag
    $articles = $tag->articles;

    // Aquí puedes pasar los datos a una vista para mostrar los resultados
    return view('admin.search_results', compact('articles'));
}




    public function updateRole(Request $request, $userId)
{
    $user = User::findOrFail($userId);

    // Verificar si el usuario autenticado tiene el rol de administrador
    if (auth()->user()->is_admin == 1) {
        // Actualizar los campos id_writer e id_revisor según los valores enviados en el formulario
        $user->is_writer = $request->has('is_writer') ? 1 : 0;
        $user->is_revisor = $request->has('is_revisor') ? 1 : 0;
        $user->save();

        // Redireccionar al panel de administración
        return redirect()->route('dashboard');
    } else {
        // Redireccionar al inicio u otra página de tu elección si el usuario no es un administrador
        return redirect()->route('home');
    }
}


public function deleteArticle($id)
{
    $article = Article::findOrFail($id);
    
    // Perform any necessary checks or validations before deleting the article
    
    $article->delete();
    
    return redirect()->back()->with('success', 'Article deleted successfully.');
}



    
    
}
