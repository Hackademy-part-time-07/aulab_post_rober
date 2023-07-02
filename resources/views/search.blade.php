<x-layout>
    <x-slot name="title">Search Results</x-slot>

    <h1>Search Results</h1>

    <p>Search Term: {{ $searchTerm }}</p>

    <div class="card-columns">
        @foreach ($articles as $article)
            <div class="card">
                <img src="{{ $article->image }}" class="card-img-top" alt="Article Image" width="250px">
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text">{{ $article->subtitle }}</p>
                    <p class="card-text">{{ $article->body }}</p>
                    <p class="card-text">Created At: {{ $article->created_at }}</p>
                    <p class="card-text">{{ $article->user->name }}</p>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>
