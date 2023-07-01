<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\CareerRequestMail;
use App\Models\User;



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



  public function careersSubmit(Request $request)
{
    $request->validate([
        'role' => 'required',
        'email' => 'required|email', // Se corrigió el nombre del validador "require" a "required"
        'message' => 'required',
    ]);
    $user = Auth::user();
    $role = $request->role;
    $email = $request->email;
    $message = $request->message;

    // Se elimina la línea de código "$user = Auth::user();" ya que no es necesario en este contexto
    Mail::to('admin@theaulabpost.es')->send(new CareerRequestMail(compact('role', 'email', 'message')));
    switch ($role) {
      case 'admin':
          $user->is_admin = null;
          break;

      case 'revisor':
          $user->is_revisor = null;
          break;

      case 'writer':
          $user->is_writer = null;
          break;
  }

  $user->save(); // Se guarda el modelo User después de actualizar las propiedades

  return redirect(route('home'))->with('message', '¡Gracias por su interés!');
}

}



 