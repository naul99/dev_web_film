<div class="navbar-container">
    <div class="container">
        <nav class="navbar halim-navbar main-navigation" role="navigation" data-dropdown-hover="1">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#halim"
                    aria-expanded="false">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
              
                <button type="button" class="navbar-toggle collapsed pull-right get-bookmark-on-mobile">
                    Bookmarks <i class="fa fa-bookmark" aria-hidden="true"></i>
                    <span class="count">0</span>
                </button>
               
                   
                {{-- @guest('customer')

                <button type="button" class="navbar-toggle collapsed pull-right get-locphim-on-mobile">
                    
                    <a data-toggle="modal" data-target="#exampleModal1" style="color: #ced4da;">Login </a>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div style="background-color: #1b2b3c;" class="modal-header">
                                <h3 style="color: #ffff;" class="modal-title text-center">
                                    LOGIN:
                                </h3>
                               
                            </div>
                            <div style="background-color: #1b2b3c;" class="modal-body">
                                <div>
                                    <a href="{{ route('social-github-login') }}" class="btn-login-with bg3 m-b-10 delete">
                                        <i class="fa-brands fa-github"></i>
                                        Login with Github
                                    </a>
                                    <a href="{{ route('social-facebook-login') }}" class="btn-login-with bg1 m-b-10">
                                        <i class="fa-brands fa-facebook"></i>
                                        Login with Facebook
                                    </a>
                
                                    <a href="{{ route('social-google-login') }}" class="btn-login-with bg2 m-b-10">
                                        <i class="fa-brands fa-google"></i>
                                        Login with Google
                                    </a>
                                </div>
                            </div>
                            <div style="background-color: #1b2b3c;" class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                @else

              
                <button class="navbar-toggle collapsed pull-right get-locphim-on-mobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::guard('customer')->user()->name }}
                </button>
              
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="{{ route('register-package') }}">Đăng ký gói phim</a></li>
                    <li><a class="dropdown-item" href="{{ route('history-order') }}">Đăng ký gói phim</a></li>
                    <li><a class="dropdown-item" href="{{ route('history') }}">History</a></li>
                     <li><a class="dropdown-item" href="{{ route('sociallogout') }}">Logout</a></li>
                 
                </ul>
                @endguest --}}
                
            </div>
            <div class="collapse navbar-collapse" id="halim">
                <div class="menu-menu_1-container">
                    <ul id="menu-menu_1" class="nav navbar-nav navbar-left">
                        <li class="current-menu-item active"><a title="Trang Chủ" href="{{ route('homepage') }}">Trang
                                Chủ</a></li>
                        @foreach ($category as $key => $cate)
                            <li class="mega"><a title="{{ $cate->title }}"
                                    href="{{ route('category', $cate->slug) }}">{{ $cate->title }}</a></li>
                        @endforeach

                        <li class="mega dropdown">
                            <a title="Thể Loại" href="#" data-toggle="dropdown" class="dropdown-toggle"
                                aria-haspopup="true">Thể Loại <span class="caret"></span></a>
                            <ul role="menu" class=" dropdown-menu">
                                @foreach ($genre as $key => $gen)
                                    <li><a title="{{ $gen->title }}"
                                            href="{{ route('genre', $gen->slug) }}">{{ $gen->title }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="mega dropdown">
                            <a title="Quốc Gia" href="#" data-toggle="dropdown" class="dropdown-toggle"
                                aria-haspopup="true">Quốc Gia <span class="caret"></span></a>
                            <ul role="menu" class=" dropdown-menu">
                                @foreach ($country as $key => $count)
                                    <li><a title="{{ $count->title }}"
                                            href="{{ route('country', $count->slug) }}">{{ $count->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="mega dropdown">
                            <a title="Năm phim" href="#" data-toggle="dropdown" class="dropdown-toggle"
                                aria-haspopup="true">Năm phim <span class="caret"></span></a>
                            <ul role="menu" class=" dropdown-menu">
                                <li><a href="{{ url('nam/more') }}">Khác</a>
                            </li>
                                @for ($year = 2000; $year <= now()->year; $year++)
                                    <li><a title="{{ $year }}"
                                            href="{{ url('nam/' . $year) }}">{{ $year }}</a>
                                    </li>
                                @endfor
                            </ul>
                        </li>
                        <!-- <li><a title="Phim Lẻ" href="danhmuc.php">Phim Lẻ</a></li>
                    <li><a title="Phim Bộ" href="danhmuc.php">Phim Bộ</a></li>
                    <li><a title="Phim Chiếu Rạp" href="danhmuc.php">Phim Chiếu Rạp</a></li> -->
                    </ul>
                </div>
                <ul class="nav navbar-nav navbar-left" style="background:#000;">
                    <li><a href="{{ route('all-movies') }}" style="color: #ffed4d;">Tất Cả Phim</a></li>
                </ul>
            </div>
        </nav>
        <div class="collapse navbar-collapse" id="search-form">
            <div id="mobile-search-form" class="halim-search-form"></div>
        </div>
        <div class="collapse navbar-collapse" id="user-info">
            <div id="mobile-user-login"></div>
        </div>
    </div>
</div>
