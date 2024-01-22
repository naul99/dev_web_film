<!DOCTYPE html>
<html lang="vi" xml:lang="vi">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-C35F1JQ8ZJ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-C35F1JQ8ZJ');
    </script>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <meta content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta name="theme-color" content="#234556">
    <meta content="VN" name="geo.region" />
    <meta name="DC.language" scheme="utf-8" content="vi" />
    <meta name="language" content="Việt Nam, English">
    <link rel="shortcut icon" href="{{ asset('uploads/logo/Old-Video-Cam-icon.ico') }}" type="image/x-icon" />
    <meta name="revisit-after" content="1 days" />
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @if (isset($tapphim) && $movie->thuocphim == 1)
        <title>
            Tập {{ $tapphim }} - {{ $movie->title }} | FullHDPhim
        </title>
    @elseif (isset($movie->slug))
        <title>
            {{ $movie->title }} - Phim Chất Lượng Cao | FullHDPhim
        </title>
    @else
        <title>FullHDPhim | Xem Phim Chất Lượng Tốt Nhất</title>
    @endif
    @if (!isset($movie->slug))
        <meta name="description"
            content="Fullhdphim, Phim hay - Xem phim hay nhất, xem phim online miễn phí, phim nhanh, Xem Phim Online, Phim Vietsub, Xem Phim Hay, phim HD , phim hot ,phim mới, phim bom tấn" />
    @else
        <meta name="description"
            content="Xem Phim {{ $movie->title }} - {{ $movie->name_english }} ({{ $movie->year }})" />
    @endif
    @if (!isset($movie->slug))
        <meta name="title" content="FullHDPhim | Xem Phim Chất Lượng Tốt Nhất" />
    @else
        <meta name="title" content="Phim {{ $movie->title }} [Full HD], {{ $movie->name_english }}" />
    @endif
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="next" href="" />
    <meta property="og:locale" content="vi_VN" />
    @if (!isset($movie->slug))
        <meta property="og:title" content="Phim hay 2023 - Xem phim hay nhất" />
    @else
        <meta property="og:title" content="Phim {{ $movie->title }} [Full HD], {{ $movie->name_english }}" />
    @endif
    <meta property="og:type" content="website" />
    @if (!isset($movie->slug))
        <meta property="og:url" content="{{ route('homepage') }}" />
    @else
        <meta property="og:url" content="{{ route('homepage') }}/movie/{{ $movie->slug }}" />
    @endif
    @if (!isset($movie->slug))
        <meta property="og:description"
            content="Phim hay 2023 - Xem phim hay nhất, phim hay trung quốc, hàn quốc, việt nam, mỹ, hong kong , chiếu rạp" />
    @else
        <meta property="og:description"
            content="Xem Phim {{ $movie->title }} - {{ $movie->name_english }} ({{ $movie->year }})" />
    @endif
    <meta property="og:site_name" content="fullhdphim.click" />
    @if (!isset($movie->slug))
        <meta property="og:image" content="" />
    @else
        <meta property="og:image" content="{{ asset('uploads/movie/' . $movie->movie_image->image) }}" />
    @endif
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />
    @if (!isset($movie->slug))
        <meta name="keywords"
            content="Phim, xem phim, xem phim online, phim online, xem phim hd, phim vietsub, phim thuyet minh, fullhdphim" />
    @else
        <meta name="keywords"
            content="xem phim {{ $movie->title }},xem phim {{ $movie->title }} vietsub,xem phim {{ $movie->title }} online,xem phim {{ $movie->title }} bluray,xem phim {{ $movie->title }} hd,xem phim {{ $movie->title }} full hd,xem phim {{ $movie->title }} 1080p,xem phim {{ $movie->title }} vietsub online,xem phim {{ $movie->title }} free,xem phim {{ $movie->title }} miễn ph&#237;,xem online, phim chất lượng, si&#234;u n&#233;t, bluray,fullhd, xem phim {{ $movie->name_english }}" />
    @endif


    @if (!isset($movie->slug))
        <link rel="canonical" href="{{ route('homepage') }}" />
    @else
        <link rel="canonical" href="{{ route('homepage') }}/movie/{{ $movie->slug }}" />
    @endif

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    @yield('css')
    <link rel='dns-prefetch' href='//s.w.org' />
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' id='bootstrap-css' href='/css/bootstrap.min.css?ver=5.7.2' media='all' />
    <link rel='stylesheet' id='style-css' href='/css/style.css?ver=5.7.2' media='all' />
    <link rel='stylesheet' id='wp-block-library-css' href='/css/style.min.css?ver=5.7.2' media='all' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="/templatelogin/css/util.css">
    <link rel="stylesheet" type="text/css" href="/templatelogin/css/main.css">
    <script type='text/javascript' src='/js/jquery.min.js?ver=5.7.2' id='halim-jquery-js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.4.0/jquery-migrate.min.js"
        integrity="sha512-QDsjSX1mStBIAnNXx31dyvw4wVdHjonOwrkaIhpiIlzqGUCdsI62MwQtHpJF+Npy2SmSlGSROoNWQCOFpqbsOg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"
        integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        #header .site-title {
            background: url({{ asset('uploads/logo/' . $info->logo) }}) no-repeat top left;
            background-size: contain;
            text-indent: -9999px;

        }
    </style>


