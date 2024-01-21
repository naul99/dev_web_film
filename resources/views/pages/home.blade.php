@extends('layout')
@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
        </div>
        <div id="halim_related_movies-2xx" class="wrap-slider">
            <div class="section-heading clearfix">
                <h3 class="section-title"><span>phim hot</span></h3>
            </div>
            <div id="phimhot" class="owl-carousel owl-theme related-film">
                @foreach ($hot as $key => $h)
                    <article class="thumb grid-item post-38498">
                        <div class="halim-item">
                            <a class="halim-thumb" href="{{ route('movie', $h->slug) }}" title="{{ $h->title }}">
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
                                        $image_check = substr($h->movie_image->image, 0, 5);
                                    @endphp
                                    @if ($image_check == 'https')
                                        <img class="lazy img-responsive" src="{{ $h->movie_image->image }}"
                                            alt="{{ $h->title }}" title="{{ $h->title }}">
                                    @else
                                        <img class="lazy img-responsive"
                                            src="{{ asset('uploads/movie/' . $h->movie_image->image) }}"
                                            alt="{{ $h->title }}" title="{{ $h->title }}">
                                    @endif


                                </figure>
                                <span class="status">
                                    @if ($h->quality == 1)
                                        Bluray
                                    @elseif ($h->quality == 2)
                                        HD
                                    @else
                                        FHD
                                    @endif
                                </span>


                                @if (Auth::guard('customer')->check())
                                    @if (Auth::guard('customer')->user()->status_registration == 0)
                                        @if ($h->paid_movie == 1)
                                            <span class="episode"><i class="fa-solid fa-lock fa-xl" aria-hidden="true"></i>
                                            </span>
                                        @else
                                            <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                                @if ($h->type_movie == '1')
                                                    @if ($h->episode_count == $h->sotap)
                                                        Hoàn tất |
                                                    @else
                                                        {{ $h->episode_count }}/{{ $h->sotap }}|
                                                    @endif
                                                @endif

                                                @if ($h->language == 1)
                                                    VietSub
                                                    @if ($h->season != 0)
                                                        -S{{ $h->season }}
                                                    @endif
                                                @elseif ($h->language == 2)
                                                    Tiếng Gốc
                                                    @if ($h->season != 0)
                                                        -S{{ $h->season }}
                                                    @endif
                                                @elseif ($h->language == 3)
                                                    Lồng Tiếng
                                                    @if ($h->season != 0)
                                                        -S{{ $h->season }}
                                                    @endif
                                                @else
                                                    Thuyết Minh
                                                    @if ($h->season != 0)
                                                        -S{{ $h->season }}
                                                    @endif
                                                @endif

                                            </span>
                                        @endif
                                    @else
                                        <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                            @if ($h->type_movie == '1')
                                                @if ($h->episode_count == $h->sotap)
                                                    Hoàn tất |
                                                @else
                                                    {{ $h->episode_count }}/{{ $h->sotap }}|
                                                @endif
                                            @endif

                                            @if ($h->language == 1)
                                                VietSub
                                                @if ($h->season != 0)
                                                    -S{{ $h->season }}
                                                @endif
                                            @elseif ($h->language == 2)
                                                Tiếng Gốc
                                                @if ($h->season != 0)
                                                    -S{{ $h->season }}
                                                @endif
                                            @elseif ($h->language == 3)
                                                Lồng Tiếng
                                                @if ($h->season != 0)
                                                    -S{{ $h->season }}
                                                @endif
                                            @else
                                                Thuyết Minh
                                                @if ($h->season != 0)
                                                    -S{{ $h->season }}
                                                @endif
                                            @endif

                                        </span>
                                    @endif
                                @else
                                    @if ($h->paid_movie == 1)
                                        <span class="episode"><i class="fa-solid fa-lock fa-xl" aria-hidden="true"></i>
                                        </span>
                                    @else
                                        <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                            @if ($h->type_movie == '1')
                                                @if ($h->episode_count == $h->sotap)
                                                    Hoàn tất |
                                                @else
                                                    {{ $h->episode_count }}/{{ $h->sotap }}|
                                                @endif
                                            @endif

                                            @if ($h->language == 1)
                                                VietSub
                                                @if ($h->season != 0)
                                                    -S{{ $h->season }}
                                                @endif
                                            @elseif ($h->language == 2)
                                                Tiếng Gốc
                                                @if ($h->season != 0)
                                                    -S{{ $h->season }}
                                                @endif
                                            @elseif ($h->language == 3)
                                                Lồng Tiếng
                                                @if ($h->season != 0)
                                                    -S{{ $h->season }}
                                                @endif
                                            @else
                                                Thuyết Minh
                                                @if ($h->season != 0)
                                                    -S{{ $h->season }}
                                                @endif
                                            @endif

                                        </span>
                                    @endif
                                @endif

                                <div class="icon_overlay"></div>
                                <div class="halim-post-title-box">
                                    <div class="halim-post-title ">
                                        <p class="entry-title">{{ $h->title }}</p>
                                        <p class="original_title">{{ $h->name_english }} @if ($h->season != 0)
                                                Season {{ $h->season }}
                                            @endif
                                            @if ($h->year != null)
                                                ({{ $h->year }})
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
                jQuery(document).ready(function($) {
                    var owl = $('#phimhot');
                    owl.owlCarousel({
                        margin: 6,
                        loop: true,
                        autoplay: true,
                        autoplayTimeout: 2500,
                        autoplayHoverPause: true,
                        nav: true,
                        navText: ['<i class="bi bi-chevron-compact-left"></i>',
                            '<i class="bi bi-chevron-compact-right"></i>'
                        ],
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
                    });
                });
            </script>
        </div>
        {{-- phim hot --}}
        {{-- <div class="col-xs-12 carausel-sliderWidget">
               @foreach ($category_home as $key => $cate_home)
                  
               <section id="halim-advanced-widget-4">
                  <div class="section-heading">
                     <a href="danhmuc.php" title="{{ $cate_home->title }}">
                     <span class="h-text">{{ $cate_home->title }}</span>
                     </a>
                     <ul class="heading-nav pull-right hidden-xs">
                        <li class="section-btn halim_ajax_get_post" data-catid="4" data-showpost="12" data-widgetid="halim-advanced-widget-4" data-layout="6col"><span data-text="Chiếu Rạp"></span></li>
                     </ul>
                  </div>
                  <div id="halim-advanced-widget-4-ajax-box" class="halim_box">
                     @foreach ($cate_home->movie as $key => $mov)
                     <article class="col-md-2 col-sm-4 col-xs-6 thumb grid-item post-38424">
                        <div class="halim-item">
                           <a class="halim-thumb" href="{{route('movie')}}" title="GÓA PHỤ ĐEN">
                              <figure><img class="lazy img-responsive" src="https://img.yts.mx/assets/images/movies/jurassic_world_fallen_kingdom_2018/medium-cover.jpg" alt="Jurassic World - Fallen Kingdom" title="Jurassic World - Fallen Kingdom"></figure>
                              <span class="status">HD</span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>Vietsub</span> 
                              <div class="icon_overlay"></div>
                              <div class="halim-post-title-box">
                                 <div class="halim-post-title ">
                                    <p class="entry-title">Jurassic World - Fallen Kingdom (2018)</p>
                                    <p class="original_title">Jurassic World</p>
                                 </div>
                              </div>
                           </a>
                        </div>
                     </article>
                     @endforeach
                  </div>
               </section>
               <div class="clearfix"></div>
               @endforeach
            </div> --}}
        <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
            @foreach ($category_home as $key => $cate_home)
                <section id="halim-advanced-widget-2">
                    <div class="section-heading">
                        <a href="{{ route('category', $cate_home->slug) }}" title="{{ $cate_home->title }}">
                            <span class="h-text">{{ $cate_home->title }}</span>
                        </a>
                    </div>
                    <div id="halim-advanced-widget-2-ajax-box" class="halim_box">
                        @foreach ($cate_home->movie->sortBydesc('updated_at')->take(8) as $key => $mov)
                            <article class="lazy col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
                                <div class="halim-item">
                                    <a class="halim-thumb" href="{{ route('movie', $mov->slug) }}">
                                        <figure>
                                            @php
                                                $image_check = substr($mov->movie_image->image, 0, 5);
                                            @endphp
                                            @if ($image_check == 'https')
                                                <img class="lazy img-responsive" src="{{ $mov->movie_image->image }}"
                                                    alt="{{ $mov->title }}" title="{{ $mov->title }}">
                                            @else
                                                <img class="lazy img-responsive"
                                                    src="{{ asset('uploads/movie/' . $mov->movie_image->image) }}"
                                                    alt="{{ $mov->title }}" title="{{ $mov->title }}">
                                            @endif
                                        </figure>
                                        <span class="status">
                                            @if ($mov->quality == 1)
                                                Bluray
                                            @elseif ($mov->quality == 2)
                                                HD
                                            @else
                                                FHD
                                            @endif
                                        </span>
                                        @if (Auth::guard('customer')->check())
                                            @if (Auth::guard('customer')->user()->status_registration == 0)
                                                @if ($mov->paid_movie == 1)
                                                    <span class="episode"><i class="fa-solid fa-lock fa-xl"
                                                            aria-hidden="true"></i>
                                                    </span>
                                                @else
                                                    <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                                        @if ($mov->type_movie == '1')
                                                            @if ($mov->episode_count == $mov->sotap)
                                                                Hoàn tất |
                                                            @else
                                                                {{ $mov->episode_count }}/{{ $mov->sotap }}|
                                                            @endif
                                                        @endif

                                                        @if ($mov->language == 1)
                                                            VietSub
                                                            @if ($mov->season != 0)
                                                                -S{{ $mov->season }}
                                                            @endif
                                                        @elseif ($mov->language == 2)
                                                            Tiếng Gốc
                                                            @if ($mov->season != 0)
                                                                -S{{ $mov->season }}
                                                            @endif
                                                        @elseif ($mov->language == 3)
                                                            Lồng Tiếng
                                                            @if ($mov->season != 0)
                                                                -S{{ $mov->season }}
                                                            @endif
                                                        @else
                                                            Thuyết Minh
                                                            @if ($mov->season != 0)
                                                                -S{{ $mov->season }}
                                                            @endif
                                                        @endif

                                                    </span>
                                                @endif
                                            @else
                                                <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                                    @if ($mov->type_movie == '1')
                                                        @if ($mov->episode_count == $mov->sotap)
                                                            Hoàn tất |
                                                        @else
                                                            {{ $mov->episode_count }}/{{ $mov->sotap }}|
                                                        @endif
                                                    @endif

                                                    @if ($mov->language == 1)
                                                        VietSub
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @elseif ($mov->language == 2)
                                                        Tiếng Gốc
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @elseif ($mov->language == 3)
                                                        Lồng Tiếng
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @else
                                                        Thuyết Minh
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @endif

                                                </span>
                                            @endif
                                        @else
                                            @if ($mov->paid_movie == 1)
                                                <span class="episode"><i class="fa-solid fa-lock fa-xl"
                                                        aria-hidden="true"></i>
                                                </span>
                                            @else
                                                <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                                    @if ($mov->type_movie == '1')
                                                        @if ($mov->episode_count == $mov->sotap)
                                                            Hoàn tất |
                                                        @else
                                                            {{ $mov->episode_count }}/{{ $mov->sotap }}|
                                                        @endif
                                                    @endif

                                                    @if ($mov->language == 1)
                                                        VietSub
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @elseif ($mov->language == 2)
                                                        Tiếng Gốc
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @elseif ($mov->language == 3)
                                                        Lồng Tiếng
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @else
                                                        Thuyết Minh
                                                        @if ($mov->season != 0)
                                                            -S{{ $mov->season }}
                                                        @endif
                                                    @endif

                                                </span>
                                            @endif
                                        @endif


                                        <div class="icon_overlay"></div>
                                        <div class="halim-post-title-box">
                                            <div class="halim-post-title ">
                                                <p class="entry-title">{{ $mov->title }}</p>
                                                <p class="original_title">{{ $mov->name_english }} @if ($mov->season != 0)
                                                        Season {{ $mov->season }}
                                                    @endif
                                                    @if ($mov->year != null)
                                                        ({{ $mov->year }})
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
                <div class="clearfix"></div>
            @endforeach

            <section id="halim-advanced-widget-2">
                <div class="section-heading">
                    <a href="{{ route('genre', $gen_slug->slug) }}">
                        <span class="h-text">{{ $gen_slug->title }} Mới Cập Nhật</span>
                    </a>
                </div>
                <div id="halim-advanced-widget-2-ajax-box" class="halim_box">
                    @foreach ($movie_animation->take(8) as $key => $mov)
                        <article class="lazy col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
                            <div class="halim-item">
                                <a class="halim-thumb" href="{{ route('movie', $mov->slug) }}">
                                    <figure>
                                        @php
                                            $image_check = substr($mov->movie_image->image, 0, 5);
                                        @endphp
                                        @if ($image_check == 'https')
                                            <img class="lazy img-responsive" src="{{ $mov->movie_image->image }}"
                                                alt="{{ $mov->title }}" title="{{ $mov->title }}">
                                        @else
                                            <img class="lazy img-responsive"
                                                src="{{ asset('uploads/movie/' . $mov->movie_image->image) }}"
                                                alt="{{ $mov->title }}" title="{{ $mov->title }}">
                                        @endif
                                    </figure>
                                    <span class="status">
                                        @if ($mov->quality == 1)
                                            Bluray
                                        @elseif ($mov->quality == 2)
                                            HD
                                        @else
                                            FHD
                                        @endif
                                    </span>
                                    <span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                        @if ($mov->type_movie == '1')
                                            @if ($mov->episode_count == $mov->sotap)
                                                Hoàn tất |
                                            @else
                                                {{ $mov->episode_count }}/{{ $mov->sotap }}|
                                            @endif
                                        @endif

                                        @if ($mov->language == 1)
                                            VietSub
                                            @if ($mov->season != 0)
                                                -S{{ $mov->season }}
                                            @endif
                                        @elseif ($mov->language == 2)
                                            Tiếng Gốc
                                            @if ($mov->season != 0)
                                                -S{{ $mov->season }}
                                            @endif
                                        @elseif ($mov->language == 3)
                                            Lồng Tiếng
                                            @if ($mov->season != 0)
                                                -S{{ $mov->season }}
                                            @endif
                                        @else
                                            Thuyết Minh
                                            @if ($mov->season != 0)
                                                -S{{ $mov->season }}
                                            @endif
                                        @endif

                                    </span>
                                    @if (Auth::guard('customer')->check())
                                        @if (Auth::guard('customer')->user()->status_registration == 0)
                                            @if ($mov->paid_movie == 1)
                                                <span class="paid"><i class="fa-solid fa-lock fa-xl"></i></span>
                                            @endif
                                        @endif
                                    @else
                                        @if ($mov->paid_movie == 1)
                                            <span class="paid"><i class="fa-solid fa-lock fa-xl"></i></span>
                                        @endif
                                    @endif
                                    <div class="icon_overlay"></div>
                                    <div class="halim-post-title-box">
                                        <div class="halim-post-title ">
                                            <p class="entry-title">{{ $mov->title }}</p>
                                            <p class="original_title">{{ $mov->name_english }} @if ($mov->season != 0)
                                                    Season {{ $mov->season }}
                                                @endif
                                                @if ($mov->year != null)
                                                    ({{ $mov->year }})
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
            <div class="clearfix"></div>

        </main>

        @include('pages.topview')
        @include('pages.include.movie_new')
    </div>
@endsection
