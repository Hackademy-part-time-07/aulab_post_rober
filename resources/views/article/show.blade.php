<x-layout>
    <div class="container">
        <div class="card">
            <img src="{{ asset($article->image) }}" class="card-img-top" alt="Article Image" width="250px">
            <div class="card-body">
                <h5 class="card-title">{{ $article->title }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $article->subtitle }}</h6>
                <p class="card-text">{{ $article->body }}</p>
                <p class="card-text">Author: {{ $article->user->name }}</p>
                <p class="card-text">Created at: {{ $article->created_at }}</p>
            </div>
        </div>
    </div>
</x-layout>

