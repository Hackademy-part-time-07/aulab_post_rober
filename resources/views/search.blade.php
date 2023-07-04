<x-layout>
    <x-slot name="title">Search Results</x-slot>

    <h1 style="text-align: center;">Resultados de búsqueda</h1>

    <p style="text-align: center;">Término buscado: <b>{{ $searchTerm }}</b></p>

    <div class="card-columns" style="display: flex; justify-conten: spacearound; padding-bottom: -100px; margin: 20px;">
        @foreach ($articles as $article)
            <div class="card" style="margin-bottom: 50px; border: none;">
                <img src="{{ $article->image }}" class="card-img-top" alt="Article Image" style=" width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text">{{ $article->subtitle }}</p>
                    <p class="card-text">{{ $article->body }}</p>
                    <p class="card-text">Created At: {{ $article->created_at }}</p>
                    <p class="card-text">{{ $article->user->name }}</p>
                    <p class="card-text">Tags:
                        <ul class="list-inline">
                            @foreach ($article->tags as $tag)
                                <li class="list-inline-item">
                                    <a href="{{ route('tags.showArticlesByTag', $tag->id) }}" class="badge badge-secondary">{{ $tag->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </p>
                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary">View Article</a>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>