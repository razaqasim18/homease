<?php
// Admin
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserController;
// buyer
use App\Http\Controllers\Buyer\Auth\ForgotPasswordController as BuyerForgotPasswordController;
use App\Http\Controllers\Buyer\Auth\LoginController as BuyerLoginController;
use App\Http\Controllers\Buyer\Auth\RegisterController as BuyerRegisterController;
use App\Http\Controllers\Buyer\Auth\ResetPasswordController as BuyerResetPasswordController;
use App\Http\Controllers\Buyer\HomeController as BuyerHomeController;
use App\Http\Controllers\Buyer\JobController as BuyerJobController;
use App\Http\Controllers\Buyer\ProfileController as BuyerProfileController;
// seller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Seller\Auth\ForgotPasswordController as SellerForgotPasswordController;
use App\Http\Controllers\Seller\Auth\LoginController as SellerLoginController;
use App\Http\Controllers\Seller\Auth\RegisterController as SellerRegisterController;
use App\Http\Controllers\Seller\Auth\ResetPasswordController as SellerResetPasswordController;
use App\Http\Controllers\Seller\HomeController as SellerHomeController;
use App\Http\Controllers\Seller\JobController as SellerJobController;
use App\Http\Controllers\Seller\ProfileController as SellerProfileController;
use App\Http\Controllers\Seller\ServiceController as SellerServiceController;
use App\Http\Controllers\Seller\SubscriptionController as SellerSubscriptionController;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/blogs', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog/{title}/{id}', [HomeController::class, 'singleBlog'])->name('singleblog');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/search/services', [HomeController::class, 'searchService'])->name('service');
Route::get('/service/{title}/{id}', [HomeController::class, 'service'])->name('more.service');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('submit');
    });
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [AdminProfileController::class, 'store'])->name('update');
        Route::post('/profile/password/update', [AdminProfileController::class, 'passwordChange'])->name('password');

        Route::prefix('users')->name('user.')->group(function () {
            Route::get('/buyer', [UserController::class, 'buyerList'])->name('buyer.list');
            Route::get('/seller', [UserController::class, 'sellerList'])->name('seller.list');

            Route::post('/buyer/block/{id}', [UserController::class, 'buyerBlock'])->name('buyer.block');
            Route::post('/seller/block/{id}', [UserController::class, 'sellerBlock'])->name('seller.block');

            Route::post('/buyer/deleted/{id}', [UserController::class, 'buyerDelete'])->name('buyer.delete');
            Route::post('/seller/deleted/{id}', [UserController::class, 'sellerDelete'])->name('seller.delete');
        });

        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('list');
            Route::post('insert', [CategoryController::class, 'store'])->name('submit');
            Route::put('update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
        });
        Route::prefix('faqs')->name('faq.')->group(function () {
            Route::get('/', [FaqController::class, 'index'])->name('list');
            Route::get('create', [FaqController::class, 'create'])->name('new');
            Route::post('insert', [FaqController::class, 'store'])->name('submit');
            Route::get('edit/{id}', [FaqController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [FaqController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [FaqController::class, 'destroy'])->name('delete');
        });
        Route::prefix('blogs')->name('blog.')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('list');
            Route::get('create', [BlogController::class, 'create'])->name('new');
            Route::post('insert', [BlogController::class, 'store'])->name('submit');
            Route::get('edit/{id}', [BlogController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [BlogController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [BlogController::class, 'destroy'])->name('delete');
        });
    });
});

