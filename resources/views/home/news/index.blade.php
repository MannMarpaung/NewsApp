@extends('home.parent')

@section('content')
    <div class="row">
        <div class="card p-4">
            <h3>News</h3>
            {{-- alert success --}}
            @if (session('success'))
                <div class="alert alert-success mt-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-end">
                <a href="{{ route('news.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i>
                    News Category
                </a>
            </div>

            <div class="container mt-3">
                <div class="card p-3">
                    <h5 class="card-title">Data News</h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Image News</th>
                                <th>Image Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($news as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->category->name }}</td>
                                    <td>
                                        <img src="{{ $row->image }}" alt="image" width="150" class="rounded">
                                    </td>
                                    <td>
                                        <img src="{{ $row->category->image }}" alt="image" width="150"
                                            class="rounded">
                                    </td>
                                    <td>
                                        <a href="{{ route('news.show', $row->id) }}" class="btn btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('news.edit', $row->id) }}" class="btn btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('news.destroy', $row->id) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <p class="text-center">Data Masih Kosong</p>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- paginate --}}
                    {{ $news->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
