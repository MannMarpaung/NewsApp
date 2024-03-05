@extends('home.parent')

@section('content')
    <div class="row">
        <div class="card p-4">
            <h3>News Create</h3>

            <form action="{{ route('news.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')

                {{-- field untuk title --}}
                {{-- name berfungsi untuk mengirimkan data ke controller --}}
                {{-- old berfungsi untuk menampilkan kembali inputan user --}}
                <div class="mb-2">
                    <label for="inputTitle" class="form-label">News Name</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" value="{{ old('title') }}">
                </div>

                {{-- field untuk image --}}
                {{-- name berfungsi untuk mengirimkan data ke controller --}}
                {{-- old berfungsi untuk menampilkan kembali inputan user --}}
                <div class="mb-2">
                    <label for="inputImage" class="form-label">News Image</label>
                    <input type="file" class="form-control" id="inputImage" name="image" value="{{ old('image') }}">
                </div>

                <div class="mb-2">
                    <label class="col-sm-2 col-form-label">Select</label>
                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Default select example">
                            <option selected>-=-=- Choose Category -=-=-</option>
                            @foreach ($category as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> 

                {{-- field untuk konten menggunakan CKeditor untuk menampilkan konten --}}
                {{-- name berfungsi untuk mengrimkan data ke controller  --}}
                <div class="mb-2">
                    <label class="col-sm-2 col-form-label">Content News</label>
                    <textarea id="editor" name="content">This is some sample content.</textarea>
                </div>

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
            </form>
        </div>
    </div>
@endsection
