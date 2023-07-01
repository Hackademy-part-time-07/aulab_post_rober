@props(['title', 'requests'])

<h2>{{ $title }}</h2>

@if ($requests->isEmpty())
    <p>No hay peticiones</p>
@else
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->name }}</td>
                    <td>{{ $request->email }}</td>
                    <td>
                        @if ($request->estado == 'Inactivo')
                            <form method="POST" action="{{ route('admin.approve', $request->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit">Aprobar</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.disapprove', $request->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit">Rechazar</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
