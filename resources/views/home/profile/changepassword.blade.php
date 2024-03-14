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

            <h3 class="card-title">Change Password</h3>
            <form action="{{ route('profile.updatepassword') }}" method="post">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Current Password</label>
                    <div class="col-sm-10">
                        <input name="current_password" type="password" class="form-control" placeholder="Current Password">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">New Password</label>
                    <div class="col-sm-10">
                        <input name="password" type="password" class="form-control" placeholder="New Password">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Confirmation Password</label>
                    <div class="col-sm-10">
                        <input name="confirmation_password" type="password" class="form-control"
                            placeholder="Confirmation Password">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Change Password</button>
            </form>
        </div>
    </div>
@endsection
