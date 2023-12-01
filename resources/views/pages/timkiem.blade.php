@extends('layout')
@section('content')
    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span><a href="">{{ $search }}</a> » <span
                                        class="breadcrumb_last" aria-current="page">2023</span></span></span></div>
                    </div>
                </div>
            </div>
            <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                <div class="ajax"></div>
            </div>
            <!-- Start Fillter movies-->
            {{-- @include('pages.include.fillter_movie') --}}
            <!--End Fillter movies-->
        </div>
        <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
            <section>
                <div class="section-bar clearfix">
                    <h1 class="section-title"><span>Tìm kiếm</span></h1>
                </div>
                <div class="halim_box">
                    @if (count($movie) != 0)
                        @foreach ($movie as $key => $mov)
                            <article class="col-md-3 col-sm-3 col-xs-6 thumb grid-item post-37606">
                                <div class="halim-item">
                                    <a class="halim-thumb" href="{{ route('movie', $mov->slug) }}"
                                        title="{{ $mov->title }}">
                                        <figure>
                                          
                                            <img class="lazy img-responsive"
                                            data-original="{{ asset('uploads/movie/' . $mov->movie_image->image) }}" alt="#"
                                            title="{{ $mov->title }}">
                                           
                                            </figure>
                                        <span class="status">
                                            @if ($mov->quality == 1)
                                                Bluray
                                            @elseif ($mov->quality == 2)
                                                HD
                                            @else
                                                FHD
                                            @endif
                                        </span><span class="episode"><i class="fa fa-play" aria-hidden="true"></i>
                                            @if ($mov->thuocphim == '1')
                                                {{ $mov->episode_count }}/{{ $mov->sotap }}
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
                                        @if ($mov->paid_movie == 1)
                                        <span class="paid"><i class="fa-solid fa-lock fa-xl"></i></span>
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
                                                @endif</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    @else
                        <span>Không tìm thấy phim hoặc phim đã vì lý do gì đó đã ẩn! :((</span>
                    @endif



                </div>
                <div class="clearfix"></div>
                <div class="text-right">
                     {{ $movie->appends($_GET)->links('vendor.pagination.custom') }}
                </div>
            </section>
        </main>
        {{-- @include('pages.topview') --}}
    </div>
@endsection
