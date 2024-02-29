@extends('home.parent')

@section('content')
    <div class="row">
        <div class="card p4">
            <h3>Create Category</h3>

            {{-- route store --}}
            {{-- untuk melakukan penambahan data --}}
            {{-- untuk enctype melakukan input karena ada upload berupa file --}}
            <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                {{-- csrf sebagai token authentikasi --}}
                @csrf
                {{-- jenis method yang digunakan --}}
                @method('POST')
{{-- 5 --}}
                <div class="col-12">
                    <label for="inputName" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="inputName" name="name" value="{{ old('name') }}">
                </div>

                <div class="col-12">
                    <label for="inputImage" class="form-label">Category Image</label>
                    <input type="file" class="form-control" id="inputImage" name="image">
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary mt-2">
                        <i class="bi bi-plus"></i>
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