</head>

<body id="myDiv" class="home blog halimthemes halimmovies" data-masonry="">

    <header id="header">
        <div class="container">
            <div class="row" id="headwrap">
                <div class="col-md-2 col-sm-6 slogan">
                    <p class="site-title"><a class="logo" href="{{ route('homepage') }}"
                            title="Xem Phim Chất Lượng Tốt Nhất ">
                    </p>
                    </a>
                </div>
                <div class="col-md-5 col-sm-6 halim-search-form">
                    <div class="header-nav">
                        <div class="col-xs-12">
                            <style type="text/css">
                                ul#result {
                                    position: absolute;
                                    z-index: 9999;
                                    background: #1b2b3c;
                                    width: 94%;
                                    padding: 10px;
                                    margin: 1px;
                                }
                            </style>
                            <div class="form-group form-timkiem" style="margin: 2%;">

                                <div class="input-group col-xs-12">

                                    <form action="{{ route('tim-kiem') }}" method="GET">
                                        <input id="timkiem" type="text" name="search" class="form-control"
                                            placeholder="Nhập tên phim hoặc tên diễn viên... or press (/)"
                                            autocomplete="off" oninput="validateInput(this)" required>
                                    </form>
                                    <i class="animate-spin hl-spin4 hidden"></i>

                                </div>
                            </div>

                            <ul style="display: none; 
                            height: 450px;
                            width: 90%;
                            overflow-x: hidden;
                            overflow-y: scroll;"
                                class="list-group" id="result"> </ul>
                            <ul class="ui-autocomplete ajax-results hidden"></ul>
                        </div>
                    </div>
                </div>
                {{-- @guest('customer')
                    <style>
                        @media (min-width: 601px) and (max-width: 900px) {
                            .response_mobile {
                                display: none;
                            }
                        }
                    </style> --}}
                    {{-- <div class="col-md-2 hidden-xs response_mobile">

                        <div id="get-bookmark" class="box-shadow">
                           
                            <!-- Button trigger modal -->
                            <a  data-toggle="modal" data-target="#exampleModal">
                                Login
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div style="background-color: #1b2b3c;border-bottom:none;" class="modal-header">
                                            <h3 style="color: #d7dfe4;" class="modal-title text-center">
                                                LOGIN:
                                            </h3>
                                           
                                        </div>
                                        <div style="background-color: #1b2b3c;" class="modal-body">
                                            <div>
                                                <a href="{{ route('social-github-login') }}"
                                                    class="btn-login-with bg3 m-b-10 delete">
                                                    <i class="fa-brands fa-github"></i>
                                                    Login with Github
                                                </a>
                                                <a href="{{ route('social-facebook-login') }}"
                                                    class="btn-login-with bg1 m-b-10">
                                                    <i class="fa-brands fa-facebook"></i>
                                                    Login with Facebook
                                                </a>

                                                <a href="{{ route('social-google-login') }}"
                                                    class="btn-login-with bg2 m-b-10">
                                                    <i class="fa-brands fa-google"></i>
                                                    Login with Google
                                                </a>
                                            </div>
                                        </div>
                                        <div style="background-color: #1b2b3c;border-top:none;" class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> --}}
                {{-- @else
                    <div class="col-md-2 hidden-xs response_mobile">

                        <button class="btn btn-secondary dropdown-toggle" role="button" id="get-bookmark"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::guard('customer')->user()->name }}
                        </button>


                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('register-package') }}">Đăng ký gói phim</a></li>
                            <li><a class="dropdown-item" href="{{ route('history-order') }}">Lịch sử mua gói</a></li>
                            <li><a class="dropdown-item" href="{{ route('history') }}">History</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('sociallogout') }}">Logout</a></li>

                        </ul>
                    </div>
                @endguest --}}


                <div class="col-md-3 hidden-xs response_mobile">

                    <div id="get-bookmark" class="box-shadow">
                        <a href="javascript:void(0)" onClick="return rudr_favorite(this);">
                            <i class="bi bi-bookmark"></i>
                            <span> Bookmarks
                            </span>
                            <span class="count">0</span>
                        </a>
                    </div>
                    <div id="bookmark-list" class="hidden bookmark-list-on-pc">
                        <ul style="margin: 0;"></ul>
                    </div>
                </div>

            </div>
        </div>
    </header>
    @include('nav')
    </div>

    <div class="container">
        <div class="row fullwith-slider"></div>
    </div>
    <div class="container">
        @yield('content')
    </div>
    <div class="clearfix"></div>

    @include('footer')

    <div id='easy-top'></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script type='text/javascript' src='{{ asset('js/bootstrap.min.js?ver=5.7.2') }}' id='bootstrap-js'></script>
    <script type='text/javascript' src='{{ asset('js/owl.carousel.min.js?ver=5.7.2') }}' id='carousel-js'></script>

    <script type='text/javascript' src='{{ asset('js/halimtheme-core.min.js?ver=1626273138') }}' id='halim-init-js'>
    </script>

    @if (session('status'))
        <script>
            $(document).ready(function(event) {
                swal({
                    title: 'Thành công!',
                    text: 'Đăng nhập thành công, chúc bạn xem phim vui vẽ!',
                    icon: 'success',
                    buttons: "Yes!",
                })
            });
        </script>
    @elseif (session('status_warning'))
        <script>
            $(document).ready(function(event) {
                swal({
                    title: 'Cảnh báo!',
                    text: 'USERNAME" TRONG TÀI KHOẢN GITHUB CỦA BẠN KHÔNG ĐƯỢC ĐỂ TRỐNG!',
                    icon: 'warning',
                    buttons: "Yes!",
                })
            });
        </script>
    @elseif (session('status_error'))
        <script>
            $(document).ready(function(event) {
                swal({
                    title: 'Thất bại!',
                    text: '{{ session('status_error') }}',
                    icon: 'error',
                    buttons: "Yes!",
                })
            });
        </script>
    @elseif (session('status_registration'))
        <script>
            $(document).ready(function(event) {
                swal({
                    title: 'Info!',
                    text: ' {{ session('status_registration') }}',
                    icon: 'info',
                    buttons: "Yes!",
                })
            });
        </script>
    @endif
    {{-- <script type="text/javascript">
        $('.history-movies').click(function() {
            @guest('customer')
                var user_id = '0';
            @else
                var user_id = '{{ Auth::guard('customer')->user()->id }}'
            @endguest

            var id = $(this).attr("id");
            //alert(user_id);
            $.ajax({
                url: "{{ route('history-movie') }}",
                method: "GET",
                data: {
                    id: id,
                    user_id: user_id
                },
                success: function(data) {
                    //alert('hhh');
                }
            });
        });
    </script> --}}

    <script type='text/javascript'>
        $(document).ready(function() {
            $('#timkiem').keyup(function() {
                $('#result').html('');
                var search = $('#timkiem').val();

                if (search.length > 0 && search.length < 3) {
                    $('#result').append(
                        '<li class="list-group-item" style="cursor:pointer;">Nhập ít nhất 3 ký tự. </li>'
                    );
                } else if (search != '') {
                    $('#result').css('display', 'inherit');
                    var expression = new RegExp(search, "i");

                    $.getJSON('/json/movie.json', function(data) {

                        $.each(data, function(key, value) {

                            const jsonData = (value.movie_cast);

                            var result = jsonData.map(function(x) {
                                return x.title;
                            });
                            result.forEach(function(cast, index) {
                                if (cast.search(expression) != -1) {

                                    const myArray = (value.movie_image);
                                    const image = (myArray.image);
                                    $('#result').append(
                                        '<li data-search="' + value.slug +
                                        '" class="list-group-item" style="cursor:pointer;"> <img src="/uploads/movie/' +
                                        image +
                                        '" height="40" width="40">' + ' ' +
                                        value.title + ' </li>');
                                }

                            });

                            if (value.title.search(expression) != -1 && value.status == 1) {

                                const myArray = (value.movie_image);
                                const image = (myArray.image);
                                $('#result').append(
                                    '<li data-search="' + value.slug +
                                    '" class="list-group-item" style="cursor:pointer;"> <img src="/uploads/movie/' +
                                    image +
                                    '" height="40" width="40">' + ' ' +
                                    value.title + ' </li>');
                            } else if (value.name_english.search(expression) != -1 && value
                                .status == 1) {

                                const myArray = (value.movie_image);
                                const image = (myArray.image);
                                $('#result').append(
                                    '<li data-search="' + value.slug +
                                    '" class="list-group-item" style="cursor:pointer;"> <img src="/uploads/movie/' +
                                    image +
                                    '" height="40" width="40">' + ' ' +
                                    value.title + ' </li>');
                            }
                        });
                    })
                } else {
                    $('#result').css('display', 'none');
                }
            })
            $('#result').on('click', 'li', function() {
                var click_text = $(this).text().split('->');
                // search live
                var search = ($(this).data("search"));
                location.replace("{{ route('homepage') }}" + '/movie/' + search);

                $('#timkiem').val($.trim(click_text[0]));
                $("#result").html('');
                $('#result').css('display', 'none')

            });
        })
    </script>

    {{-- <script>
        function validateInput(inputField) {
            // Xóa ký tự đặc biệt khỏi giá trị của trường input
            inputField.value = inputField.value.replace(/[^\w\sÀ-ÿẠ-ỹ]/gi, '');
        }
    </script> --}}

    <script>
        // Lấy tham chiếu đến phần tử vùng trống
        var myDiv = document.getElementById("myDiv");

        // Bắt sự kiện khi chuột được nhấp vào vùng trống
        myDiv.addEventListener("click", function(event) {
            // Kiểm tra xem có phải là vùng trống không
            if (event.target === myDiv) {
                // here function
                $('#result').css('display', 'none')
            }
        });
    </script>

    <script type="text/javascript">
        function rudr_favorite(a) {
            pageTitle = document.title;
            pageURL = document.location;
            try {
                // Internet Explorer solution
                eval("window.external.AddFa-vorite(pageURL, pageTitle)".replace(/-/g, ''));
            } catch (e) {
                try {
                    // Mozilla Firefox solution
                    window.sidebar.addPanel(pageTitle, pageURL, "");
                } catch (e) {
                    // Opera solution
                    if (typeof(opera) == "object") {
                        a.rel = "sidebar";
                        a.title = pageTitle;
                        a.url = pageURL;
                        return true;
                    } else {
                        // The rest browsers (i.e Chrome, Safari)
                        alert('Press ' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') +
                            '+D to bookmark this page.');
                    }
                }
            }
            return false;
        }
    </script>


    <!-- rating movies -->

    <script type="text/javascript">
        function remove_background(movie_id) {
            for (var countt = 1; countt <= 5; countt++) {
                $('#' + movie_id + '-' + countt).css('color', '#ccc');
            }
        }

        //hover chuột đánh giá sao
        $(document).on('mouseenter', '.rating', function() {
            var index = $(this).data("index");
            var movie_id = $(this).data('movie_id');
            // alert(index);
            // alert(movie_id);
            remove_background(movie_id);
            for (var countt = 1; countt <= index; countt++) {
                $('#' + movie_id + '-' + countt).css('color', '#ffcc00');
            }
        });
        //nhả chuột ko đánh giá
        $(document).on('mouseleave', '.rating', function() {
            var index = $(this).data("index");
            var movie_id = $(this).data('movie_id');
            var rating = $(this).data("rating");
            remove_background(movie_id);
            //alert(rating);
            for (var countt = 1; countt <= rating; countt++) {
                $('#' + movie_id + '-' + countt).css('color', '#ffcc00');
            }
        });

        //click đánh giá sao
        $(document).on('click', '.rating', function() {

            var index = $(this).data("index");
            var movie_id = $(this).data('movie_id');
            // alert(csrf_token);

            $.ajax({
                url: "{{ route('add-rating') }}",
                method: "POST",
                data: {
                    index: index,
                    movie_id: movie_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data == 'done') {

                        // alert("Bạn đã đánh giá " + index + " trên 5");
                        location.reload();

                    } else if (data == 'exist') {
                        alert("Bạn đã đánh giá phim này rồi,cảm ơn bạn nhé");
                    } else {
                        alert("Lỗi đánh giá");
                    }

                }
            });

        });
    </script>

    <!--keypress "/" focus input search -->
    <script>
        document.addEventListener('keydown', function(event) {
            if (event.keyCode === 191) {
                event.preventDefault();
                document.getElementById("timkiem").focus();
            }

        });
    </script>
    <!-- auto click top views add -->
    <script type="text/javascript">
        $(document).ready(function() {
            $(".defaults").click();
        });
    </script>


    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId: '{your-app-id}',
                cookie: true,
                xfbml: true,
                version: '{api-version}'
            });

            FB.AppEvents.logPageView();

        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script>
        $(document).ready(function() {
            $("img.lazy").lazyload({
                effect: "fadeIn",
            });
        })
    </script>

    <style>
        #overlay_mb {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 99999;
            cursor: pointer
        }

        #overlay_mb .overlay_mb_content {
            position: relative;
            height: 100%
        }

        .overlay_mb_block {
            display: inline-block;
            position: relative
        }

        #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
            width: 600px;
            height: auto;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: center
        }

        #overlay_mb .overlay_mb_content .cls_ov {
            color: #fff;
            text-align: center;
            cursor: pointer;
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 999999;
            font-size: 14px;
            padding: 4px 10px;
            border: 1px solid #aeaeae;
            background-color: rgba(0, 0, 0, 0.7)
        }

        #overlay_mb img {
            position: relative;
            z-index: 999
        }

        @media only screen and (max-width: 768px) {
            #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
                width: 400px;
                top: 3%;
                transform: translate(-50%, 3%)
            }
        }

        @media only screen and (max-width: 400px) {
            #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
                width: 310px;
                top: 3%;
                transform: translate(-50%, 3%)
            }
        }
    </style>
    <style>
        #overlay_mb {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 99999;
            cursor: pointer
        }

        #overlay_mb .overlay_mb_content {
            position: relative;
            height: 100%
        }

        .overlay_mb_block {
            display: inline-block;
            position: relative
        }

        #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
            width: 600px;
            height: auto;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: center
        }

        #overlay_mb .overlay_mb_content .cls_ov {
            color: #fff;
            text-align: center;
            cursor: pointer;
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 999999;
            font-size: 14px;
            padding: 4px 10px;
            border: 1px solid #aeaeae;
            background-color: rgba(0, 0, 0, 0.7)
        }

        #overlay_mb img {
            position: relative;
            z-index: 999
        }

        @media only screen and (max-width: 768px) {
            #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
                width: 400px;
                top: 3%;
                transform: translate(-50%, 3%)
            }
        }

        @media only screen and (max-width: 400px) {
            #overlay_mb .overlay_mb_content .overlay_mb_wrapper {
                width: 310px;
                top: 3%;
                transform: translate(-50%, 3%)
            }
        }
    </style>

    <style>
        #overlay_pc {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 99999;
            cursor: pointer;
        }

        #overlay_pc .overlay_pc_content {
            position: relative;
            height: 100%;
        }

        .overlay_pc_block {
            display: inline-block;
            position: relative;
        }

        #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
            width: 600px;
            height: auto;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        #overlay_pc .overlay_pc_content .cls_ov {
            color: #fff;
            text-align: center;
            cursor: pointer;
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 999999;
            font-size: 14px;
            padding: 4px 10px;
            border: 1px solid #aeaeae;
            background-color: rgba(0, 0, 0, 0.7);
        }

        #overlay_pc img {
            position: relative;
            z-index: 999;
        }

        @media only screen and (max-width: 768px) {
            #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
                width: 400px;
                top: 3%;
                transform: translate(-50%, 3%);
            }
        }

        @media only screen and (max-width: 400px) {
            #overlay_pc .overlay_pc_content .overlay_pc_wrapper {
                width: 310px;
                top: 3%;
                transform: translate(-50%, 3%);
            }
        }
    </style>

    <style>
        .float-ck {
            position: fixed;
            bottom: 0px;
            z-index: 9
        }

        * html .float-ck

        /* IE6 position fixed Bottom */
            {
            position: absolute;
            bottom: auto;
            top: expression(eval (document.documentElement.scrollTop+document.docum entElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop, 10)||0)-(parseInt(this.currentStyle.marginBottom, 10)||0)));
        }

        #hide_float_left a {
            background: #0098D2;
            padding: 5px 15px 5px 15px;
            color: #FFF;
            font-weight: 700;
            float: left;
        }

        #hide_float_left_m a {
            background: #0098D2;
            padding: 5px 15px 5px 15px;
            color: #FFF;
            font-weight: 700;
        }

        span.bannermobi2 img {
            height: 70px;
            width: 300px;
        }

        #hide_float_right a {
            background: #01AEF0;
            padding: 5px 5px 1px 5px;
            color: #FFF;
            float: left;
        }
    </style>


</body>

</html>
