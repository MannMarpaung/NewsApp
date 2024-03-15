@extends('home.parent')

@section('content')
    <div class="row">
        <div class="card p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- alert success --}}
            @if (session('success'))
                <div class="alert alert-success mt-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- alert error --}}
            @if (session('error'))
                <div class="alert alert-danger mt-4">
                    {{ session('error') }}
                </div>
            @endif
            <h3 class="card-title">Edit Profile {{ Auth::user()->name }}</h3>

            <form action="{{ route('updateProfile') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col mb-3 mt-3">
                    <label for="" class="form-label">First Profile</label>
                    <input type="text" class="form-control" name="first_name" value="{{ $user->profile->first_name }}">
                </div>
                <div class="col mb-3 mt-3">
                    <label for="" class="form-label">Image Profile</label>
                    <input type="file" class="form-control" name="image">
                </div>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-pencil"></i>
                    Update Profile
                </button>
            </form>
        </div>
    </div>
@endsection
