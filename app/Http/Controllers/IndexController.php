<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Movie_Genre;
use App\Models\Movie_History;
use App\Models\Movie_Views;
use App\Models\Rating;
use App\Models\Cast;
use App\Models\Directors;
use App\Models\Movie_Directors;
use App\Models\Movie_Cast;
use App\Models\Info;
use App\Models\Server;
use App\Models\Movie_Package;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{


    public function timkiem()
    {
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
            $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
            $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
            //$cate_slug = Category::where('slug', $slug)->first(); 

            $movie = Movie::where(function ($querys) {
                $search = $_GET['search'];
                $cast_slug = Cast::where('title', 'LIKE', '%' . $search . '%')->first();
                if (isset($cast_slug)) {
                    $movie_cast = Movie_Cast::where('cast_id', $cast_slug->id)->get();
                    $many_cast = [];
                    foreach ($movie_cast as $key => $movi) {
                        $many_cast[] = $movi->movie_id;
                    }
                } else {
                    $many_cast = [];
                }

                $querys->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('name_english', 'LIKE', '%' . $search . '%')->orWhereIn('id', $many_cast);
            })->where('status', 1)->withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->paginate(20);

            //dd($movie);


            // $movie = Movie::whereIn('id', $many_cast)->where('status', 1)->withCount(['episode' => function ($query) {
            //     $query->select(DB::raw('count(distinct(episode))'));
            // }])->orderBy('updated_at', 'DESC')->paginate(12);

            return view('pages.timkiem', compact('category', 'genre', 'country', 'search', 'movie'));
        } else {
            return redirect()->to('/');
        }
    }
    public function home()
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        //qua ba
        $category_home = Category::with(['movie' => function ($m) {
            $m->where('status', 1)->withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }]);
        }])->orderBy('position', 'ASC')->where('status', 1)->get();
        //$hot = Movie::with()->get();
        $hot = Movie::withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->where('hot', 1)->where('status', 1)->orderBy('updated_at', 'DESC')->get();

        $day = Carbon::today('Asia/Ho_Chi_Minh')->subDays(0)->startOfDay();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $week = Carbon::today('Asia/Ho_Chi_Minh')->subDays(7)->startOfDay();

        //dd($hot);
        $topview = Movie::select('title', 'slug', 'image', 'season', DB::raw('SUM(count_views) as count_views'))->groupBy('title', 'slug', 'image', 'season')->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')
            ->join('movie_image', 'movie_views.movie_id', '=', 'movie_image.movie_id')->where('status', 1)->orderBy('count_views', 'DESC')->paginate(5);

        $topview_day = Movie::join('movie_views', 'movies.id', '=', 'movie_views.movie_id')
            ->join('movie_image', 'movie_views.movie_id', '=', 'movie_image.movie_id')
            ->where('date_views', $day)->where('status', 1)->orderBy('count_views', 'DESC')->paginate(5);

        $topview_week = Movie::select('title', 'slug', 'image', 'season', DB::raw('SUM(count_views) as count_views'))->groupBy('title', 'slug', 'image', 'season')->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')
            ->join('movie_image', 'movie_views.movie_id', '=', 'movie_image.movie_id')
            ->whereBetween('date_views', [$week, $day])->where('status', 1)->orderBy('count_views', 'DESC')->paginate(5);
        //dd($topview_week);
        $topview_month = Movie::select('title', 'slug', 'image', 'season', DB::raw('SUM(count_views) as count_views'))->groupBy('title', 'slug', 'image', 'season')->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')
            ->join('movie_image', 'movie_views.movie_id', '=', 'movie_image.movie_id')
            ->whereBetween('date_views', [$startOfMonth, $endOfMonth])->where('status', 1)->orderBy('count_views', 'DESC')->paginate(5);
        //dd($topview_month);

        $movie_new = Movie::join('movie_views', 'movies.id', '=', 'movie_views.movie_id')
            ->join('movie_image', 'movie_views.movie_id', '=', 'movie_image.movie_id')
            ->where('status', 1)->orderBy('created_at', 'DESC')->paginate(10)->unique();

        // movie animation
        //id genre animation = 13
        $gen_slug = Genre::where('title', 'LIKE', '%hoat hinh%')->first();

        $movie_genre = Movie_Genre::where('genre_id', $gen_slug->id)->get();
        $many_genre = [];
        foreach ($movie_genre as $key => $movi) {
            $many_genre[] = $movi->movie_id;
        }
        $movie_animation = Movie::whereIn('id', $many_genre)->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->get();
        // dd($movie_animation);
        //dd($topview);
        
        return view('pages.home', compact('category', 'genre', 'country', 'category_home', 'hot', 'topview', 'movie_new', 'topview_day', 'topview_week', 'topview_month', 'movie_animation', 'gen_slug'));
    }
    public function category($slug)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $cate_slug = Category::where('slug', $slug)->first();
        if (!isset($cate_slug)) {
            return redirect()->back();
        }
        $movie = Movie::where('category_id', $cate_slug->id)->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(32);

        //dd($movie);
        return view('pages.category', compact('category', 'genre', 'country', 'cate_slug', 'movie'));
    }
    public function year($year)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        if ($year == 'more') {
            $movie = Movie::where('status', 1)->where('year', '<', 2000)->withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->orderBy('updated_at', 'DESC')->paginate(32);
        } else {

            $movie = Movie::where('status', 1)->where('year', $year)->withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->orderBy('updated_at', 'DESC')->paginate(32);
        }

        //dd($movie);
        return view('pages.year', compact('category', 'genre', 'country', 'year', 'movie'));
    }

    public function tag($tag)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $tag = $tag;
        $movie = Movie::join('movie_tags', 'movies.id', '=', 'movie_tags.movie_id')->where('tags', 'LIKE', '%' . $tag . '%')->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(32);
        //dd($movie);
        return view('pages.tag', compact('category', 'genre', 'country', 'tag', 'movie'));
    }
    public function genre($slug)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $gen_slug = Genre::where('slug', $slug)->first();
        if (!isset($gen_slug)) {
            return redirect()->back();
        }
        $movie_genre = Movie_Genre::where('genre_id', $gen_slug->id)->get();
        $many_genre = [];
        foreach ($movie_genre as $key => $movi) {
            $many_genre[] = $movi->movie_id;
        }
        $movie = Movie::whereIn('id', $many_genre)->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(32);
        //dd($many_genre);
        return view('pages.genre', compact('category', 'genre', 'country', 'gen_slug', 'movie'));
    }
    public function country($slug)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $count_slug = Country::where('slug', $slug)->first();
        if (!isset($count_slug)) {
            return redirect()->back();
        }
        $movie = Movie::where('country_id', $count_slug->id)->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(8);
        return view('pages.country', compact('category', 'genre', 'country', 'count_slug', 'movie'));
    }
    public function all_movies()
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();

        $movie = Movie::where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(8);
        //dd($many_genre);
        return view('pages.allmovies', compact('category', 'genre', 'country', 'movie'));
    }
    public function directors($slug)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $directors_slug = Directors::where('slug', $slug)->first();
        if (!isset($directors_slug)) {
            return redirect()->back();
        }
        $movie_directors = Movie_Directors::where('directors_id', $directors_slug->id)->get();
        $many_directors = [];
        foreach ($movie_directors as $key => $movi) {
            $many_directors[] = $movi->movie_id;
        }
        $movie = Movie::whereIn('id', $many_directors)->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(32);
        //dd($many_genre);
        return view('pages.directors', compact('category', 'genre', 'country', 'directors_slug', 'movie'));
    }
    public function cast($slug)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $cast_slug = Cast::where('slug', $slug)->first();
        if (!isset($cast_slug)) {
            return redirect()->back();
        }
        $movie_cast = Movie_Cast::where('cast_id', $cast_slug->id)->get();

        $many_cast = [];
        foreach ($movie_cast as $key => $movi) {
            $many_cast[] = $movi->movie_id;
        }
        $movie = Movie::whereIn('id', $many_cast)->where('status', 1)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderBy('updated_at', 'DESC')->paginate(32);
        //dd($many_genre);
        return view('pages.cast', compact('category', 'genre', 'country', 'cast_slug', 'movie'));
    }
    public function movie(Request $request, $slug)
    {
        //check internet
        $connected = @fsockopen("www.omdbapi.com", 80);
        //website, port  (try 80 or 443)
        if ($connected) {
            $is_conn = true; //action when connected
            fclose($connected);
        } else {
            $is_conn = false; //action in connection failure
        }


        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $movie = Movie::with('category', 'genre', 'country', 'movie_genre', 'movie_cast', 'movie_directors', 'movie_tags', 'movie_views')->where('slug', $slug)->where('status', 1)->first();
        if (!isset($movie)) {
            return redirect()->back();
        }
        $minutes = Movie::select('time')->where('slug', $slug)->first();
        if (floor($minutes->time / 60) == 0) {
            $times = ($minutes->time - floor($minutes->time / 60) * 60) . 'm';
        } elseif (($minutes->time - floor($minutes->time / 60) * 60) == 0) {
            $times = floor($minutes->time / 60) . 'h';
        } else
            $times = floor($minutes->time / 60) . 'h ' . ($minutes->time - floor($minutes->time / 60) * 60) . 'm';


        $related = Movie::with('category', 'genre', 'country')->where('status', 1)->where('category_id', $movie->category->id)->withCount(['episode' => function ($query) {
            $query->select(DB::raw('count(distinct(episode))'));
        }])->orderby(DB::raw('RAND()'))->whereNotIn('slug', [$slug])->get();
        $episode_first = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode', 'ASC')->take(1)->first();
        //lay tap phim
        $query = "CAST(episode AS SIGNED INTEGER) DESC";
        $episode = Episode::with('movie')->where('movie_id', $movie->id)->orderByRaw($query)->take(4)->get()->unique('episode');
        //dd($episode);
        //lay tap da them link
        $episode_current_list = Episode::with('movie')->where('movie_id', $movie->id)->get()->unique('episode');
        $episode_current_list_count = $episode_current_list->count();

        //xu ly api from imdb
        // $data = Movie::with('movie_rating')->where('slug', $slug)->where('status', 1)->first();

        // foreach ($data->movie_rating as $value) {

        if ($is_conn == true) {
            $api_imdb = Http::get('https://www.omdbapi.com/?i=' . $movie->imdb . '&apikey=6c2f1ca1');


            if ($api_imdb->status() == 200) {
                if ($api_imdb['Response'] == "True" && $api_imdb['imdbRating'] != "N/A") {
                    $values = $api_imdb['imdbRating'] . ' /10';
                } elseif ($api_imdb['Response'] == "False") {
                    $values = "N/A";
                } elseif ($api_imdb['Response'] == "True") {
                    $values = $api_imdb['imdbRating'];
                }
            } else
                return $values = "N/A";
        } else
            return $values = "Connection false!";

        $link_imdb = ('https://www.imdb.com/title/' . $movie->imdb);
        // }
        //xu ly comments
       // $comments = Movie::with('movie_comments.replies', 'movie_comments.user:id,name,avatar', 'movie_comments.replies.user:id,name,avatar', 'movie_comments.replies.replies.user:id,name,avatar')->where('slug', $slug)->first();


        // $avatar_comment = Comment::join('customers','comments.user_id','=','customers.id')->where('movie_id', $movie->id)->orderBy('comments.id', 'DESC')->get();

        // $avatar_reply = Reply::join('customers','replies.user_id','=','customers.id')->where('movie_id', $movie->id)->get();

        // $count = 0;
        // $counts = 0;

        //dd($data['comment_id']);
        //xuly comment

        //$movie_tags = Movie::select('tags')->join('movie_tags', 'movies.id', '=', 'movie_tags.movie_id')->where('slug', $slug)->get();
        //$movie_tags = Movie::with('movie_tags')->where('slug', $slug)->get();

        //dd($movie_tags);
        //dd($replys);
        // $user = Customer::where('status', 1)->get();
        // if (Auth::guard('customer')->check($user)) {
        //     $user_id = Auth::guard('customer')->user()->id;
        // } else {
        //     $user_id = '0';
        // }
        //$watched = Movie_History::where('user_id', $user_id)->where('movie_id', $movie->id)->get();
        //dd($watched);
        $rating = Rating::where('movie_id', $movie->id)->avg('rating');
        $rating = round($rating, 1);
        $count_total = Rating::where('movie_id', $movie->id)->count();

        //save views movie for day
        $day = Carbon::today('Asia/Ho_Chi_Minh')->subDays(0)->startOfDay();


        $count_view = Movie_Views::where('movie_id', $movie->id)->where('date_views', $day)->first();
        if ($count_view) {
            $count_views = $count_view->count_views + 1;
            $count_view->count_views = $count_views;
            //dd($count_view);
            $count_view->save();
        } else {
            $count_view = new Movie_Views();
            $count_view->count_views = '1';
            $count_view->movie_id = $movie->id;
            $count_view->date_views = Carbon::now('Asia/Ho_Chi_Minh')->format('Y:m:d');
            $count_view->save();
        }



        return view('pages.movie', compact('category', 'genre', 'country', 'movie', 'related', 'episode', 'episode_first', 'episode_current_list_count', 'times', 'values', 'link_imdb', 'count_total', 'rating'));
    }
    public function add_rating(Request $request)
    {
        $data = $request->all();
        $ip_address = $request->ip();

        //reviews get ip_address

        // $rating_count = Rating::where('movie_id', $data['movie_id'])->where('ip_address', $ip_address)->count();
        // if ($rating_count > 0) {
        //     echo 'exist';
        // } else {
        //     $rating = new Rating();
        //     $rating->movie_id = $data['movie_id'];
        //     $rating->rating = $data['index'];
        //     $rating->ip_address = $ip_address;
        //     $rating->save();
        //     echo 'done';
        // }

        //reviews free
        $rating = new Rating();
        $rating->movie_id = $data['movie_id'];
        $rating->rating = $data['index'];
        $rating->ip_address = $ip_address;
        $rating->save();
        echo 'done';
    }
    public function title($slug, $tap)
    {
        $movie = Movie::where('slug', $slug)->where('status', 1)->first();
        //dd($movie);
        $tapphim = $tap;
        return view('layout', compact('movie', 'tapphim'));
    }
    public function watch($slug, $tap, $server_active)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $movie = Movie::with('category', 'genre', 'country', 'episode')->where('slug', $slug)->where('status', 1)->first();
        // if ($movie->paid_movie != 0) {
        //     // kiem tra ngay het han
        //     $check_order = Order::where('customer_id', Session::get('customer_id'))->where('expiry', 0)->get();
        //     foreach ($check_order as $check) {
        //         // $date_now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        //         // //$datework = Carbon::createFromDate($date_now);
        //         // $expiry_date = Carbon::createFromDate($check->date_end)->format('d-m-Y');;

        //         if ($check->date_end->isPast()) {
        //             $check->expiry = "1";
        //             $check->save();
        //             // update account
        //             $customer = Customer::find(Session::get('customer_id'));
        //             $customer->status_registration = "0";
        //             $customer->save();
        //         }
        //     }
        //     $user = Customer::find(Session::get('customer_id'));
        //     if (isset($user) && $user->status_registration == 1) {
        //         if (Auth::guard('customer')->check()) {

        //             $movies_id = Movie::where('slug', $slug)->first();

        //             //$customer_id = Auth::guard('customer')->user()->id;
        //             $history = Movie_History::where('movie_id', $movies_id->id)->where('user_id', Session::get('customer_id'))->get();
        //             //dd(count($history));
        //             if (count($history) < 1) {
        //                 DB::table('movie_history')->insert(['movie_id' => $movies_id->id, 'user_id' => Session::get('customer_id'), 'created_at' => now(), 'updated_at' => now()]);
        //             }
        //         }
        //         //dd($tapphim);

        //         if (!isset($movie)) {
        //             return redirect()->back();
        //         }
        //         $related = Movie::with('category', 'genre', 'country')->where('status', 1)->where('category_id', $movie->category->id)->orderby(DB::raw('RAND()'))->whereNotIn('slug', [$slug])->withCount(['episode' => function ($query) {
        //             $query->select(DB::raw('count(distinct(episode))'));
        //         }])->get();

        //         $ser = substr($server_active, 7, 10);

        //         try {
        //             if (isset($tap)) {
        //                 $tapphim = $tap;
        //                 $tapphim = substr($tap, 4, 10);
        //                 $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->where('server_id', $ser)->first();
        //                 if (!isset($episode)) {
        //                     return redirect()->back();
        //                 }
        //             } else {
        //                 $tapphim = 1;
        //                 $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->where('server_id', $ser)->first();
        //             }

        //             $server = Server::orderby('id', 'DESC')->get();
        //             $views = Movie::select('title', DB::raw('SUM(count_views) as count_views'))->groupBy('title')->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')
        //                 ->where('movies.id', $movie->id)->orderBy('count_views', 'DESC')->first();

        //             $episode_movie = Episode::where('movie_id', $movie->id)->get()->unique('server_id');
        //             $query = "CAST(episode AS SIGNED INTEGER) ASC";
        //             $episode_list = Episode::where('movie_id', $movie->id)->orderByRaw($query)->get();
        //             return view('pages.watch', compact('category', 'genre', 'country', 'movie', 'related', 'episode', 'tapphim', 'views', 'server', 'episode_movie', 'episode_list', 'server_active'));
        //         } catch (ModelNotFoundException $th) {
        //             return redirect()->back();
        //         }
        //     } else {
        //         return view('errors.400', compact('category', 'genre', 'country'));
        //     }
        // } 
        // else {
            // if (Auth::guard('customer')->check()) {

            //     $movies_id = Movie::where('slug', $slug)->first();

            //     $customer_id = Auth::guard('customer')->user()->id;
            //     $history = Movie_History::where('movie_id', $movies_id->id)->where('user_id', $customer_id)->get();
            //     //dd(count($history));
            //     if (count($history) < 1) {
            //         DB::table('movie_history')->insert(['movie_id' => $movies_id->id, 'user_id' => $customer_id, 'created_at' => now(), 'updated_at' => now()]);
            //         // DB::table('movie_history')->where('user_id', $user_id)->where('movie_id', $movie_id)->update(['updated_at' => now()]);
            //         //DB::table('movie_history')->insert(['movie_id' => $data['id'], 'created_at' => now(), 'updated_at' => now()]);
            //     }
            // }
            //dd($tapphim);

            if (!isset($movie)) {
                return redirect()->back();
            }
            $related = Movie::with('category', 'genre', 'country')->where('status', 1)->where('category_id', $movie->category->id)->orderby(DB::raw('RAND()'))->whereNotIn('slug', [$slug])->withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->get();

            $ser = substr($server_active, 7, 10);

            try {
                if (isset($tap)) {
                    $tapphim = $tap;
                    $tapphim = substr($tap, 4, 10);
                    $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->where('server_id', $ser)->first();
                    if (!isset($episode)) {
                        return redirect()->back();
                    }
                } else {
                    $tapphim = 1;
                    $episode = Episode::where('movie_id', $movie->id)->where('episode', $tapphim)->where('server_id', $ser)->first();
                }

                $server = Server::orderby('id', 'DESC')->get();
                $views = Movie::select('title', DB::raw('SUM(count_views) as count_views'))->groupBy('title')->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')
                    ->where('movies.id', $movie->id)->orderBy('count_views', 'DESC')->first();

                $episode_movie = Episode::where('movie_id', $movie->id)->get()->unique('server_id');
                $query = "CAST(episode AS SIGNED INTEGER) ASC";
                $episode_list = Episode::where('movie_id', $movie->id)->orderByRaw($query)->get();
                return view('pages.watch', compact('category', 'genre', 'country', 'movie', 'related', 'episode', 'tapphim', 'views', 'server', 'episode_movie', 'episode_list', 'server_active'));
            } catch (ModelNotFoundException $th) {
                return redirect()->back();
            }
        //}

        //return response()->json($movie);
    }
    public function episode()
    {
        return view('pages.episode');
    }
    //loc phim
    public function locphim()
    {

        //get
        $sort = $_GET['order'];
        $category_get = $_GET['category'];
        $genre_get = $_GET['genre'];
        $country_get = $_GET['country'];
        $year_get = $_GET['year'];

        if ($sort == "" && $category_get == "" && $genre_get == "" && $country_get == "" && $year_get == "") {

            return redirect()->back();
        } else {
            $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
            $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
            $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
            $movie_array = Movie::withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->where('status', 1);

            if ($category_get) {
                $movie_array = $movie_array->where('category_id', $category_get);
            }
            if ($country_get) {
                $movie_array = $movie_array->where('country_id', $country_get);
            }
            if ($year_get) {
                $movie_array = $movie_array->where('year', $year_get);
            }
            if ($sort == 'count_views') {
                // $movie_array = $movie_array->join('movie_views', 'movies.id', '=', 'movie_views.movie_id')->orderBy($sort, 'DESC');
            }
            if ($sort == 'created_at') {
                $movie_array = $movie_array->orderBy('created_at', 'DESC');
            }
            if ($sort == 'title') {
                $movie_array = $movie_array->orderBy('title', 'ASC');
            }

            if ($genre_get) {
                $gen_slug = Genre::where('id', $genre_get)->first();
                $movie_genre = Movie_Genre::where('genre_id', $gen_slug->id)->get();
                $many_genre = [];
                foreach ($movie_genre as $key => $movi) {
                    $many_genre[] = $movi->movie_id;
                }
                $movie_array = $movie_array->whereIn('id', $many_genre);
            }


            // $movie_array = $movie_array->with('movie_genre');

            // $movie = array();
            // foreach ($movie_array as $mov) {
            //     dd($mov);
            //     foreach ($mov->movie_genre as $mov_gen) {
            //         $movie = $movie_array->whereIn('genre_id', [$mov_gen->genre_id]);
            //     }
            // }

            $movie = $movie_array->paginate(20);

            return view('pages.locphim', compact('category', 'genre', 'country', 'movie'));
        }
    }
    public function history()
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $user = Customer::where('status', 1)->get();
        if (Auth::guard('customer')->check($user)) {
            $user_id = Auth::guard('customer')->user()->id;
            //    $history = Movie_History::where('user_id', $user_id)->get();
        }

        if (isset($user_id)) {
            $movie = Movie::join('movie_history', 'movies.id', '=', 'movie_history.movie_id')->withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->with('category', 'genre', 'country')->where('user_id', $user_id)->where('status', 1)->orderBy('created_at', 'DESC')->get();
        } else {
            $movie = null;
        }


        return view('pages.movies_history', compact('movie', 'category', 'genre', 'country'));
    }
   private function check_expiry(){
     // kiem tra ngay het han
     $check_order = Order::where('customer_id', Session::get('customer_id'))->where('expiry', 0)->get();
     foreach ($check_order as $check) {
         if ($check->date_end->isPast()) {
             $check->expiry = "1";
             $check->save();
             // update account
             $customer = Customer::find(Session::get('customer_id'));
             $customer->status_registration = "0";
             $customer->save();
         }
     }
   }
    public function register_package()
    {
        // kiem tra ngay het han
        $check_order = Order::where('customer_id', Session::get('customer_id'))->where('expiry', 0)->get();
        foreach ($check_order as $check) {
            // $date_now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
            // $datework = Carbon::createFromDate($check->date_start);
            // $expiry_date = Carbon::createFromDate($check->date_end)->format('d-m-Y');
            // //$expiry_date = $check->date_end;
            // $check_date = $datework->diffInDays($expiry_date);
            if ($check->date_end->isPast()) {
                $check->expiry = "1";
                $check->save();
                // update account
                $customer = Customer::find(Session::get('customer_id'));
                $customer->status_registration = "0";
                $customer->save();
            }
        }

        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        $list_package = Movie_Package::where('status', 1)->orderBy('price')->get();

        // check status payment vnpay
        if (isset($_GET['vnp_SecureHash'])) {
            $vnp_HashSecret = env('VNP_HASHSECRET', '');
            $vnp_SecureHash = $_GET['vnp_SecureHash'];
            $inputData = array();
            foreach ($_GET as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }

            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }

            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
            if ($secureHash == $vnp_SecureHash) {
                if ($_GET['vnp_ResponseCode'] == '00') {
                    $customer_id = Session::get('customer_id');
                    $package_id = Session::get('package_id');
                    $date = Session::get('package_time');
                    $price = Session::get('package_price');
                    $total= Session::get('total_vnpay');
                    $name_package= Session::get('package_name');

                    $order = new Order;
                    $order->customer_id = $customer_id;
                    $order->package_id = $package_id;
                    $order->price = $price;
                    $order->payment = 'vnpay';
                    $order->number_date = $date;
                    $order->expiry = '0';
                    $order->date_start = Carbon::now('Asia/Ho_Chi_Minh');
                    $order->date_end = Carbon::now('Asia/Ho_Chi_Minh')->addDays($date);
                    $order->save();

                    //modify status register package movie
                    $customer = Customer::where('id', $customer_id)->first();
                    $customer->status_registration = '1';
                    $customer->save();


                     //sent data email order
                     $price_format=  number_format($price, 0, '', ',');
                     $total_format=  number_format($total, 0, '', ',');
                     $email=$customer->email;
                     $orderId = $order->id;
                     $payment="vnpay";
                     //dd($email);
                    
                     return $this->sentEmail($email,$price_format,$name_package,$total_format,$date,$orderId,$payment);
                     //end sent email

        
                    // return redirect()->route('register-package')->with('success', 'Thanh toán thành công. Cảm ơn bạn đã sử dụng dịch vụ.');
                } else {
                    return redirect()->route('register-package')->with('error', $response['message'] ?? 'Đăng ký gói không thành công. Do bạn đã hủy giao dịch.');
                }
            } else {
                return redirect()->route('register-package')->with('error', $response['message'] ?? 'Đã có lỗi xảy ra trong quá trình thanh toán. Vui lòng kiểm tra lại.');
            }
        }
        // check status payment momo
        header('Content-type: text/html; charset=utf-8');
        $secretKey = env('SECRETKEY', ''); //Put your secret key in there

        if (!empty($_GET['partnerCode'])) {
            $partnerCode = $_GET["partnerCode"];
            $accessKey = $_GET["accessKey"];
            $orderId = $_GET["orderId"];
            $localMessage = ($_GET["localMessage"]);
            $message = $_GET["message"];
            $transId = $_GET["transId"];
            $orderInfo = ($_GET["orderInfo"]);
            $amount = $_GET["amount"];
            $errorCode = $_GET["errorCode"];
            $responseTime = $_GET["responseTime"];
            $requestId = $_GET["requestId"];
            $extraData = $_GET["extraData"];
            $payType = $_GET["payType"];
            $orderType = $_GET["orderType"];
            $extraData = $_GET["extraData"];
            $m2signature = $_GET["signature"]; //MoMo signature

            //Checksum
            $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
                "&orderType=" . $orderType . "&transId=" . $transId . "&message=" . $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime . "&errorCode=" . $errorCode .
                "&payType=" . $payType . "&extraData=" . $extraData;

            $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);

            if ($m2signature == $partnerSignature) {
                if ($errorCode == '0') {
                    try{
                        $customer_id = Session::get('customer_id');
                        $package_id = Session::get('package_id');
                        $date = Session::get('package_time');
                        $price = Session::get('package_price');
                        $name_package= Session::get('package_name');
                        $order = new Order;
                        $order->customer_id = $customer_id;
                        $order->package_id = $package_id;
                        $order->price = $price;
                        $order->payment = 'momo';
                        $order->number_date = $date;
                        $order->expiry = '0';
                        $order->date_start = Carbon::now('Asia/Ho_Chi_Minh');
                        $order->date_end = Carbon::now('Asia/Ho_Chi_Minh')->addDays($date);
                        $order->save();
    
                        //modify status register package movie
                        $customer = Customer::where('id', $customer_id)->first();
                        $customer->status_registration = '1';
                        $customer->save();
                    }
                    catch(ModelNotFoundException $exception){
                        return redirect()->route('register-package')->with('error', $response['message'] ?? 'Error 500!.');
                    }
                  
                    //sent data email order
                    $price_format=  number_format($price, 0, '', ',');
                    $total_format=  number_format($amount, 0, '', ',');
                    $email=$customer->email;
                    $payment="momo";
                    //dd($email);
                   
                    return $this->sentEmail($email,$price_format,$name_package,$total_format,$date,$orderId,$payment);
                    //end sent email
            
                    // return redirect()->route('register-package')->with('success', 'Thanh toán thành công. Cảm ơn bạn đã sử dụng dịch vụ.');
                } else {
                    return redirect()->route('register-package')->with('error', $response['message'] ?? 'Đăng ký gói không thành công. Do bạn đã hủy giao dịch.');
                }
            } else {
                return redirect()->route('register-package')->with('error', $response['message'] ?? 'Đã có lỗi xảy ra trong quá trình thanh toán. Vui lòng kiểm tra lại.');
            }
        }

        return view('pages.register_package', compact('category', 'genre', 'country', 'list_package'));
    }
    private function sentEmail($email,$price_format,$name_package,$total_format,$date,$orderId,$payment)
    {
       
        $to_name = "no-reply";
        $to_email = $email; //send to this email

        $data = array("name" => "FULLHDPHIM", "price" => $price_format,"name_package"=>$name_package,
        "total"=> $total_format,"date"=>$date,"orderId"=>$orderId,"payment"=>$payment);

        Mail::send('pages.sent_email',$data,function($message)use($to_name,$to_email){
            $message->to($to_email)->subject('Hóa Đơn Thanh Toán Gói Phim');
            $message->from($to_email,$to_name);//sent from this email
        });
        Session::forget('package_id');
        Session::forget('package_time');
        Session::forget('package_price');
        Session::forget('package_name');
        return redirect()->route('register-package')->with('success', 'Thanh toán thành công. Cảm ơn bạn đã sử dụng dịch vụ.');
    }
    public function checkout(Request $request)
    {
        //dd(Session::get('customer_id'));
        $data = $request->all();
        $validate = Movie_Package::where('status', 1)->find($data['id']);
        if (isset($validate)) {
            Session::put('package_id', $validate->id);
            Session::put('package_time', $validate->time);
            Session::put('package_price', $validate->price);
            Session::put('package_name', $validate->title);
            $user = Customer::where('id', Session::get('customer_id'))->first();
            if ($user->status_registration != 1) {
                return view('pages.checkout', compact('user', 'data', 'validate'));
            } else {
                return redirect()->back()->with('status_registration', 'Gói phim của bạn đang còn hạn sử dụng!');
            }
        } else {
            return redirect()->back()->with('status_registration', 'Bạn đừng nghịch nữa :))');
        }
    }

    public function payment(Request $request)
    {

        // $data = $request->all();
        //  dd($data);
    }
    public function history_order()
    {
        if (Auth::guard('customer')->check()) {
            $list_order = Order::with('package:id,title', 'user:id,name,email')->where('customer_id', Session::get('customer_id'))->paginate(8);
            //dd($list_order->toArray());
            return view('pages.history_order', compact('list_order'));
        } else {
            return view('errors.404');
        }
    }
    public function policy()
    {
       return view('pages.policy');
    }
}
