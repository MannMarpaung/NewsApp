<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- Home --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li>


        {{-- Category & News --}}
        @if (Auth::user()->role == 'admin')
            {{-- ALL USER --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('allUser') }}">
                    <i class="bi bi-grid"></i>
                    <span>User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Menu</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('category.index') }}">
                            <i class="bi bi-circle"></i><span>Category</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('news.index') }}">
                            <i class="bi bi-circle"></i><span>News</span>
                        </a>
                    </li>
                </ul>
            </li>
        @else
        @endif

        <!-- End Dashboard Nav -->

    </ul>

</aside>
