<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class UserAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario es administrador
        $user = $request->user();
        if ($user && $user->id_admin == 1) {
            // Obtener todos los usuarios excepto el actual
            $users = User::where('id', '!=', $user->id)->get();

            // Actualizar los valores en la base de datos
            foreach ($users as $user) {
                $user->id_admin = 1;
                $user->id_writer = 1;
                $user->id_revisor = 1;
                $user->estado = 'Activo';
                $user->save();
            }

            return $next($request);
        }

        abort(403, 'Acceso no autorizado');
    }
}
