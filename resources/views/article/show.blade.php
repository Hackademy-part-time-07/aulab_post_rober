<x-layout>
    <div class="container" style="margin-top: 30px; margin-bottom: 80px;">
        <div class="card">
            <img src="{{ asset($article->image) }}" class="card-img-top" alt="Article Image" width="250px" style="margin-left: 0px;">
            <div class="card-body">
                <h5 class="card-title">{{ $article->title }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $article->subtitle }}</h6>
                <p class="card-text">{{ $article->body }}</p>
                <p class="card-text">Author: <a href="{{ route('articles.showByAuthor', $article->user) }}">{{ $article->user->name }}</a></p>
                <p class="card-text">Created at: {{ $article->created_at }}</p>
                <p class="card-text">Categories:</p>
                        <ul>
                            @foreach ($article->categories as $category)
                                <li>
                                    <a href="{{ route('categories.showArticlesCategory', $category->id) }}">{{ $category->name ?? 'N/A' }}</a>
                                </li>
                            @endforeach
                        </ul>
            </div>
        </div>
    </div>
</x-layout>

