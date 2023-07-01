<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        $users = $query->latest()->take(2)->get();

        // Retornar la vista del panel de administración con los datos necesarios
        return view('admin.dashboard', ['users' => $users]);
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



    
    
}
