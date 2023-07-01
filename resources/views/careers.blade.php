<x-layout>
    <h1>Trabaja con nosotros</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Formulario de solicitud</div>

                <div class="card-body">
                    @if(Auth::check())
                        <form action="/solicitud" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="papel">Seleccione el papel que desea solicitar:</label>
                                <select id="papel" name="papel" class="form-control">
                                    <option value="admin">Administrador</option>
                                    <option value="revisor">Editor</option>
                                    <option value="writer">Escritor</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="correo">Correo electrónico:</label>
                                <input type="email" id="correo" name="correo" value="{{ Auth::user()->email }}" class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label for="mensaje">Mensaje de presentación:</label>
                                <textarea id="mensaje" name="mensaje" rows="5" class="form-control" placeholder="Escribe aquí tu mensaje de presentación"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Enviar solicitud</button>
                        </form>
                    @else
                        <p>Debes iniciar sesión para enviar una solicitud.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>
