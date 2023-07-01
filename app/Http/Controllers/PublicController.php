<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\CareerRequestMail;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;




class PublicController extends Controller
{
    
public function welcome(){
    return view('welcome');
  }


  public function contruct (){
    $this->middleware ('auth')->except('welcome');
  }


  public function careers(){
    return view('careers');
  }



  


  public function store(Request $request)
{
    // Validar y procesar los datos del formulario
    $role = $request->input('papel');
    $message = $request->input('mensaje');

    $email = auth()->user()->email; // Obtener el correo electrónico del usuario registrado
   
    // Envía el correo electrónico a través de Mailtrap
    Mail::to('mailtrap-email@example.com')->send(new CareerRequestMail($role, $message, $email));
    
    // Redirige al usuario a la ruta "home" con un mensaje de éxito
    return redirect()->route('home')->with('success', 'Correo electrónico enviado correctamente.');
}

  

  

}



 