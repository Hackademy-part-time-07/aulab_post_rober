<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\CareerRequestMail;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


class PublicController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function careers()
    {
        return view('careers');
    }

    public function store(Request $request)
    {
        // Validar y procesar los datos del formulario
        $role = $request->input('papel');
        $mensaje = $request->input('mensaje');

        $user = Auth::user(); // Obtener el usuario autenticado
        $email = $user->email; // Obtener el correo electrónico del usuario registrado

        // Envía el correo electrónico a través de Mailtrap
        Mail::to('mailtrap-email@example.com')->send(new CareerRequestMail($role, $mensaje, $email));

        // Redirige al usuario a la ruta "home" con un mensaje de éxito
        return redirect()->route('home')->with('success', 'Correo electrónico enviado correctamente.');
    }

    public function forgotpassword(Request $request, $email, $token = null)
{
    // Verificar si el usuario ya está autenticado
    
    return view('auth/forgotpassword', compact('email', 'token'));
}

    public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'nullable',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8',
    ]);

    $resetStatus = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Password::getRepository()->createNewToken())
              ->save();

            event(new PasswordReset($user));
        }
    );

    if ($resetStatus === Password::PASSWORD_RESET) {
        // Cerrar sesión del usuario si es necesario
        Auth::logout();

        return redirect()->route('login')->with('success', 'La contraseña se ha restablecido correctamente. Por favor, inicia sesión con tu nueva contraseña.');
    } else {
        return back()->withInput($request->only('email'))->withErrors(['email' => __($resetStatus)]);
    }
}

}
