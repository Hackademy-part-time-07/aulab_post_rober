<x-layout>
    <div class="container" style="display: flex; justify-content: center; margin-top: 30px; margin-bottom:30px;">
        <div class="row justify-content-around">
            @foreach ($articles as $article)
                <div class="card">
                    <img src="{{ asset($article->image) }}" class="card-img-top" alt="Article Image" width="250px" height="550px" style="margin-left: -12px;">

                    <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $article->subtitle }}</h6>
                        <p class="card-text">{{ $article->body }}</p>
                        <p class="card-text">Created at: {{ $article->created_at }}</p>
                        <p class="card-text">Author: <a href="{{ route('articles.showByAuthor', $article->user) }}">{{ $article->user->name }}</a></p>

                        <p class="card-text">Categories:</p>
                        <ul>
                            @foreach ($article->categories as $category)
                                <li>
                                    {{ $category->name }}
                                </li>
                            @endforeach
                        </ul>

                        <p class="card-text">Tags:</p>
                        <ul>
                            @foreach ($article->tags as $tag)
                                <li>
                                    {{ $tag->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
