@extends('frontend.parent')

@section('content')
    <section class="single-post-content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 post-content" data-aos="fade-up">
                    <!-- ======= Single Post Content ======= -->
                    <div class="single-post">
                        <div class="post-meta"><span class="date">{{ $news->category->name }}</span> <span class="mx-1">&bullet;</span>
                            <span>{{ $news->created_at->diffForHumans() }}</span>
                        </div>
                        <h1 class="mb-5">{{ $news->title }}</h1>
                        <img src="{{ $news->image }}" alt="" class="img-fluid">
                        <p>
                            {!! $news->content !!}
                        </p>
                    </div>
                    <!-- End Single Post Content -->
                </div>
            </div>
        </div>
    </section>
@endsection
