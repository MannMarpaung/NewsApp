@extends('home.parent')

@section('content')
    <div class="card p-4">
        <div class="row">
            <div class="col-md-6 justify-content-center">
                <img class="w-75" src="https://ui-avatars.com/api/?background=random&name={{ Auth::user()->name }}"
                    alt="profile-img">
            </div>
            <div class="col-md-6 text-center">
                <h3>Profile Account</h3>
                <ul class="list-group">
                    <li class="list-group-item">Name Account = <strong>{{ Auth::user()->name }}</strong></li>
                    <li class="list-group-item">E-Mail Account = <strong>{{ Auth::user()->email }}</strong></li>
                    <li class="list-group-item">Role Account = <strong>{{ Auth::user()->role }}</strong></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
