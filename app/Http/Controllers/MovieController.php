<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Movie_Genre;
use App\Models\Movie_Description;
use App\Models\Movie_Trailer;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Movie_Tags;
use App\Models\Movie_Views;
use App\Models\Movie_Image;
use App\Models\Cast;
use App\Models\Directors;
use App\Models\Movie_Cast;
use App\Models\Movie_Directors;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\isNull;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:viewer list', ['only' => 'index']);
        $this->middleware('permission:create movie', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit movie', ['only' => ['update', 'edit', 'movie_hot']]);
        $this->middleware('permission:delete movie', ['only' => ['destroy']]);
        $this->middleware('permission:viewer list|create movie|edit movie', ['update_season', 'update_year']);
    }
    public function index()
    {
        try {
            $category = Category::where('status', 1)->pluck('title', 'id');
            $genre = Genre::where('status', 1)->pluck('title', 'id');
            $list_genre = Genre::all()->where('status', 1);
            $country = Country::where('status', 1)->pluck('title', 'id');
            $list = Movie::with('category', 'movie_genre', 'country', 'genre', 'movie_description', 'movie_trailer', 'movie_tags', 'movie_image','movie_cast')->withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->orderBy('id', 'DESC')->get();

            $path = public_path() . "/json/";
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            File::put($path . 'movie.json', json_encode($list));
            //return json_encode($list);

            return view('admincp.movie.index', compact('list', 'genre', 'category', 'country', 'list_genre'));
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $category = Category::where('status', 1)->pluck('title', 'id');
            $genre = Genre::where('status', 1)->pluck('title', 'id');
            $list_genre = Genre::all()->where('status', 1);
            $list_cast = Cast::all()->where('status', 1)->reverse();
            $list_directors = Directors::all()->where('status', 1)->reverse();
            $country = Country::where('status', 1)->pluck('title', 'id');
            $list = Movie::with('category', 'movie_genre', 'movie_cast', 'movie_directors', 'country', 'genre', 'movie_description', 'movie_trailer', 'movie_tags')->orderBy('id', 'DESC')->get();

            // $path = public_path() . "/json/";
            // if (!is_dir($path)) {
            //     mkdir($path, 0777, true);
            // }
            // File::put($path . 'movie.json', json_encode($list));

            //return json_encode($list);
            return view('admincp.movie.form', compact('genre', 'category', 'country', 'list_genre', 'list_cast', 'list_directors'));
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $datas=$request->thuocphim;
            if($datas == 0 ){
                $validator = Validator::make($data = $request->all(), [
                    'title' => 'unique:movies',
                    // 'name_english' => 'unique:movies',
                    'slug' => 'unique:movies',
                ]);
            }
            else{
                $validator = Validator::make($data = $request->all(), [
                    'title' => 'unique:movies',
                    //'name_english' => 'unique:movies',
                    'slug' => 'unique:movies',
                ]);
            }
          
            if ($validator->fails()) {
                toastr()->warning('Movie "' . $data['title'] . '" is existing!', 'Warning');
                return redirect()->back();
            }
            //$data = $request->all();
            // $data = $request->validate(
            //     [
            //         //'title' => 'unique:movies ',
            //         'name_english' => 'unique:movies ',
            //         'slug' => 'unique:movies ',
            //     ]

            // );

            $movie = new Movie();
            $movie->title = $data['title'];
            $movie->name_english = $data['name_english'];

            $randomletter = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 6);
            $movie->slug = $data['slug'] . '-' . rand(1000, 9999) . $randomletter;
            $movie->year = $data['year'];
            $movie->thuocphim = $data['thuocphim'];
            $movie->time = $data['time'];
            $movie->hot = $data['hot'];
            $movie->quality = $data['quality'];
            $movie->paid_movie = $data['paid_movie'];
            $movie->language = $data['language'];
            //$movie->phim_hot = $data['phim_hot'];
            $movie->status = $data['status'];
            $movie->sotap = $data['sotap'];

            $movie->category_id = $data['category_id'];

            $movie->country_id = $data['country_id'];
            $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
            $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');

            if (!isset($data['genre'])) {
                toastr()->warning('Genre not empty!', 'Warning');
                return redirect()->back();
            } else {
                foreach ($data['genre'] as $key => $gen) {
                    // $movie->genre_id = $gen['0'];
                    $movie->genre_id = $gen['0'];
                }
            }

            try {
                $path_omdb='http://www.omdbapi.com/?t=';
                //0 = movie
                if($data['thuocphim'] == 0){
                    $api_omdb = Http::get($path_omdb . $data['name_english'] . '&y=' . $data['year'] .'&type=movie&apikey=6c2f1ca1');
                }
                //1 = series
                else{
                    $api_omdb = Http::get($path_omdb . $data['name_english'] . '&y=' . $data['year'] .'&type=series&apikey=6c2f1ca1');
                }
                if ($api_omdb['Response'] != 'True' && $data['thuocphim'] == 1) {
                    $api_omdb = Http::get($path_omdb . $data['name_english'] . '&type=series&apikey=6c2f1ca1');
                }
                elseif($api_omdb['Response'] != 'True'){
                    $api_omdb = Http::get($path_omdb . $data['name_english'] . '&apikey=6c2f1ca1');
                }
                
                // $imdb = new Movie_Rating();
                $movie->imdb = $api_omdb['imdbID'];
                // $imdb->movie_id = $movie->id;
                $movie->save();
            } catch (Exception $e) {
                //$imdb = new Movie_Rating();
                $movie->imdb  = "0";
                //$imdb->movie_id = $movie->id;
                $movie->save();
                toastr()->warning('Vui lòng cập nhật Id Imdb thủ công cho phim.', 'Warning',['timeOut' => 10000]);
            }

            //dd($data['genre']);
            //$movie->save();
            $movie->movie_genre()->attach($data['genre']);

            $get_image = $request->file('image');
            $path = 'uploads/movie/';
            if ($get_image) {
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);
                // $movie->image = $new_image;

                $movie_image = new Movie_Image();
                $movie_image->image = $new_image;
                $movie_image->movie_id = $movie->id;
                $movie_image->save();
            }

            // if (!is_null($movie)) {
            //     try {
            //         $path_omdb='http://www.omdbapi.com/?t=';
            //         //0 = movie
            //         if($data['thuocphim'] == 0){
            //             $api_omdb = Http::get($path_omdb . $data['name_english'] . '&y=' . $data['year'] .'&type=movie&apikey=6c2f1ca1');
            //         }
            //         //1 = series
            //         else{
            //             $api_omdb = Http::get($path_omdb . $data['name_english'] . '&y=' . $data['year'] .'&type=series&apikey=6c2f1ca1');
            //         }
            //         if ($api_omdb['Response'] != 'True' && $data['thuocphim'] == 1) {
            //             $api_omdb = Http::get($path_omdb . $data['name_english'] . '&type=series&apikey=6c2f1ca1');
            //         }
            //         elseif($api_omdb['Response'] != 'True'){
            //             $api_omdb = Http::get($path_omdb . $data['name_english'] . '&apikey=6c2f1ca1');
            //         }
                    
            //         $imdb = new Movie_Rating();
            //         $imdb->imdb = $api_omdb['imdbID'];
            //         $imdb->movie_id = $movie->id;
            //         $imdb->save();
            //     } catch (Exception $e) {
            //         $imdb = new Movie_Rating();
            //         $imdb->imdb = "0";
            //         $imdb->movie_id = $movie->id;
            //         $imdb->save();
            //         toastr()->warning('Vui lòng cập nhật Id Imdb thủ công cho phim.', 'Warning',['timeOut' => 10000]);
            //     }

            // }
            if (!is_null($movie)) {
                $description = new Movie_Description();
                $description->description = $request->description;
                $description->movie_id = $movie->id;
                $description->save();
            }
            if (!is_null($movie)) {
                $trailer = new Movie_Trailer();
                $trailer->trailer = $request->trailer;
                $trailer->movie_id = $movie->id;
                $trailer->save();
            }
            // if (!is_null($movie)) {
            //     $hot = new Movie_Hot();
            //     $hot->hot = $request->hot;
            //     $hot->movie_id = $movie->id;
            //     $hot->save();
            // }

            if (!is_null($movie)) {
                $count_view = new Movie_Views();
                $count_view->count_views = '0';
                $count_view->movie_id = $movie->id;
                $count_view->date_views = Carbon::now('Asia/Ho_Chi_Minh')->format('Y:m:d');
                $count_view->save();
            }

            if (!is_null($movie)) {
                $tags = new Movie_Tags();
                $tags->tags = $request->tags;
                $tags->movie_id = $movie->id;
                $tags->save();
            }



            if (!isset($data['cast'])) {
                toastr()->warning('Cast of movie "' . $movie->title . '" empty!', 'Warning');
                //return redirect()->route('movie.index');
            } else {
                $movie->movie_cast()->attach($data['cast']);
            }

            if (!isset($data['directors'])) {
                toastr()->warning('Directors of movie "' . $movie->title . '" empty!', 'Warning');
                //return redirect()->route('movie.index');
            } else {
                $movie->movie_directors()->attach($data['directors']);
            }

            toastr()->success('Movie "' . $movie->title . '" created successfully!', 'Create');
            return redirect()->route('movie.index');
            //return redirect()->back()->with('message_add', 'Add film successfully !');
        } catch (Exception $e) {
            toastr()->error('Movie create error' . $e, 'Error');
            return redirect()->route('movie.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $category = Category::where('status', 1)->pluck('title', 'id');
        $genre = Genre::where('status', 1)->pluck('title', 'id');
        $list_genre = Genre::all()->where('status', 1);
        $list_cast = Cast::all()->where('status', 1);
        $list_directors = Directors::all()->where('status', 1);
        // $genre = Genre::pluck('title', 'id');
        // $list_genre = Genre::where('status')->all();
        $country = Country::where('status', 1)->pluck('title', 'id');
        $list = Movie::with('category', 'genre', 'country', 'movie_description', 'movie_trailer', 'movie_tags', 'movie_image')->orderBy('id', 'DESC')->get();
        $movie = Movie::find($id);
        $movie_genre = $movie->movie_genre;
        $movie_cast = $movie->movie_cast;
        $movie_directors = $movie->movie_directors;
        $movie_description = $movie->movie_description;
        $movie_trailer = $movie->movie_trailer;
        $movie_tags = $movie->movie_tags;


        //return json_encode($movie_rating);
        return view('admincp.movie.form', compact('list', 'genre', 'category', 'country', 'movie', 'list_genre', 'movie_genre', 'list_cast', 'movie_cast', 'list_directors', 'movie_directors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $movie = Movie::find($id);
            $validator = Validator::make($data = $request->all(), [
                'title' => Rule::unique('movies')->ignore($movie->id),
                // 'name_english' => Rule::unique('movies')->ignore($movie->id),
                'slug' => Rule::unique('movies')->ignore($movie->id),
            ]);
            if ($validator->fails()) {
                toastr()->warning('Movie is "' . $data['title'] . '" existing!', 'Warning');
                return redirect()->back();
            }
            //$data = $request->all();

            $movie->title = $data['title'];
            $movie->name_english = $data['name_english'];
            $movie->slug = $data['slug'];
            $movie->year = $data['year'];
            $movie->time = $data['time'];
            $movie->thuocphim = $data['thuocphim'];
            $movie->quality = $data['quality'];
            $movie->language = $data['language'];
            $movie->imdb = $data['imdb'];
            $movie->paid_movie = $data['paid_movie'];
            $movie->hot = $data['hot'];
            $movie->status = $data['status'];
            $movie->sotap = $data['sotap'];
            $movie->category_id = $data['category_id'];
            $movie->country_id = $data['country_id'];

            $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');
            $episodes_count = Movie::withCount(['episode' => function ($query) {
                $query->select(DB::raw('count(distinct(episode))'));
            }])->find($id);

            if ($data['sotap'] < $episodes_count->episode_count) {
                toastr()->warning('Tổng tập phim không được nhỏ hơn số tập phim đã có! Vui lòng xem lại!', 'Warning');
                return redirect()->back();
            }
            if (!isset($data['genre'])) {
                toastr()->warning('Genre not empty!', 'Warning!');
                return redirect()->back();
            } else {
                foreach ($data['genre'] as $key => $gen) {
                    $movie->genre_id = $gen['0'];
                }
            }

            $movie->save();
            $movie_image = Movie_Image::where('movie_id', $movie->id)->first();
            $get_image = $request->file('image');
            $path = 'uploads/movie/';
            // if ($get_image) {
            //     if (file_exists($path . $movie->image)) {
            //         unlink('uploads/movie/' . $movie->image);
            //     }
            //     $get_name_image = $get_image->getClientOriginalName();
            //     $name_image = current(explode('.', $get_name_image));
            //     $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
            //     $get_image->move($path, $new_image);
            //     $movie->image = $new_image;
            // }
            if ($get_image) {
                if (file_exists($path . $movie_image->image)) {
                    unlink('uploads/movie/' . $movie_image->image);
                }
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.', $get_name_image));
                $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move($path, $new_image);
                $movie_image->image = $new_image;
                $movie_image->save();
            }

            //return json_encode($movie);

            // $movie->save();

            // $imdb = Movie_Rating::where('movie_id', $movie->id)->first();

            // if (!$imdb) {
            //     $imdb = new Movie_Rating();
            //     $imdb->movie_id = $movie->id;
            // }
            // $imdb->imdb = $request->imdb;
            // $imdb->save();

            $description = Movie_Description::where('movie_id', $movie->id)->first();

            if (!$description) {
                $description = new Movie_Description();
                $description->movie_id = $movie->id;
            }
            $description->description = $request->description;
            $description->save();

            $trailer = Movie_Trailer::where('movie_id', $movie->id)->first();

            if (!$trailer) {
                $trailer = new Movie_Trailer();
                $trailer->movie_id = $movie->id;
            }
            $trailer->trailer = $request->trailer;
            $trailer->save();

            // $hot = Movie_Hot::where('movie_id', $movie->id)->first();

            // if (!$hot) {
            //     $hot = new Movie_Hot();
            //     $hot->movie_id = $movie->id;
            // }
            // $hot->hot = $request->hot;
            // $hot->save();

            $tags = Movie_Tags::where('movie_id', $movie->id)->first();

            if (!$tags) {
                $tags = new Movie_Tags();
                $tags->movie_id = $movie->id;
            }
            $tags->tags = $request->tags;
            $tags->save();


            $movie->movie_genre()->sync($data['genre']);
            if (!isset($data['cast'])) {
                toastr()->warning('Cast empty! But updated changes', 'Warning!');
                Movie_Cast::whereIn('movie_id', [$movie->id])->delete();
                // return redirect()->back();
            } else {
                $movie->movie_cast()->sync($data['cast']);
            }

            if (!isset($data['directors'])) {
                toastr()->warning('Directors empty! But updated changes', 'Warning!');
                Movie_Directors::whereIn('movie_id', [$movie->id])->delete();
                // return redirect()->back();
            } else {
                $movie->movie_directors()->sync($data['directors']);
            }
            // return redirect()->back()->with('message_update', 'Update film successfully !');

            toastr()->success('Movie "' . $movie->title . '" updated successfully!', 'Update');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error('Movie update error!', 'Error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $movie = Movie::find($id);
            $movie_image = Movie_Image::where('movie_id', $movie->id)->first();
            //delete image
            if (!empty($movie_image->image)) {
                unlink('uploads/movie/' . $movie_image->image);
            }
            $movie_image->delete();
            //delete genre
            Movie_Genre::whereIn('movie_id', [$movie->id])->delete();
            Episode::whereIn('movie_id', [$movie->id])->delete();
            Movie_Cast::whereIn('movie_id', [$movie->id])->delete();
            Movie_Directors::whereIn('movie_id', [$movie->id])->delete();

            $movie->delete();
            $movie_data = Movie::all()->toArray();

            toastr()->success('Movie "' . $movie->title . '" deleted successfully!', 'Delete');
            return redirect()->route('movie.index')->with('movie_data', $movie_data);
            //return redirect()->back()->with('movie_data', $movie_data);
            // return redirect()->back()->with('movie_data', $movie_data)->with('message_del', 'Delete film successfully!');
        } catch (Exception $e) {
            toastr()->error('Movie "' . $movie->title . '" delete error!', 'Error');
            return redirect()->route('movie.index');
        }
    }

    public function update_season(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
        //toastr()->info('Movie "'.$movie->title.'" updated season success!','Update');

    }
    public function update_year(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }
    public function movie_hot(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        // $hot = Movie_Hot::where('movie_id', $movie->id)->first();

        // if (!$hot) {
        //     $hot = new Movie_Hot();
        //     $hot->movie_id = $movie->id;
        // }
        $movie->hot = $data['moviehot_val'];
        $movie->save();
    }

    public function movie_status(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->status = $data['moviestatus_val'];
        $movie->save();
    }
    public function update_imdb(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->imdb = $data['imdbcode'];
        $movie->save();
    }
}
