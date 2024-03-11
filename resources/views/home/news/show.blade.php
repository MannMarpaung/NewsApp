@extends('home.parent')

@section('content')
    <div class="row">
        <div class="card p-4">
            <h5 class="card-title">
                {{ $news->title }} - <span
                    class="badge rounded-pill bg-primary text-white">{{ $news->category->name }}</span>
            </h5>

            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('news.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </a>
            </div>

            <img src="{{ $news->image }}" alt="Image News" class="w-100">

            <textarea id="editor" disabled>
                {!! $news->content !!}
            </textarea>
            <script>
                ClassicEditor
                    .create(document.querySelector('#editor'))
                    .then(editor => {
                        console.log(editor);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            </script>

        </div>
    </div>
@endsection
