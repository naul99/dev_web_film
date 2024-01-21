<?php

use App\Http\Controllers\AssignController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
// admin controller
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthSocialLoginController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\InfoWebController;
use App\Http\Controllers\Login;
use App\Http\Controllers\MaintanceController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\CastController;
use App\Http\Controllers\DirectorsController;
use App\Http\Controllers\EmbedController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ManageCommentController;
use App\Http\Controllers\PayPalPaymentController;
use App\Http\Controllers\SentEmailController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Assign;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('web')->get('/auth/login', [AuthSocialLoginController::class, 'index'])->name('user-login');


Route::get('/auth/github/redirect', [AuthSocialLoginController::class, 'githubredirect'])->name('social-github-login');
Route::get('/auth/github/callback', [AuthSocialLoginController::class, 'githubcallback']);
Route::get('/auth/google/redirect', [AuthSocialLoginController::class, 'googleredirect'])->name('social-google-login');
Route::get('/auth/google/callback', [AuthSocialLoginController::class, 'googlecallback']);
Route::get('/auth/facebook/redirect',[AuthSocialLoginController::class,'facebookredirect'])->name('social-facebook-login');
Route::get('/auth/facebook/callback',[AuthSocialLoginController::class,'facebookcallback']);

//paypal
Route::get('/process-transaction', [PayPalPaymentController::class,'processTransaction'])->name('processTransaction');
Route::get('/success-transaction', [PayPalPaymentController::class,'successTransaction'])->name('successTransaction');
Route::get('/cancel-transaction', [PayPalPaymentController::class,'cancelTransaction'])->name('cancelTransaction');

//vnpay
Route::post('/payment-vnpay', [PayPalPaymentController::class,'paymentVnpay'])->name('paymentVnpay');
//momo
Route::post('/payment-momo', [PayPalPaymentController::class,'paymentMomo'])->name('paymentMomo');

Route::get('/sociallogout', [AuthSocialLoginController::class, 'sociallogout'])->name('sociallogout');
//test sent email
Route::get('/sent-email', [SentEmailController::class, 'sentemail'])->name('sentemail');



//******************* */
Route::get('/', [IndexController::class, 'home'])->name('homepage');
Route::get('/category/{slug}', [IndexController::class, 'category'])->name('category');
Route::get('/genre/{slug}', [IndexController::class, 'genre'])->name('genre');
Route::get('/directors/{slug}', [IndexController::class, 'directors'])->name('directors');
Route::get('/cast/{slug}', [IndexController::class, 'cast'])->name('cast');
Route::get('/directors/{slug}', [IndexController::class, 'directors'])->name('directors');
Route::get('/country/{slug}', [IndexController::class, 'country'])->name('country');
Route::get('/movie/{slug}', [IndexController::class, 'movie'])->name('movie');
Route::get('/xem-phim/{slug}/{tap}/{server_active}', [IndexController::class, 'watch']);
Route::get('/episode', [IndexController::class, 'episode'])->name('episode');
Route::get('/tim-kiem', [IndexController::class, 'timkiem'])->name('tim-kiem');
Route::get('/nam/{year}', [IndexController::class, 'year']);
Route::get('/tag/{tag}', [IndexController::class, 'tag']);
Route::post('/add_comment/{id}', [CommentsController::class, 'add_comment'])->name('add_comment');
Route::post('/add_reply/{id}', [CommentsController::class, 'add_reply'])->name('add_reply');
Route::get('/loc-phim', [IndexController::class, 'locphim'])->name('locphim');
Route::get('history-movie', [IndexController::class, 'history_movie'])->name('history-movie');
Route::get('/history', [IndexController::class, 'history'])->name('history');
Route::post('/add-rating', [IndexController::class, 'add_rating'])->name('add-rating');
Route::get('/all-movies', [IndexController::class, 'all_movies'])->name('all-movies');
Route::get('/register-package', [IndexController::class, 'register_package'])->name('register-package');
Route::post('/checkout-package', [IndexController::class, 'checkout'])->name('checkout');
Route::get('/checkout-package', function() {
    return redirect()->route('register-package');
});
Route::get('/my-history-order', [IndexController::class, 'history_order'])->name('history-order');
Route::get('/policy', [IndexController::class, 'policy'])->name('policy');

//Auth::routes();

// route admin

Route::get('logout', [LoginController::class, 'logout']);

