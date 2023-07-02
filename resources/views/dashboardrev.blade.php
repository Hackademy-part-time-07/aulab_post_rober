<x-layout>
    <x-slot name="title">
        Admin Panel
    </x-slot>
    
        <form action="{{ route('admin.searchArticles') }}" method="GET" class="my-4">
            <div class="flex items-center">
                <select name="date_filter" class="border border-gray-300 px-4 py-2 mr-2">
                    <option value="">Seleccionar fecha</option>
                    <option value="1_hour">Última hora</option>
                    <option value="12_hours">Últimas 12 horas</option>
                    <option value="24_hours">Últimas 24 horas</option>
                    <option value="3_days">Últimos 3 días</option>
                    <option value="7_days">Últimos 7 días</option>
                    <option value="15_days">Últimos 15 días</option>
                    <option value="1_month">Último mes</option>
                    <option value="3_months">Últimos 3 meses</option>
                    <option value="1_year">Último año</option>
                </select>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
            </div>
        </form>

        <a href="{{ route('home') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Volver al inicio</a>

        <table class="table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Título</th>
                    <th class="px-4 py-2">Subtítulo</th>
                    <th class="px-4 py-2">Imagen</th>
                    <th class="px-4 py-2">Autor</th>
                    <th class="px-4 py-2">Fecha de creación</th>
                    <th class="px-4 py-2">Categoría</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td class="px-4 py-2">{{ $article->title }}</td>
                        <td class="px-4 py-2">{{ $article->subtitle }}</td>
                        <td class="px-4 py-2">
                            @if($article->image)
                                <img src="{{ asset($article->image) }}" class="card-img-top" alt="Article Image" width="25px" height="25px">
                            @else
                                No image available
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $article->user->name }}</td>
                        <td class="px-4 py-2">{{ $article->created_at }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.updateCategory', $article->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="category_id">
                                    <option value="0" {{ $article->category_id === 0 ? 'selected' : '' }}>0</option>
                                    <option value="1" {{ $article->category_id === 1 ? 'selected' : '' }}>1</option>
                                </select>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Modificar</button>
                            </form>
                        </td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.deleteArticle', $article->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</x-layout>
