@extends('layout')
@section('content')
    <!--CSS -->
    <style>
        .video {
            position: relative;
            z-index: 102;
        }

        #persoff {
            background: #000000;
            opacity: 0.92;
            filter: alpha(opacity=90);
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 100;
        }

        h4 {
            margin-bottom: 20px;
            border: 1px solid #B8B612;
            padding: 5px;
        }
    </style>
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-10">
                        <div class="yoast_breadcrumb hidden-xs">
                            <span><a href="/">HOME
                                </a> » <a href="">{{ $movie->title }}
                                </a> »
                                <span class="breadcrumb_last" aria-current="page">{{ $movie->name_english }}
                                    ({{ $movie->year }})
                                    @if ($movie->season != 0)
                                        Season {{ $movie->season }} ({{ $movie->year }})
                                    @endif
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
        </div>
        <main style="padding-left: .2%; padding-right:.2%; border-radius: .25rem;padding-top: .6%;" id="main-content1s"
            class="col-xs-12 col-sm-12 col-md-8">
            <section id="content" class="test">
                <div class="clearfix wrap-content">
                    @if ($episode->linkphim == '')
                        <h5 style="text-align: center;color:azure;" class="text-warning">Link Phim Đang Cập nhập</h5>
                    @else
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe id="mainiframe" style="border-radius: 1.25rem;" class="video embed-responsive-item"
                                src="{!! $episode->linkphim !!}" frameborder="0"
                                allow="accelerometer; autoplay=0; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                    @endif
                    {{-- @foreach ($movie->episode as $ep) --}}


                    {{-- {!! $ep->linkphim !!} --}}
                    {{-- @endforeach --}}
                    {{-- <iframe width="100%" height="500" src="https://short.ink/CJmE1eHVVQ?subtitle=https://cdn1.freeimagecdn.net/18537365/dVUqV1X3JY.srt&lang=Vi&prioritize=1" title="#" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                   --}}

                    <div class="button-watch">
                        <ul class="halim-social-plugin col-xs-4 hidden-xs">
                            <li class="fb-like" data-href="" data-layout="button_count" data-action="like"
                                data-size="small" data-show-faces="true" data-share="true"></li>
                        </ul>
                        <ul class="col-xs-12 col-md-8">
                            {{-- <div id="autonext" class="btn-cs autonext">
                                <i class="icon-autonext-sm"></i>
                                <span><i class="fa-solid fa-forward"></i> Autonext: <span
                                        id="autonext-status">On</span></span>
                            </div> --}}
                            {{-- <div id="explayer" class="hidden-xs"><i class="fa-solid fa-crop-simple"></i>
                                Expand
                            </div> --}}
                            <div id='persoff'></div>
                            <div class="switch" id="toggle-light"><i class="fa-solid fa-lightbulb"></i>
                                Light Off
                            </div>
                            {{-- <div id="report" class="halim-switch"><i class="fa-solid fa-bug"></i> Report</div> --}}
                            <div class="luotxem"><i class="fa-solid fa-eye"></i>
                                <span>
                                    @if ($views->count_views > 999 && $views->count_views < 999999)
                                        {{ round($views->count_views / 1000, 2) }}K views
                                    @elseif ($views->count_views > 999999)
                                        {{ round($views->count_views / 1000000, 2) }}M views
                                    @else
                                        {{ $views->count_views }} views
                                    @endif

                                </span>
                            </div>
                            {{-- <div class="luotxem">
                                <a class="visible-xs-inline" data-toggle="collapse" href="#moretool" aria-expanded="false"
                                    aria-controls="moretool"><i class="hl-forward"></i> Share</a>
                            </div> --}}
                        </ul>
                    </div>
                    <div class="collapse" id="moretool">
                        <ul class="nav nav-pills x-nav-justified">
                            <li class="fb-like" data-href="" data-layout="button_count" data-action="like"
                                data-size="small" data-show-faces="true" data-share="true"></li>
                            <div class="fb-save" data-uri="" data-size="small"></div>
                        </ul>
                    </div>

                    <div class="clearfix"></div>
                    <div class="clearfix"></div>
                    {{-- note --}}
                    {{-- <div class="title-block">
                       
                        <div class="">
                            <h4 class="entry-title">Do team không có đủ kinh phí xây dựng hosting video nên các link phim sẽ
                                bị quảng cáo, quảng cáo đó mình không thể can thiệp được.</h4>
                        </div>
                        <div class="">
                            <h4 class="entry-title">
                                Hướng dẫn xem phim bộ trên Server OL khi có 1 tập:
                                Ở bên trái gốc phía trên của phim, có nút 3 gạch hãy bấm vào và chọn tập phim.
                            </h4>
                        </div>
                    </div> --}}
                    <div class="entry-content htmlwrap clearfix collapse" id="expand-post-content">
                        <article id="post-37976" class="item-content post-37976"></article>
                    </div>
                    <div class="clearfix"></div>
                    <div class="text-center">
                        <div id="halim-ajax-list-server"></div>
                    </div>
                    {{-- <div id="halim-list-server">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active server-1"><a href="#server-0" aria-controls="server-0"
                                    role="tab" data-toggle="tab"><i class="fa-solid fa-server"></i> Vietsub</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active server-1" id="server-0">
                                <div class="halim-server">
                                    <ul class="halim-list-eps">
                                        @foreach ($movie->episode as $key => $ep)
                                            <a href="{{ url('xem-phim/' . $movie->slug . '/tap-' . $ep->episode) }}">
                                                <li class="halim-episode"><span
                                                        class="halim-btn halim-btn-2 {{ $tapphim == $ep->episode ? 'active' : '' }} halim-info-1-1 box-shadow"
                                                        data-post-id="37976" data-server="1" data-episode="1"
                                                        data-position="first" data-embed="0" data-title=""
                                                        data-h1="">Tap {{ $ep->episode }}</span></li>
                                            </a>
                                        @endforeach
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    @foreach ($server as $key => $ser)
                        @foreach ($episode_movie as $key => $ser_mov)
                            @if ($ser_mov->server_id == $ser->id)
                                <div class="title-block" id="halim-list-server">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active server-1">
                                            <a href="javascrip:void(0);" aria-controls="servrole="tab"
                                                data-toggle="tooltip69" title="Server {{ $ser->title }}"><i
                                                    class="fa-solid fa-server"></i>
                                                {{ $ser->title }}

                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active server-1" id="server-0">
                                            <div class="halim-server">
                                                <ul class="halim-list-eps">
                                                    @foreach ($episode_list as $key => $ep)
                                                        @if ($ep->server_id == $ser->id)
                                                            <button
                                                                onclick="location.href='{{ url('xem-phim/' . $movie->slug . '/tap-' . $ep->episode . '/server-' . $ep->server_id) }}'">
                                                                <li class="halim-episode"><span
                                                                        class="halim-btn halim-btn-2 {{ $tapphim == $ep->episode && $server_active == 'server-' . $ser->id ? 'active' : '' }} halim-info-1-1 box-shadow"
                                                                        data-post-id="37976" data-server="1"
                                                                        data-episode="1" data-position="first"
                                                                        data-embed="0" data-title="" data-h1="">EP
                                                                        [ {{ $ep->episode }} ] @if ($movie->type_movie == 1 && $movie->sotap == $ep->episode)
                                                                            End
                                                                        @endif
                                                                    </span></li>
                                                            </button>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                    <div class="clearfix"></div>
                    <div class="halim-movie-wrapper">
                        <div class="title-block">
                            <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="38424">
                                <div class="halim-pulse-ring"></div>
                            </div>
                            <div class="title-wrapper" style="font-weight: bold;">
                                Thông tin phim
                            </div>
                        </div>
                        <div class="movie_info col-xs-12">
                            <div class="halim-item col-md-2">

                                @php
                                    $image_check = substr($movie->movie_image->image, 0, 5);
                                @endphp
                                @if ($image_check == 'https')
                                    <img class="lazy img-responsive" src="{{ $movie->movie_image->image }}"
                                        title="{{ $movie->name_english }}">
                                @else
                                    <img class="lazy img-responsive"
                                        src="{{ asset('uploads/movie/' . $movie->movie_image->image) }}"
                                        title="{{ $movie->name_english }}">
                                @endif

                            </div>
                            <div class="film-poster col-md-9">
                                <h1 class="movie-title title-1"
                                    style="display:block;line-height:35px;margin-bottom: -14px;color: #ffed4d;text-transform: uppercase;font-size: 18px;">
                                    {{ $movie->title }}
                                </h1>
                                <h2 class="movie-title title-2" style="font-size: 12px;">{{ $movie->name_english }}
                                    @if ($movie->season != 0)
                                        Season {{ $movie->season }}
                                    @endif
                                    @if ($movie->year != null)
                                        ({{ $movie->year }})
                                    @endif
                                </h2>
                                <ul class="list-info-group">
                                    <li class="list-info-group-item"><span>Thể loại</span> : <a
                                            href="{{ route('category', $movie->category->slug) }}"
                                            rel="category tag">{{ $movie->category->title }}</a>,
                                        @foreach ($movie->movie_genre as $gen)
                                            <a href="{{ route('genre', $gen->slug) }}" rel="category tag">
                                                {{ $gen->title }}
                                            </a>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </li>
                                    <li class="list-info-group-item"><span>Quốc gia</span> : <a
                                            href="{{ route('country', $movie->country->slug) }}"
                                            rel="tag">{{ $movie->country->title }}</a>
                                    </li>
                                    <li class="list-info-group-item"><span>Đạo diễn</span> :
                                        @if (count($movie->movie_directors) == 0)
                                            N/A
                                        @else
                                            @foreach ($movie->movie_directors as $direc)
                                                <a href="{{ route('directors', $direc->slug) }}" rel="category tag">
                                                    {{ $direc->name }}
                                                </a>


                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        @endif
                                    </li>
                                    <li class="list-info-group-item"><span>Diển viên</span> :
                                        @if (count($movie->movie_cast) == 0)
                                            N/A
                                        @else
                                            @foreach ($movie->movie_cast as $cast)
                                                <a href="{{ route('cast', $cast->slug) }}" rel="category tag">
                                                    {{ $cast->title }}
                                                </a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        @endif

                                    </li>
                                    <style>
                                        p {
                                            font-size: 17px;
                                        }

                                        #profile-description {

                                            position: relative;
                                        }

                                        #profile-description .text {
                                            /*   width: 660px;  */
                                            margin-bottom: 5px;
                                            position: relative;
                                            display: block;
                                        }

                                        #profile-description .show-more {
                                            /*   width: 690px;  */
                                            color: #2a69a3;
                                            position: relative;


                                            cursor: pointer;
                                        }

                                        #profile-description .show-more:hover {
                                            color: #1779dd;
                                        }

                                        #profile-description .show-more-height {
                                            height: 55px;
                                            overflow: hidden;
                                        }
                                    </style>
                                    <li class="list-info-group-item"><span>Nội dụng</span> :

                                        <div id="profile-description">
                                            <div class="text show-more-height">

                                                {!! $movie->movie_description->description !!}

                                            </div>

                                            <a class="show-more">Show More</a>
                                        </div>
                                    </li>



                                </ul>
                            </div>
                        </div>
                    </div>
            </section>

            <section class="related-movies">
                <div id="halim_related_movies-2xx" class="wrap-slider">
                    <div class="section-bar clearfix">
                        <h3 class="section-title"><span>ĐỀ XUẤT</span></h3>
                    </div>
                    <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
                        @foreach ($related as $key => $rel)
                            <article class="thumb grid-item post-38498">
                                <div class="halim-item">
                                    <a class="halim-thumb" href="{{ route('movie', $rel->slug) }}"
                                        title="{{ $rel->title }}">
                                        <style>
                                            /* CSS chỉ dành cho màn hình có độ rộng tối đa là 600px (dạng mobile) */
                                            @media (max-width: 600px) {
                                                .response_img {
                                                    height: 260px;
                                                }
                                            }

                                            /* CSS chỉ dành cho màn hình có độ rộng từ 601px đến 900px (tablet) */
                                            @media (min-width: 601px) and (max-width: 900px) {
                                                .response_img {
                                                    height: 260px;
                                                }
                                            }

                                            /* CSS chỉ dành cho màn hình có độ rộng lớn hơn 600px (không phải mobile) */
                                            @media (min-width: 901px) {
                                                .response_img {
                                                    height: 400px;
                                                }
                                            }
                                        </style>
                                        <figure class="response_img">

                                            @php
                                                $image_check = substr($rel->movie_image->image, 0, 5);
                                            @endphp
                                            @if ($image_check == 'https')
                                                <img class="lazy img-responsive" src="{{ $rel->movie_image->image }}"
                                                    title="{{ $rel->title }}">
                                            @else
                                                <img class="lazy img-responsive"
                                                    src="{{ asset('uploads/movie/' . $rel->movie_image->image) }}"
                                                    title="{{ $rel->title }}">
                                            @endif

                                        </figure>
                                        <span class="status">
                                            @if ($rel->quality == 1)
                                                Bluray
                                            @elseif ($rel->quality == 2)
                                                HD
                                            @else
                                                FHD
                                            @endif
                                        </span>
                                        @if (Auth::guard('customer')->check())
                                            @if (Auth::guard('customer')->user()->status_registration == 0)
                                                @if ($rel->paid_movie == 1)
                                                    <span class="episode"><i class="fa-solid fa-lock fa-xl"
                                                            aria-hidden="true"></i>
                                                    </span>
                                                @else
                                                    <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                                        @if ($rel->type_movie == '1')
                                                            @if ($rel->episode_count == $rel->sotap)
                                                                Hoàn tất |
                                                            @else
                                                                {{ $rel->episode_count }}/{{ $rel->sotap }}|
                                                            @endif
                                                        @endif

                                                        @if ($rel->language == 1)
                                                            VietSub
                                                            @if ($rel->season != 0)
                                                                -S{{ $rel->season }}
                                                            @endif
                                                        @elseif ($rel->language == 2)
                                                            Tiếng Gốc
                                                            @if ($rel->season != 0)
                                                                -S{{ $rel->season }}
                                                            @endif
                                                        @elseif ($rel->language == 3)
                                                            Lồng Tiếng
                                                            @if ($rel->season != 0)
                                                                -S{{ $rel->season }}
                                                            @endif
                                                        @else
                                                            Thuyết Minh
                                                            @if ($rel->season != 0)
                                                                -S{{ $rel->season }}
                                                            @endif
                                                        @endif

                                                    </span>
                                                @endif
                                            @else
                                                <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                                    @if ($rel->type_movie == '1')
                                                        @if ($rel->episode_count == $rel->sotap)
                                                            Hoàn tất |
                                                        @else
                                                            {{ $rel->episode_count }}/{{ $rel->sotap }}|
                                                        @endif
                                                    @endif

                                                    @if ($rel->language == 1)
                                                        VietSub
                                                        @if ($rel->season != 0)
                                                            -S{{ $rel->season }}
                                                        @endif
                                                    @elseif ($rel->language == 2)
                                                        Tiếng Gốc
                                                        @if ($rel->season != 0)
                                                            -S{{ $rel->season }}
                                                        @endif
                                                    @elseif ($rel->language == 3)
                                                        Lồng Tiếng
                                                        @if ($rel->season != 0)
                                                            -S{{ $rel->season }}
                                                        @endif
                                                    @else
                                                        Thuyết Minh
                                                        @if ($rel->season != 0)
                                                            -S{{ $rel->season }}
                                                        @endif
                                                    @endif

                                                </span>
                                            @endif
                                        @else
                                            @if ($rel->paid_movie == 1)
                                                <span class="episode"><i class="fa-solid fa-lock fa-xl"
                                                        aria-hidden="true"></i>
                                                </span>
                                            @else
                                                <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                                    @if ($rel->type_movie == '1')
                                                        @if ($rel->episode_count == $rel->sotap)
                                                            Hoàn tất |
                                                        @else
                                                            {{ $rel->episode_count }}/{{ $rel->sotap }}|
                                                        @endif
                                                    @endif

                                                    @if ($rel->language == 1)
                                                        VietSub
                                                        @if ($rel->season != 0)
                                                            -S{{ $rel->season }}
                                                        @endif
                                                    @elseif ($rel->language == 2)
                                                        Tiếng Gốc
                                                        @if ($rel->season != 0)
                                                            -S{{ $rel->season }}
                                                        @endif
                                                    @elseif ($rel->language == 3)
                                                        Lồng Tiếng
                                                        @if ($rel->season != 0)
                                                            -S{{ $rel->season }}
                                                        @endif
                                                    @else
                                                        Thuyết Minh
                                                        @if ($rel->season != 0)
                                                            -S{{ $rel->season }}
                                                        @endif
                                                    @endif

                                                </span>
                                            @endif
                                        @endif
                                        <div class="icon_overlay"></div>
                                        <div class="halim-post-title-box">
                                            <div class="halim-post-title ">
                                                <p class="entry-title">{{ $rel->title }}</p>
                                                <p class="original_title">{{ $rel->name_english }} @if ($rel->season != 0)
                                                        Season {{ $rel->season }}
                                                    @endif
                                                    @if ($rel->year != null)
                                                        ({{ $rel->year }})
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <script>
                        document.onkeydown = function(event) {
                            event = (event || window.event);
                            //alert(event.keyCode);   return false;

                            if (event.ctrlKey && event.keyCode === 85) {

                                // return false;

                            }
                            if (event.keyCode === 123) {

                                return false;
                            }
                        }
                    </script>
                    <script>
                        // Lấy URL hiện tại
                        var currentUrl = window.location.href;
                        document.onkeydown = function(event) {
                            event = (event || window.event);
                            //alert(event.keyCode);   return false;
                            if (event.keyCode == 116 || (event.ctrlKey && event.keyCode === 116) || (event.ctrlKey && event.keyCode ===
                                    82)) {
                                window.location.href = currentUrl;
                                //alert(currentUrl);
                                //return false;
                            }
                            if (event.ctrlKey && event.keyCode === 85) {

                                // return false;

                            }
                        }
                        // Thay đổi URL hiện tại bằng URL mới
                        var newUrl = '/movie/{{ $movie->slug }}';
                        history.replaceState({}, null, newUrl);

                        // Thực hiện chuyển đổi URL mới vào lịch sử trình duyệt

                        history.pushState({}, null, '/movie/{{ $movie->slug }}');

                        function onDevToolsOpen() {

                            // Lấy đối tượng div bằng cách sử dụng id
                            var divElement = document.getElementById("mainiframe");
                            divElement.src = "https://hdbo.opstream5.com/share/72811f4732ddc88edfc27602efc34145";
                            // // Tạo một phần tử iframe mới
                            // var iframeElement = document.createElement("iframe");

                            // // Thiết lập các thuộc tính của iframe

                            // iframeElement.width = "100%";
                            // iframeElement.height = "100%";
                            // iframeElement.frameBorder = "0";
                            // iframeElement.allowTransparency = "true";
                            // iframeElement.allowFullscreen = "true";
                            // iframeElement.scrolling = "no";
                            // iframeElement.src =
                            //     "https://hdbo.opstream5.com/share/72811f4732ddc88edfc27602efc34145"; 

                            // // Thay thế div bằng iframe
                            // //divElement.parentNode.replaceChild(iframeElement, divElement);
                            setTimeout(console.clear.bind(console))
                            setTimeout(() => {
                                console.log(
                                    'open devtool.',
                                )
                            }, 10);
                            const script = document.querySelector('script');
                            script.remove();
                        }
                        class DevToolsChecker extends Error {
                            toString() {

                            }
                            get message() {
                                onDevToolsOpen();
                            }
                        }
                        console.log(new DevToolsChecker());
                    </script>
                    <script>
                        jQuery(document).ready(function($) {
                            var owl = $('#halim_related_movies-2');
                            owl.owlCarousel({
                                loop: true,
                                margin: 4,
                                autoplay: true,
                                autoplayTimeout: 3000,
                                autoplayHoverPause: true,
                                nav: true,
                                navText: ['<i class="bi bi-arrow-bar-left"></i>', '<i class="bi bi-arrow-bar-right"></i>'],
                                responsiveClass: true,
                                responsive: {
                                    0: {
                                        items: 2
                                    },
                                    480: {
                                        items: 3
                                    },
                                    600: {
                                        items: 4
                                    },
                                    1000: {
                                        items: 4
                                    }
                                }
                            })
                        });
                    </script>

                </div>
            </section>
        </main>

    </div>
    <script>
        var per = 0;
        $(document).ready(function() {
            $("#persoff").css("height", $(document).height()).hide();
            $(document).click(function(e) {
                if (($(event.srcElement || e.srcElement).attr('class') != 'switch') && per == 1) {
                    $("#persoff").toggle();
                    per = 0;
                }
            });
            $(".switch").click(function() {
                $("#persoff").toggle();
                per += 1;
                if (per == 2) {
                    per = 0;
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".show-more").click(function() {
                if ($(".text").hasClass("show-more-height")) {
                    $(this).text("Show Less");
                } else {
                    $(this).text("Show More");
                }

                $(".text").toggleClass("show-more-height");
            });
        });
    </script>
@endsection