Auth::routes(['login' => false]);
Route::get('dashboard-signin', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
Route::post('dashboard-signin', 'App\Http\Controllers\Auth\LoginController@login')->name('login');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/user-online', [HomeController::class, 'online'])->name('useronline');
    Route::resource('category', CategoryController::class);
    Route::resource('info-web', InfoWebController::class);
    //Route::resource('category', CategoryController::class);
    Route::post('resorting', [CategoryController::class, 'resorting'])->name('resorting');
    Route::resource('genre', GenreController::class);
    Route::resource('country', CountryController::class);
    Route::resource('movie', MovieController::class);
    Route::resource('episode', EpisodeController::class);
    Route::resource('user', UserController::class);
    Route::get('shutdown', [MaintanceController::class, 'index'])->name('index');
    Route::get('shutdown-down', [MaintanceController::class, 'down'])->name('down');
    Route::get('shutdown-up', [MaintanceController::class, 'up'])->name('up');
    Route::resource('resume', ResumeController::class);
    Route::post('/uploadpage', [ResumeController::class, 'store']);
    Route::get('/show-resume', [ResumeController::class, 'show']);
    Route::get('/download/{file}', [ResumeController::class, 'download']);
    Route::get('/view-resume/{id}', [ResumeController::class, 'view']);
    Route::resource('server-movie', ServerController::class);
    Route::resource('directors', DirectorsController::class);
    Route::resource('cast', CastController::class);
    Route::resource('role', RoleController::class);
    Route::post('permissions', [RoleController::class, 'storePermissions'])->name('permissions');
    Route::get('/assign-permission', [AssignController::class, 'assignPermissions'])->name('assignpermission');
    Route::post('assignPermissionsToRole', [AssignController::class, 'assignPermissionsToRole'])->name('assignPermissionsToRole');
    Route::get('/user/assign-permission-user/{id}', [UserController::class, 'assign'])->name('assignpermissionuser');
    Route::post('assignPermissionsToUser/{id}', [UserController::class, 'updatePermission'])->name('assignPermissionsToUser');
    Route::get('/log', [TrackingController::class, 'index'])->name('log');
    Route::get('/log-error', [TrackingController::class, 'tracking_error'])->name('log-error');
    Route::resource('package', PackageController::class);
    Route::get('comments/comment', [ManageCommentController::class, 'index'])->name('manage-comment');
    Route::get('comments/reply', [ManageCommentController::class, 'reply'])->name('manage-reply');
    Route::get('customers', [UserController::class, 'listCustomer'])->name('listcustomer');
    Route::get('customers/order', [UserController::class, 'listOrder'])->name('listorder');
    Route::delete('destroy-customers/{id}', [UserController::class, 'destroy_customer'])->name('destroycustomer');
    Route::get('customers-status', [UserController::class, 'customer_status'])->name('customersstatus');
    Route::delete('delete-resume/{id}', [ResumeController::class, 'delete'])->name('delete_resume');

});
//route api
Route::get('get_api_ophim', [MovieController::class, 'get_api_ophim'])->name('get_api_ophim');
Route::post('auto_create', [MovieController::class, 'auto_create'])->name('auto_create');
//route ajax

Route::get('select-role', [AssignController::class, 'select_role'])->name('select-role');
Route::get('select-movie', [EpisodeController::class, 'select_movie'])->name('select-movie');
Route::post('/update-season-phim', [MovieController::class, 'update_season']);
Route::get('/update-year-phim', [MovieController::class, 'update_year']);
Route::get('movie-hot',[MovieController::class,'movie_hot'])->name('movie-hot-change');
Route::get('movie-status',[MovieController::class,'movie_status'])->name('movie-status-change');
Route::get('comment-status',[ManageCommentController::class,'comment_status'])->name('comment-status-change');
Route::get('reply-status',[ManageCommentController::class,'reply_status'])->name('reply-status-change');
Route::post('/delete-comment',[CommentsController::class,'destroy'])->name('delete-comment');
Route::post('/edit-comment',[CommentsController::class,'edit'])->name('edit-comment');
Route::post('/update-imdb',[MovieController::class,'update_imdb'])->name('update-imdb');
Route::get('/api/embed_vip',[EmbedController::class,'embed_vip']);
Route::get('/api/embed_ads',[EmbedController::class,'embed_ads']);
Route::get('/site-map',function(){
    return Artisan::call('sitemap:create');
});
// Clear application cache:

Route::get('/clear-cache', function() {
     Artisan::call('cache:clear');
     toastr()->success("Clear cache success.", 'Success');
     return redirect()->back();
});
