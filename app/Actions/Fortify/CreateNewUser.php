<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\PasswordValidationRules;

class CreateNewUser
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     * @return \App\Models\User|\Illuminate\Http\RedirectResponse
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Devolver el usuario creado
        return $user;
    }
}

// Ejemplo de uso en un controlador
class UserController extends Controller
{
    public function register(Request $request)
    {
        $user = app(CreateNewUser::class)->create($request->all());

        // Verificar si se creó correctamente el usuario
        if ($user instanceof User) {
            // Redirigir al usuario al home después de crearlo
            return redirect('/home');
        } else {
            // Devolver una respuesta de error o redirigir a una página de error
            return response()->view('error', ['message' => 'Error al crear el usuario']);
        }
    }
}
