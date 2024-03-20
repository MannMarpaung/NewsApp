@extends('frontend.parent')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-9" data-aos="fade-up">
                    <h3 class="category-title">Category: {{ $detailCategory->name }}</h3>

                    @foreach ($detailCategory as $row)
                        <div class="d-md-flex post-entry-2 half">
                            <a href="single-post.html" class="me-4 thumbnail">
                                <img src="assets/img/post-landscape-6.jpg" alt="" class="img-fluid">
                            </a>
                            <div>
                                <div class="post-meta"><span class="date">{{ $detailCategory->name }}</span> <span
                                        class="mx-1">&bullet;</span>
                                    <span>Jul
                                        5th '22</span>
                                </div>
                                <h3><a href="single-post.html">What is the son of Football Coach John Gruden, Deuce Gruden
                                        doing
                                        Now?</a></h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio placeat
                                    exercitationem
                                    magni
                                    voluptates dolore. Tenetur fugiat voluptates quas, nobis error deserunt aliquam
                                    temporibus
                                    sapiente,
                                    laudantium dolorum itaque libero eos deleniti?</p>
                                <div class="d-flex align-items-center author">
                                    <div class="photo"><img src="assets/img/person-2.jpg" alt="" class="img-fluid">
                                    </div>
                                    <div class="name">
                                        <h3 class="m-0 p-0">Admin</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="col-md-3">
                    <!-- ======= Sidebar ======= -->
                    <div class="aside-block">

                        <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">
                            @foreach ($category as $index => $row)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $index == 0 ? 'active' : '' }}" id="pills-{{ $row->slug }}-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-{{ $row->slug }}" type="button" role="tab"
                                        aria-controls="pills-{{ $row->slug }}"
                                        aria-selected="false">{{ $row->name }}</button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content" id="pills-tabContent">

                            @foreach ($category as $index => $row)
                                <!-- Category -->
                                <div class="tab-pane fade {{ $index == 0 ? 'active' : '' }} {{ $index == 0 ? 'show' : '' }}" id="pills-{{ $row->slug }}" role="tabpanel"
                                    aria-labelledby="pills-{{ $row->slug }}-tab">

                                    @foreach ($row->news as $news)
                                        <div class="post-entry-1 border-bottom">
                                            <div class="post-meta"><span class="date">{{ $row->name }}</span> <span
                                                    class="mx-1">&bullet;</span>
                                                <span>{{ $news->created_at->diffForHumans() }}</span></div>
                                            <h2 class="mb-2"><a href="#">{{ $news->title }}</a></h2>
                                            <span class="author mb-3 d-block">Admin</span>
                                        </div>
                                    @endforeach

                                </div> <!-- End Category -->
                            @endforeach


                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
