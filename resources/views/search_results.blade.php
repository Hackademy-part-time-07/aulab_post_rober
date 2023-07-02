<x-layout>
    <x-slot name="title">
        Search Results
    </x-slot>
    
    <div class="container">
        <h1>Search Results</h1>
        
        @if ($articles->isEmpty())
            <p>No articles found.</p>
        @else
            <ul>
                @foreach ($articles as $article)
                    <li>
                        <h2>{{ $article->title }}</h2>
                        <p>{{ $article->body }}</p>
                        <!-- Mostrar más información del artículo si es necesario -->
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layout>