Route::prefix('buyer')->name('buyer.')->group(function () {

    Route::middleware(['guest:buyer'])->group(function () {
        Route::get('/login', [BuyerLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [BuyerLoginController::class, 'login'])->name('submit');
        Route::post('/login/ajax', [BuyerLoginController::class, 'loginAjax'])->name('submit.ajax');

        Route::get('/register', [BuyerRegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [BuyerRegisterController::class, 'register'])->name('register.submit');
        Route::get('/verify/{token}', [BuyerRegisterController::class, 'verify'])->name('verify');

        Route::name('password.')->group(function () {
            Route::get('/forget-password', [BuyerForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
            Route::post('/forget-password', [BuyerForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
            Route::get('/reset-password/{token}', [BuyerResetPasswordController::class, 'getPassword'])->name('verify');
            Route::post('/reset-password', [BuyerResetPasswordController::class, 'updatePassword'])->name('update');

        });
    });

    Route::middleware(['auth:buyer', 'isverified', 'isblocked', 'isdeleted'])->group(function () {
        Route::get('/', [BuyerHomeController::class, 'index'])->name('dashboard');
        Route::post('/logout', [BuyerLoginController::class, 'logout'])->name('logout');
        Route::get('/profile', [BuyerProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [BuyerProfileController::class, 'store'])->name('update');
        Route::post('/profile/password/update', [BuyerProfileController::class, 'passwordChange'])->name('password');

        Route::post('/hire', [BuyerHomeController::class, 'hireMe'])->name('hireme');

        Route::prefix('job')->name('job.')->group(function () {
            Route::get('/', [BuyerJobController::class, 'index'])->name('list');
            Route::delete('/delete/{id}', [BuyerJobController::class, 'delete'])->name('delete');
            Route::get('/approve/{id}', [BuyerJobController::class, 'approve'])->name('approve');
            Route::get('/review/{id}', [BuyerJobController::class, 'review'])->name('review');
            Route::post('/review', [BuyerJobController::class, 'postReview'])->name('post.review');
            Route::get('/review/view/{id}', [BuyerJobController::class, 'reviewView'])->name('review.view');

        });
    });
});

Route::prefix('seller')->name('seller.')->group(function () {
    Route::middleware(['guest:seller'])->group(function () {
        Route::get('/login', [SellerLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [SellerLoginController::class, 'login'])->name('submit');
        Route::get('/register', [SellerRegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [SellerRegisterController::class, 'register'])->name('register.submit');
        Route::get('/verify/{token}', [SellerRegisterController::class, 'verify'])->name('verify');

        Route::name('password.')->group(function () {
            Route::get('/forget-password', [SellerForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
            Route::post('/forget-password', [SellerForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
            Route::get('/reset-password/{token}', [SellerResetPasswordController::class, 'getPassword'])->name('verify');
            Route::post('/reset-password', [SellerResetPasswordController::class, 'updatePassword'])->name('update');
        });
    });

    Route::middleware(['auth:seller', 'isverified', 'isblocked', 'isdeleted'])->prefix('subscription')->name('subscription.')->group(function () {
        Route::get('/', [SellerSubscriptionController::class, 'index'])->name('index');
        Route::get('/pay', [SellerSubscriptionController::class, 'payWithEasyPaisa'])->name('pay');
        Route::get('/pay/urlback', [SellerSubscriptionController::class, 'payWithEasyPaisa'])->name('urlback');
        Route::get('/update/{id}', [SellerSubscriptionController::class, 'updatePackage'])->name('update');
    });

    Route::post('/logout', [SellerLoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth:seller', 'isverified', 'isexpired', 'isblocked', 'isdeleted'])->group(function () {
        Route::get('/', [SellerHomeController::class, 'index'])->name('dashboard');
        Route::get('/profile', [SellerProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [SellerProfileController::class, 'store'])->name('update');
        Route::post('/profile/password/update', [SellerProfileController::class, 'passwordChange'])->name('password');

        Route::prefix('service')->name('service.')->group(function () {
            Route::get('/', [SellerServiceController::class, 'index'])->name('list');
            Route::get('create', [SellerServiceController::class, 'create'])->name('new');
            Route::post('insert', [SellerServiceController::class, 'store'])->name('submit');
            Route::get('edit/{id}', [SellerServiceController::class, 'edit'])->name('edit');
            Route::put('update/{id}', [SellerServiceController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [SellerServiceController::class, 'destroy'])->name('delete');

            Route::post('storeimage', [SellerServiceController::class, 'storeImage'])->name('storeimage');
            Route::delete('image/delete/{id}', [SellerServiceController::class, 'destroyImages'])->name('deleteimages');
            Route::post('storeUpdateImage', [SellerServiceController::class, 'storeUpdateImage'])->name('storeUpdateImage');
        });

        Route::prefix('job')->name('job.')->group(function () {
            Route::get('/', [SellerJobController::class, 'index'])->name('list');
            Route::get('/cancel/{id}', [SellerJobController::class, 'cancel'])->name('cancel');
            Route::get('/accept/{id}', [SellerJobController::class, 'accept'])->name('accept');
            Route::get('/start/{id}', [SellerJobController::class, 'start'])->name('start');
            Route::get('/finish/{id}', [SellerJobController::class, 'finish'])->name('finish');
            Route::get('/review/view/{id}', [SellerJobController::class, 'reviewView'])->name('review.view');

        });
    });
});

Route::get('/check', function () {
    $category = "1";
    $service_id = "2";
    $average_rating = 0;
    $total_review = 0;
    $total_user_rating = 0;
    $result = Review::where('service_id', $service_id)->get();
    foreach ($result as $row) {
        $total_review++;
        $total_user_rating = $total_user_rating + $row->rating;
    }

    $average_rating = ($total_review != 0) ? $total_user_rating / $total_review : $total_user_rating;

    $average_rating = number_format($average_rating, 1);
    $response = Service::whereId($service_id)->update([
        'rating' => $average_rating,
    ]);
    dd($response);
});