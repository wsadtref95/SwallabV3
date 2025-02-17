<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsMember;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FoodNotesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RcommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MemberCreditCardController;


Route::get('/', function () {
    return view('welcome');
});

// =============================登入路徑=================================
Route::view('/register', 'auth.register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::view('/login', 'auth.login');
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
});
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
Route::post('/profile/update-social-link', [ProfileController::class, 'updateSocialLink'])->name('profile.updateSocialLink');
Route::post('/profile/update-credit-card', [ProfileController::class, 'updateCreditCard'])->name('profile.updateCreditCard');
Route::post('/profile/delete-credit-card', [ProfileController::class, 'deleteCreditCard'])->name('profile.deleteCreditCard');

Route::middleware(['auth'])->group(function () {
    Route::middleware([IsAdmin::class])->group(function () {
        Route::get('/admin', function () {
            return view('/backstage/new_oder');
        });
    });

    Route::middleware([IsMember::class])->group(function () {
        Route::get('/headpage/headpage', function () {
            return view('headpage.headpage');
        })->name('headpage');

        Route::get('/profile', function () {
            $user = Auth::user();
            return view('login.profile', compact('user'));
        })->name('profile.show');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    });
});



// ========================後台模擬=============================
Route::resource('/food_items', FoodItemController::class);

// ========================個人頁面login==================
Route::view('/login/profile', 'login.profile');

Route::view('/login/profile/Fedit', 'login/Fedit');

Route::view('/login/profile/order', 'login/order');
// =========================首頁(非會員)=============================
Route::view('/headpage/Fheadpage', 'headpage/Fheadpage');




// =============================餐廳(非會員)==================================
Route::view('/restaurant/detail', 'restaurant/detail');


// ===============================FoodNotes==========================================

Route::view('/foodNotes/foodNotes', 'foodNotes/foodNotes');



// =================================myHistory========================================

Route::view('/myHistory/myOrder', 'myHistory/myOrder');


// ===============================後台===============================

Route::view('/backstage/management_menu1', 'backstage/management_menu1');
Route::view('/backstage/management_menu2', 'backstage/management_menu2');
Route::post('/backstage/management_menu1/store', [MenuController::class, 'store'])->name('menu.store');
Route::view('/backstage/new_oder', 'backstage/new_oder');
Route::view('/backstage/ready_to_serve', 'backstage/ready_to_serve');
Route::view('/backstage/set_info', 'backstage/set_info');
Route::view('/backstage/set_time', 'backstage/set_time');

// ==============================後台test===========================================
Route::view('/backstagetest/test', 'backstagetest/test');
Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
Route::get('/restaurant/detail', [MenuController::class, 'index'])->name('restaurant.detail');


// ===============================================================
Route::post('/add-to-cart', [CartController::class, 'addToCart']);


Route::view('/foodNotes/foodNotes', 'foodNotes/foodNotes');

// ========================食記留言============================

Route::get('/foodnotes/{id}', [CommentController::class, 'show'])->name('foodnotes.show');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

// ========================餐廳留言============================
Route::get('/detail/{id}', [RcommentController::class, 'show'])->name('detail.show');
Route::post('/rcomments', [RcommentController::class, 'store'])->name('rcomment.store');


// ============================================================================



// ==========================取餐時間=================================================

Route::post('/get-pickup-time', [OrderController::class, 'getPickupTime']);
Route::post('/order', [OrderController::class, 'store'])->name('order.store');



// ============================================================
Route::post('/credit-card/store', [MemberCreditCardController::class, 'store'])->name('creditCard.store');



// ===========================================================
Route::view('/aa','aa');