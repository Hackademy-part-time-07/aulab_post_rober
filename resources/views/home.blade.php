<x-layout>



    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


  <div class="container-fluid p-5 bg-info text-center text-white">
      <div class="row justify-content-center">
          <h1 class="display-1">Aulab Post</h1>
      </div>
  </div>

  <div class="container">
      <div class="row justify-content-around">
          @foreach ($articles as $article)
              <div class="card">
                  <img src="{{ asset($article->image) }}" class="card-img-top" alt="Article Image"  height="550px">
                  <div class="card-body">
                      <h5 class="card-title">{{ $article->title }}</h5>
                      <h6 class="card-subtitle mb-2 text-muted">{{ $article->subtitle }}</h6>
                      <p class="card-text">{{ $article->body }}</p>
                      <p class="card-text">Categories:</p>
                        <ul>
                            @foreach ($article->categories as $category)
                                <li>
                                    <a href="{{ route('categories.showArticlesCategory', $category->id) }}">{{ $category->name ?? 'N/A' }}</a>
                                </li>
                            @endforeach
                        </ul>
                      <p class="card-text">Author: <a href="{{ route('articles.showByAuthor', $article->user) }}">{{ $article->user->name }}</a></p>

                      <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary">Read More</a>
                  </div>
              </div>
          @endforeach
      </div>
    @guest
        Si quieres saber como puedes colaborar tienes que estar registrado.
    @endguest
  </div>

</x-layout>
