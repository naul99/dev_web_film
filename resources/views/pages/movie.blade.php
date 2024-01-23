@extends('layout')
@section('content')
    <!-- CSS -->
    <style>
        .ui-widget-header,
        .ui-state-default,
        ui-button {
            text-align: center;
            background: #ff9966;
            border: 1px solid #ff9966;
            color: white;
            font-weight: bold;
        }
    </style>


    <div class="row container" id="wrapper">
        <div class="halim-panel-filter">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><span><span>
                                    <a href="/"> HOME</a>
                                    » <span><a
                                            href="{{ route('category', $movie->category->slug) }}">{{ $movie->category->title }}</a>
                                        » <span class="breadcrumb_last"aria-current="page">{{ $movie->title }} </span>
                                    </span>
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

        <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
            <section id="content" class="test">
                <div class="clearfix wrap-content">

                    <div class="halim-movie-wrapper">
                        <div class="title-block">
                            <div id="bookmark" class="bookmark-img-animation primary_ribbon" data-id="38424">
                                <div class="halim-pulse-ring"></div>
                            </div>
                            <div class="title-wrapper" style="font-weight: bold;">

                            </div>
                        </div>
                        <div class="movie_info col-xs-12">
                            <div class="movie-poster col-md-3">


                                @php
                                    $image_check = substr($movie->movie_image->image, 0, 5);
                                @endphp
                                @if ($image_check == 'https')
                                    <img class="movie-thumb" src="{{ $movie->movie_image->image }}"
                                        title="{{ $movie->name_english }}">
                                @else
                                    <img class="movie-thumb"
                                        src="{{ asset('uploads/movie/' . $movie->movie_image->image) }}"
                                        title="{{ $movie->name_english }}">
                                @endif
                                <div class="movie-thumb">

                                    @foreach ($movie->episode->take(1) as $ep)
                                        @if (isset($ep->linkdownload))
                                           
                                                <a href={!! $ep->linkdownload !!} target="_blank"> <button
                                                        style="width: 100%;" class="btn btn-danger"><i
                                                            class="bi bi-download"></i> Download
                                                        Now</button></a>
                                           
                                        @elseif (isset($ep->linkdownload) == '')
                                            <a href="javascription:voi(0);" hidden> <button class="btn btn-danger"><i
                                                        class="bi bi-download"></i> Updating link download
                                                </button></a>
                                        @endif
                                    @endforeach

                                </div>
                                {{-- <p style="text-align: center">
                                    @if (count($watched) > 0)
                                        (Watched)
                                    @endif
                                </p> --}}
                                <div class="bwa-content">
                                    @if ($episode_current_list_count > 0)
                                        <div class="loader"></div>
                                        @guest('customer')
                                            <button
                                                onclick="location.href='{{ url('xem-phim/' . $movie->slug . '/tap-' . $episode_first->episode . '/server-' . $episode_first->server_id) }}'"
                                                class="bwac-btn">

                                                <i class="fa fa-play "></i>
                                            </button>
                                        @else
                                            {{-- <a href="{{ url('xem-phim/' . $movie->slug . '/tap-' . $episode_first->episode) }}"
                                            class="bwac-btn"> --}}
                                            <a id="{{ $movie->id }}" class="bwac-btn "
                                                href="{{ url('xem-phim/' . $movie->slug . '/tap-' . $episode_first->episode . '/server-' . $episode_first->server_id) }}">
                                                <i class="fa fa-play "></i>
                                            </a>
                                        @endguest
                                    @else
                                        <i class="fa fa-play"></i>
                                    @endif

                                </div>
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
                                    <li class="list-info-group-item"><span>Trạng Thái</span> : <span class="quality">
                                            @if ($movie->quality == 1)
                                                Bluray
                                            @elseif ($movie->quality == 2)
                                                HD
                                            @else
                                                FHD
                                            @endif
                                        </span><span class="episode">
                                            @if ($movie->language == 1)
                                                VietSub
                                            @elseif ($movie->language == 2)
                                                Tiếng Gốc
                                            @elseif ($movie->language == 3)
                                                Lồng Tiếng
                                            @else
                                                Thuyết Minh
                                            @endif
                                        </span></li>
                                    <li class="list-info-group-item"><span>Điểm IMDb</span> :

                                        <a href="{{ $link_imdb }}" target="_blank"><span
                                                class="imdb">{{ $values }}</a>
                                        </span>

                                    </li>
                                    <li class="list-info-group-item"><span>Thời lượng</span> :
                                        @if ($movie->type_movie == '0')
                                            {{ $times }}
                                        @else
                                            {{ $times }}/ Tập
                                        @endif
                                    </li>
                                    @if ($movie->season != 0)
                                        <li class="list-info-group-item"><span>Season</span> : {{ $movie->season }}</li>
                                    @endif

                                    @if ($movie->type_movie == '1')
                                        <li class="list-info-group-item"><span>Số tập</span> :
                                            {{ $episode_current_list_count }}/{{ $movie->sotap }}
                                            {{ $episode_current_list_count == $movie->sotap ? 'Hoàn Thành' : 'Tập' }}
                                        </li>
                                        {{-- @else
                                        <li class="list-info-group-item"><span>Tập phim</span> :
                                            @if ($movie->quality == 1)
                                                Bluray
                                            @elseif ($movie->quality == 2)
                                                HD
                                            @else
                                                FHD
                                            @endif

                                        </li> --}}
                                    @endif
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
                                    <li class="list-info-group-item"><span>Tập phim mới</span> :
                                        @if ($episode_current_list_count > 0)
                                            @if ($movie->type_movie == '0')
                                                @foreach ($episode->take(1) as $key => $ep)
                                                    @guest('customer')
                                                        <a href="{{ url('xem-phim/' . $ep->movie->slug . '/tap-' . $ep->episode . '/server-' . $ep->server_id) }}"
                                                            rel="tag"> {{ $ep->episode }}</a>
                                                    @else
                                                        <a id="{{ $movie->id }}" class=""
                                                            href="{{ url('xem-phim/' . $ep->movie->slug . '/tap-' . $ep->episode . '/server-' . $ep->server_id) }}"
                                                            rel="tag"> {{ $ep->episode }}</a>
                                                    @endguest
                                                @endforeach
                                            @else
                                                @foreach ($episode as $key => $ep)
                                                    {{-- @dd($ep); --}}
                                                    @guest('customer')
                                                        <a href="{{ url('xem-phim/' . $ep->movie->slug . '/tap-' . $ep->episode . '/server-' . $ep->server_id) }}"
                                                            rel="tag">Tập {{ $ep->episode }}</a>
                                                    @else
                                                        <a id="{{ $movie->id }}" class=""
                                                            href="{{ url('xem-phim/' . $ep->movie->slug . '/tap-' . $ep->episode . '/server-' . $ep->server_id) }}"
                                                            rel="tag">Tập {{ $ep->episode }}</a>
                                                    @endguest
                                                @endforeach
                                            @endif
                                        @else
                                            <span class="text-danger">Đang Cập Nhật</span>
                                        @endif
                                    </li>
                                    @if (isset($movie->year))
                                        <li class="list-info-group-item"><span>Năm phát hành</span>:
                                            <span class="quality">{{ $movie->year }}</span>
                                        </li>
                                    @endif
                                    {{-- <li class="list-info-group-item"> --}}
                                    <ul class="list-inline rating" title="Average Rating">

                                        @for ($countt = 1; $countt <= 5; $countt++)
                                            @php

                                                if ($countt <= $rating) {
                                                    $color = 'color:#ffcc00;'; //mau vang
                                                } else {
                                                    $color = 'color:#ccc;'; //mau xam
                                                }

                                            @endphp

                                            <li title="star_rating" id="{{ $movie->id }}-{{ $countt }}"
                                                data-index="{{ $countt }}" data-movie_id="{{ $movie->id }}"
                                                data-rating="{{ $rating }}" class="rating"
                                                style="cursor:pointer; {{ $color }} 

                                          font-size:30px;">
                                                &#9733;</li>
                                        @endfor

                                    </ul>
                                    {{-- </li> --}}

                                    <span class="total_rating">Reviews:{{ $rating }}/{{ $count_total }}</span>
                                </ul>


                                <div class="movie-trailer hidden"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="halim_trailer"></div>
                    <div class="clearfix"></div>
                    <div class="section-bar clearfix">
                        <h2 class="section-title"><span style="color:#ffed4d">Trailer phim</span></h2>
                    </div>
                    <div class="entry-content clearfix">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                src="https://www.youtube.com/embed/{{ $movie->movie_trailer->trailer }}?rel=0&amp;autoplay=1&mute=1"
                                frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="section-bar clearfix">
                        <h2 class="section-title"><span style="color:#ffed4d">Nội dung phim</span></h2>
                    </div>
                    <div class="entry-content htmlwrap clearfix">
                        <div class="video-item halim-entry-box">
                            <article id="post-38424" class="item-content">
                                {!! $movie->movie_description->description !!}
                            </article>

                        </div>
                    </div>

                    <div class="section-bar clearfix">
                        <h2 class="section-title"><span style="color:#ffed4d">Tags movie</span></h2>
                    </div>
                    <div class="entry-content htmlwrap clearfix">
                        <div class="video-item halim-entry-box">
                            <article id="post-38424" class="item-content">
                                @if (isset($movie->movie_tags))
                                    @php
                                        $tagss = [];
                                        $tagss = explode(',', $movie->movie_tags->tags);
                                    @endphp
                                    @foreach ($tagss as $key => $tag)
                                        {{-- <a class="badge badge-dark" href="{{ url('tag/' . $tag) }}"> #{{ $tag }}</a> --}}
                                        <a class="tag"
                                            style="display: inline-block;
                                            padding: .25em 1.4em;
                                            font-size: 130%;
                                            font-weight: 800;
                                            line-height: 1;
                                            text-align: center;
                                            white-space: nowrap;
                                            vertical-align: baseline;
                                            border-radius: .25rem;
                                            text-decoration: none;
                                            background-color: #117a8b;
                                            color:#fff;
                                            margin: 1%;"
                                            href="{{ url('tag/' . $tag) }}">#{{ $tag }}</a>
                                    @endforeach
                                @endif
                            </article>

                        </div>
                    </div>

                    {{-- <div class="section-bar clearfix">
                        <h2 class="section-title"><span
                                style="color:#ffed4d">Comments({{ count($comments->movie_comments) }}) </span></h2>
                    </div> --}}
                    <div class="entry-content clearfix">
                        <div class="video-item halim-entry-box">
                            <article id="post-38424" class="item-content">
                                <!-- Backend comment -->
                                {{-- <div>
                                    <div style="text-align: center">

                                        <form action="{{ route('add_comment', $movie->id) }}" method="POST">
                                            @csrf
                                            <textarea style="height: 150px; width:600px" name="comment" placeholder="Comment something here"></textarea>
                                            <br>
                                            <input type="submit" class="btn btn-primary" value="Comment">
                                        </form>
                                    </div>
                                    <div>
                                        <h1 style="font-size: 20px; padding-bottom:20px">All comment</h1>
                                        @foreach ($comments as $comment)
                                            <div>
                                                <b>{{ $comment->name }}</b>
                                                <p>{{ $comment->comment }}</p>
                                                <a href="javascript::void(0);" onclick="reply(this)"
                                                    data-Commentid="{{ $comment->id }}">Reply</a>
                                                @foreach ($replys as $rep)
                                                    @if ($rep->comment_id == $comment->id)
                                                        <div
                                                            style="padding-left: 3%;padding-bottom:10px;padding-bottom:10px;">
                                                            <b>{{ $rep->name }}</b>
                                                            <p>{{ $rep->reply }}</p>
                                                            <a href="javascript::void(0);" onclick="reply(this)"
                                                                data-Commentid="{{ $comment->id }}">Reply</a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endforeach
                                        <div style="display: none" class="replyDiv">
                                            <form action="{{ route('add_reply', $movie->id) }}" method="POST">
                                                @csrf
                                                <input type="text" id="commentId" name="commentId" hidden>
                                                <textarea style="height: 100px; width:300px" name="reply" placeholder="Reply something here"></textarea>

                                                <br>

                                                <input type="submit" class="btn btn-primary" value="Reply">

                                                <a href="javascript::void(0);" class="btn "
                                                    onclick="reply_close(this)">Close</a>
                                            </form>
                                        </div>
                                    </div>
                                </div> --}}

                                <!-- Backend comment -->
                                <!-- template comment -->
{{-- 
                                <style>
                                    .img-sm {
                                        width: 46px;
                                        height: 46px;
                                    }

                                    .panel {
                                        box-shadow: 0 2px 0 rgba(0, 0, 0, 0.075);
                                        border-radius: 0;
                                        border: 0;
                                        margin-bottom: 15px;
                                    }

                                    .panel .panel-footer,
                                    .panel>:last-child {
                                        border-bottom-left-radius: 0;
                                        border-bottom-right-radius: 0;
                                    }

                                    .panel .panel-heading,
                                    .panel>:first-child {
                                        border-top-left-radius: 0;
                                        border-top-right-radius: 0;
                                    }

                                    .panel-body {
                                        padding: 25px 20px;
                                    }


                                    .media-block .media-left {
                                        display: block;
                                        float: left
                                    }

                                    .media-block .media-right {
                                        float: right
                                    }

                                    .media-block .media-body {
                                        display: block;
                                        overflow: hidden;
                                        width: auto
                                    }

                                    .middle .media-left,
                                    .middle .media-right,
                                    .middle .media-body {
                                        vertical-align: middle
                                    }

                                    .thumbnail {
                                        border-radius: 0;
                                        border-color: #e9e9e9
                                    }

                                    .tag.tag-sm,
                                    .btn-group-sm>.tag {
                                        padding: 5px 10px;
                                    }

                                    .tag:not(.label) {
                                        background-color: #fff;
                                        padding: 6px 12px;
                                        border-radius: 2px;
                                        border: 1px solid #cdd6e1;
                                        font-size: 12px;
                                        line-height: 1.42857;
                                        vertical-align: middle;
                                        -webkit-transition: all .15s;
                                        transition: all .15s;
                                    }

                                    .text-muted,
                                    a.text-muted:hover,
                                    a.text-muted:focus {
                                        color: #acacac;
                                    }

                                    .text-sm {
                                        font-size: 0.9em;
                                    }

                                    .text-5x,
                                    .text-4x,
                                    .text-5x,
                                    .text-2x,
                                    .text-lg,
                                    .text-sm,
                                    .text-xs {
                                        line-height: 1.25;
                                    }

                                    .btn-trans {
                                        background-color: transparent;
                                        border-color: transparent;
                                        color: #929292;
                                    }

                                    .btn-icon {
                                        padding-left: 9px;
                                        padding-right: 9px;
                                    }

                                    .btn-sm,
                                    .btn-group-sm>.btn,
                                    .btn-icon.btn-sm {
                                        padding: 5px 10px !important;
                                    }

                                    .mar-top {
                                        margin-top: 15px;
                                    }
                                </style>
                                <div class="col-md-13 bootstrap snippets">
                                    <div class="panel">
                                        <div>
                                            <form id="comment" action="{{ route('add_comment', $movie->id) }}"
                                                method="POST">
                                                @csrf
                                                <textarea id="txtComment" class="form-control" rows="4" name="comment"
                                                    placeholder=@if (Auth::guard('customer')->check()) "Comment something here"
                                                @else
                                                'Please login to comment' @endif
                                                    required></textarea>
                                                <div class="mar-top clearfix"></div>
                                                @if (Auth::guard('customer')->check())
                                                    <button type="submit"
                                                        class="btn btn-success btn-circle text-uppercase pull-right check-login"
                                                        value="Sent"><i class="fa-solid fa-paper-plane fa-xl"></i>
                                                        Sent</button>
                                                @else
                                                    <a class="btn btn-success btn-circle text-uppercase pull-right check-login"
                                                        data-toggle="modal" data-target="#exampleModal1">
                                                        Sent
                                                    </a>
                                                @endif
                                            </form>

                                        </div>
                                    </div>
                                    <div style="padding: 1%" class="panel">
                                        <div class="panel-body">
                                            <style>
                                                .avatar {
                                                    width: 52px;
                                                    height: 52px;
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    background-color: #ccc;
                                                    border-radius: 50%;
                                                    font-family: sans-serif;
                                                    color: #fff;
                                                    font-weight: bold;
                                                    font-size: 25px;
                                                    margin: 15px auto;
                                                }
                                            </style>
                                            <!-- Newsfeed Content -->
                                            <!--===================================================-->
                                            @foreach ($comments->movie_comments->where('status', 1) as $comment)
                                                <div class="comment-container ty-compact-list">
                                                    <div class="media-block">

                                                        <a class="media-left" href="javascript::void(0);">
                                                           
                                                            <img style="width: 60px;" class="img-circle img-sm"
                                                                alt="Profile Picture"
                                                                @if ($comment->user->avatar == '') src="https://dataqq.net/tvhay/user/thumb-df-user.png"
                                                                @else
                                                                src="{{ $comment->user->avatar }}" @endif>
                                                        </a>
                                                        
                                                        <div class="media-body">
                                                            <div class="mar-btm"
                                                                style="padding: 1%;padding-bottom:1%;border-radius: 6px; background-color:#cacaca">
                                                                <p style="text-align: right;color:#000"
                                                                    class="text-muted text-sm">
                                                                  
                                                                    {{ \Carbon\Carbon::parse($comment->updated_at)->subHours(7)->shortRelativeDiffForHumans() }}
                                                                </p>
                                                                @if (Auth::guard('customer')->check() && Auth::guard('customer')->user()->id == $comment->user_id)
                                                                    <p style="text-align: right;"
                                                                        class="text-muted text-sm">
                                                                        <button type="button"
                                                                            onclick="convertToInput({{ $comment->id }})"
                                                                            style="color: #000"><i
                                                                                class="fa-regular fa-pen-to-square fa-lg"
                                                                                style="color: #2190f7;"></i></button>
                                                                        <button type="button"
                                                                            value="{{ $comment->id }}"
                                                                            class="deleteComment" style="color: #000"><i
                                                                                class="fa-solid fa-delete-left fa-lg"
                                                                                style="color: #ff0000;"></i></button>

                                                                    </p>
                                                                @endif


                                                                <a style="font-size: 18px;color:#000"
                                                                    class="text-semibold media-heading box-inline">
                                                                    Name: {{ $comment->user->name }}</a>
                                                                <p id="comment_{{ $comment->id }}"
                                                                    style="font-size: 16px">
                                                                    {{ $comment->comment }} </p>
                                                            </div>

                                                            <div class="pad-ver" style="padding-top:1%;">
                                                              
                                                                <a href="javascript::void(0);"
                                                                    class="btn-reply btn btn-info btn-circle text-uppercase"
                                                                    onclick="reply(this)"
                                                                    data-Commentid="{{ $comment->id }}"><i
                                                                        class="fa-solid fa-share fa-xl"></i>Reply</a>
                                                                <button
                                                                    @if (count($comment->replies) < 1) style="display: none;" @endif
                                                                    onclick="more(this)" target="{{ $count++ }}"
                                                                    class="btn btn-warning btn-circle text-uppercase more">More</button>
                                                                <div id="saveComment_{{ $comment->id }}"></div>
                                                            </div>

                                                            <hr>

                                                            <!-- Comments -->
                                                            <div style="display: none;padding: 2%"
                                                                class="div{{ $counts++ }}">
                                                                @foreach ($comment->replies->where('status', 1) as $reply)
                                                                    <div class="comment-container">
                                                                        <div class="media-block">
                                                                            <style>
                                                                                .avatars {
                                                                                    width: 52px;
                                                                                    height: 52px;
                                                                                    display: flex;
                                                                                    align-items: center;
                                                                                    justify-content: center;
                                                                                    background-color: #e98b8b;
                                                                                    border-radius: 50%;
                                                                                    font-family: sans-serif;
                                                                                    color: #fff;
                                                                                    font-weight: bold;
                                                                                    font-size: 25px;
                                                                                    margin: 15px auto;
                                                                                }
                                                                            </style>
                                                                            <a class="media-left"
                                                                                href="javascript::void(0);">
                                                                              
                                                                                <img class="img-circle img-sm"
                                                                                    alt="Profile Picture"
                                                                                    @if ($reply->user->avatar == '') src="https://dataqq.net/tvhay/user/thumb-df-user.png"
                                                                                    @else
                                                                                    src="{{ $reply->user->avatar }}" @endif>
                                                                            </a>
                                                                            <div class="media-body">
                                                                                <div class="mar-btm"
                                                                                    style="padding: 1%;padding-bottom:1%;border-radius: 6px; background-color:#cacaca">
                                                                                    <p style="color:#000;text-align: right;"
                                                                                        class="text-muted text-sm ">
                                                                                      
                                                                                        {{ \Carbon\Carbon::parse($reply->updated_at)->subHours(7)->diffForHumans() }}
                                                                                    </p>
                                                                                    @if (Auth::guard('customer')->check() && Auth::guard('customer')->user()->id == $comment->user_id)
                                                                                        <p style="text-align: right;"
                                                                                            class="text-muted text-sm">
                                                                                            <button type="button"
                                                                                                onclick="convertToInput({{ $reply->id }})"
                                                                                                style="color: #000"><i
                                                                                                    class="fa-regular fa-pen-to-square fa-lg"
                                                                                                    style="color: #2190f7;"></i></button>
                                                                                            <button type="button"
                                                                                                value="{{ $reply->id }}"
                                                                                                class="deleteComment"
                                                                                                style="color: #000"><i
                                                                                                    class="fa-solid fa-delete-left fa-lg"
                                                                                                    style="color: #ff0000;"></i></button>

                                                                                        </p>
                                                                                    @endif
                                                                                    <a style="color: #000"
                                                                                        href="javascript::void(0);"
                                                                                        class=" text-semibold media-heading box-inline">Name:
                                                                                        {{ $reply->user->name }}</a>
                                                                                    <p id="comment_{{ $reply->id }}"
                                                                                        style="font-size: 14px;backgroud:#fff">
                                                                                        {{ $reply->comment }}
                                                                                    </p>
                                                                                </div>


                                                                                <div class="pad-ver" style="padding: 1%">
                                                                                   
                                                                                    <a href="javascript::void(0);"
                                                                                        class="btn-reply btn btn-info btn-circle text-uppercase"
                                                                                        onclick="reply(this)"
                                                                                        data-Commentid="{{ $reply->id }}">Reply</a>
                                                                                    <div
                                                                                        id="saveComment_{{ $reply->id }}">
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <div class="">
                                                                                    @foreach ($reply->replies->where('status', 1) as $rep)
                                                                                        <div class="comment-container">
                                                                                            <div class="media-block">
                                                                                                <style>
                                                                                                    .avatars {
                                                                                                        width: 52px;
                                                                                                        height: 52px;
                                                                                                        display: flex;
                                                                                                        align-items: center;
                                                                                                        justify-content: center;
                                                                                                        background-color: #e98b8b;
                                                                                                        border-radius: 50%;
                                                                                                        font-family: sans-serif;
                                                                                                        color: #fff;
                                                                                                        font-weight: bold;
                                                                                                        font-size: 25px;
                                                                                                        margin: 15px auto;
                                                                                                    }
                                                                                                </style>
                                                                                                <a class="media-left"
                                                                                                    href="javascript::void(0);">
                                                                                                   

                                                                                                    <img class="img-circle img-sm"
                                                                                                        alt="Profile Picture"
                                                                                                        @if ($rep->user->avatar == '') src="https://dataqq.net/tvhay/user/thumb-df-user.png"    
                                                                                                        @else
                                                                                                        src="{{ $rep->user->avatar }}" @endif>
                                                                                                </a>
                                                                                                <div class="media-body">
                                                                                                    <div class="mar-btm"
                                                                                                        style="padding: 1%;padding-bottom:1%;border-radius: 6px; background-color:#cacaca">
                                                                                                        <p style="color:#000;text-align: right;"
                                                                                                            class="text-muted text-sm ">
                                                                                                       
                                                                                                            {{ \Carbon\Carbon::parse($rep->updated_at)->subHours(7)->diffForHumans() }}
                                                                                                        </p>
                                                                                                        @if (Auth::guard('customer')->check() && Auth::guard('customer')->user()->id == $rep->user_id)
                                                                                                            <p style="text-align: right;"
                                                                                                                class="text-muted text-sm">
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    onclick="convertToInput({{ $rep->id }})"
                                                                                                                    style="color: #000"><i
                                                                                                                        class="fa-regular fa-pen-to-square fa-lg"
                                                                                                                        style="color: #2190f7;"></i></button>
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    value="{{ $rep->id }}"
                                                                                                                    class="deleteComment"
                                                                                                                    style="color: #000"><i
                                                                                                                        class="fa-solid fa-delete-left fa-lg"
                                                                                                                        style="color: #ff0000;"></i></button>
                                                                                                            </p>
                                                                                                        @endif
                                                                                                        <a style="color: #000"
                                                                                                            href="javascript::void(0);"
                                                                                                            class=" text-semibold media-heading box-inline">Name:
                                                                                                            {{ $rep->user->name }}</a>
                                                                                                        <p id="comment_{{ $rep->id }}"
                                                                                                            style="font-size: 14px;">

                                                                                                            {{ $rep->comment }}
                                                                                                        </p>
                                                                                                    </div>
                                                                                                    <div class="pad-ver"
                                                                                                        style="padding: 1%">
                                                                                                       
                                                                                                        <a href="javascript::void(0);"
                                                                                                            class="btn-reply btn btn-info btn-circle text-uppercase"
                                                                                                            onclick="reply(this)"
                                                                                                            data-Commentid="{{ $reply->id }}">Reply</a>
                                                                                                        <div
                                                                                                            id="saveComment_{{ $rep->id }}">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <hr>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div style="display: none; margin-top: 1%;" class="replyDiv">
                                                <form id="comments" action="{{ route('add_reply', $movie->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="text" id="commentId" name="commentId" hidden>
                                                    <textarea id="txtComments" class="form-control" rows="2" name="reply" placeholder="Reply something here"
                                                        required></textarea>

                                                    <br>
                                                    <div style="display:flex; justify-content: flex-end;">
                                                        <button> <input type="submit"
                                                                class="btn btn-success btn-circle text-uppercase"
                                                                value="Reply">
                                                        </button>
                                                        <button> <a href="javascript::void(0);" class="btn text-danger"
                                                                onclick="reply_close(this)">Close</a>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div> --}}
                                            <!--===================================================-->
                                            <!-- End Newsfeed Content -->

                                            {{-- <div class="text-center">
                                                <span
                                                    style="display: none;
                                                cursor: pointer;"
                                                    class="btn btn-sm btn-default btn-hover-primary show-more"> Show more
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </article> --}}

                        </div>
                    </div>
                </div>
            </section>


            <section class="related-movies">
                <div id="halim_related_movies-2xx" class="wrap-slider">
                    <div class="section-bar clearfix">
                        <h3 class="section-title"><span>Recommend</span></h3>
                    </div>
                    <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">
                        @foreach ($related as $key => $rel)
                            <article class="thumb grid-item post-38498">
                                <div class="halim-item">
                                    <a class="halim-thumb" href="{{ route('movie', $rel->slug) }}"
                                        title="{{ $rel->title }}">
                                        <figure>


                                            @php
                                                $image_check = substr($rel->movie_image->image, 0, 5);
                                            @endphp
                                            @if ($image_check == 'https')
                                                <img style="height: 300px;" class="lazy img-responsive"
                                                    src="{{ $rel->movie_image->image }}" alt="{{ $rel->title }}"
                                                    title="{{ $rel->title }}">
                                            @else
                                                <img style="height: 300px;" class="lazy img-responsive"
                                                    src="{{ asset('uploads/movie/' . $rel->movie_image->image) }}"
                                                    alt="{{ $rel->title }}" title="{{ $rel->title }}">
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
        {{-- @include('pages.topview') --}}
    </div>
    {{-- <div id="dialog-3" title="Notify">
        Please login to download movie {{ $movie->name_english }}
    </div> --}}

    {{-- <script>
        function showNotify() {
            alert("Vui lòng login để download movie!");
            location.href = "{{ route('user-login') }}"
        }
    </script> --}}
    {{-- <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> --}}
    <script type='text/javascript' src='/js/jquery-ui.js'></script>
    <!-- Javascript -->
    <script>
        $(document).ready(function() {
            $(document).on('click', '.deleteComment', function() {
                if (confirm('Are you sure you want to delete this comment?')) {
                    var thisClicked = $(this);
                    var comment_id = thisClicked.val();

                    $.ajax({
                        url: "{{ route('delete-comment') }}",
                        method: "POST",
                        data: {
                            comment_id: comment_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            thisClicked.closest('.comment-container').remove();
                        },
                        error: function() {
                            alert('Delete faile.');
                        }
                    })
                }
            })
        })
    </script>
    <script>
        function convertToInput(commentId) {
            // Lấy thẻ <p> chứa nội dung bình luận
            var commentParagraph = document.getElementById('comment_' + commentId);
            var commentSave = document.getElementById('saveComment_' + commentId);

            var btnElement = document.createElement('button');
            btnElement.id = 'saveComment_' + commentId;
            btnElement.classList.add('btn');
            btnElement.classList.add('btn-warning');
            btnElement.classList.add('btn-circle');
            btnElement.classList.add('text-uppercase');
            btnElement.innerText = 'Save';
            btnElement.style.display = '';
            btnElement.onclick = function() {
                // Thực hiện hành động 
                var comment_id = commentId;
                var comment = inputElement.value;

                $.ajax({
                    url: "{{ route('edit-comment') }}",
                    method: "POST",
                    data: {
                        comment_id: commentId,
                        comment: comment,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        var commentParagraph = document.getElementById('editComment_' + commentId);
                        var inputElement = document.createElement('p');

                        inputElement.innerText = comment;
                        // Thêm id và class cho ô input để dễ dàng quản lý
                        inputElement.id = 'comment_' + commentId;
                        inputElement.style.fontSize = '16px';
                        commentParagraph.parentNode.replaceChild(inputElement, commentParagraph);
                        btnElement.style.display = 'none';

                    },
                    error: function() {
                        alert('Edit faile.');
                    }
                })
            };

            // Tạo một ô input
            var inputElement = document.createElement('input');
            inputElement.type = 'text';
            inputElement.value = commentParagraph.innerText;
            // Thêm id và class cho ô input để dễ dàng quản lý
            inputElement.id = 'editComment_' + commentId;
            inputElement.classList.add('form-control'); // Thêm class Bootstrap cho ô input
            inputElement.required = true;
            // Thay thế thẻ <p> bằng ô input
            commentParagraph.parentNode.replaceChild(inputElement, commentParagraph);
            // Tự động focus vào ô input để người dùng có thể bắt đầu chỉnh sửa ngay lập tức
            commentSave.parentNode.replaceChild(btnElement, commentSave);
            inputElement.focus();
        }
    </script>

    <script>
        $(function() {
            $("#dialog-3").dialog({
                autoOpen: false,
                hide: "slide",
                show: "slide",
                height: 130,

            });
            $("#opener-3").click(function() {
                $("#dialog-3").dialog("open");

            });
            $('.ui-dialog-titlebar-close').click(function() {
                // location.href = "{{ route('user-login') }}"
            });
        });
    </script>
    <!-- Show filed reply -->
    <script type="text/javascript">
        function reply(caller) {

            document.getElementById('commentId').value = $(caller).attr('data-Commentid')
            $('.replyDiv').insertAfter($(caller));

            $('.replyDiv').show(500);
            $('.btn-reply').hide(500);
        }

        function reply_close(caller) {
            $('.btn-reply').show(500);
            $('.replyDiv').hide(500);

        }
    </script>
    <!-- show more reply comment -->
    <script type="text/javascript">
        function more(caller) {
            var divId = ".div" + $(caller).attr("target");

            $(divId).insertAfter($(caller));
            $(divId).toggle(700);


        }
        $(document).ready(function() {
            $('.more').on('click', function() {
                $(this).text() === 'More' ? $(this).text('Less') : $(this).text('More');
            });
        })
    </script>

    <!--Reload page still location ago -->
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>

    <!-- js show more ,show less comments -->
    <script type="text/javascript">
        $(document).ready(function() {
            //this will execute on page load(to be more specific when document ready event occurs)
            if ($('.ty-compact-list').length > 3) {

                $('.ty-compact-list:gt(2)').hide();
                $('.show-more').show(500);
            }

            $('.show-more').on('click', function() {
                //toggle elements with class .ty-compact-list that their index is bigger than 2
                $('.ty-compact-list:gt(2)').toggle(500);
                //change text of show more element just for demonstration purposes to this demo
                $(this).text() === 'Show more' ? $(this).text('Show less') : $(this).text('Show more');
            });
        });
    </script>

    <!-- check space in the input comment and reply -->
    <script type="text/javascript">
        document.getElementById('comment').addEventListener('submit', function(event) {
            var input = document.getElementById("txtComment").value;
            if (input !== input.trim()) {
                alert('Enter comment, please!');
                event.preventDefault();
                document.getElementById("txtComment").value = input.trim();
            }
        });
    </script>

    <script type="text/javascript">
        document.getElementById('comments').addEventListener('submit', function(event) {
            var input = document.getElementById("txtComments").value;
            if (input !== input.trim()) {
                alert('Enter reply, please!');
                event.preventDefault();
                document.getElementById("txtComments").value = input.trim();
            }
        });
    </script>


@endsection
