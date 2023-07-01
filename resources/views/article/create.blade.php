<x-layout>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Article</div>

                <div class="card-body">
                    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="subtitle">Subtitle</label>
                            <input type="text" class="form-control" id="subtitle" name="subtitle" required>
                        </div>

                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea class="form-control" id="body" name="body" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>

                        @auth
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endauth

                        <div class="form-group">
                            <label for="category_id">Categories</label>
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category_id[]" id="category_{{ $category->id }}" value="{{ $category->id }}">
                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">Create</button>
                   
                        @guest
                        <p>Solo los usuarios registrados autorizados pueden crear contenido.</p>
                    @endguest
                    @if($user->is_writer == 0)
    <div class="alert alert-info">
        No tienes permisos para crear artículos. Si deseas colaborar, contáctanos en la sección de careers.
    </div>
@endif

                   
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
