<x-layout>

  <div class="container-fluid p-5 bg-info text-center text-white">
      <div class="row justify-content-center">
          <h1 class="display-1">Aulab Post</h1>
      </div>
  </div>

  <div class="container">
      <div class="row justify-content-around">
          @foreach ($articles as $article)
              <div class="card">
                  <img src="{{ asset($article->image) }}" class="card-img-top" alt="Article Image" width="250px">
                  <div class="card-body">
                      <h5 class="card-title">{{ $article->title }}</h5>
                      <h6 class="card-subtitle mb-2 text-muted">{{ $article->subtitle }}</h6>
                      <p class="card-text">{{ $article->body }}</p>
                      <p class="card-text">Author: {{ $article->user->name }}</p>
                      <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary">Read More</a>
                  </div>
              </div>
          @endforeach
      </div>
  </div>

</x-layout>
