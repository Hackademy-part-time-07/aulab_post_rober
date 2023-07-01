<x-layout>
    <div class="container">
        <h1>Articles by {{ $articles->first()->user->name }}</h1>
        
        @foreach ($articles as $article)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $article->subtitle }}</h6>
                    <p class="card-text">{{ $article->body }}</p>
                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary">Read More</a>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>
