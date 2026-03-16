<?php

use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Auth\AdminLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Storefront Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [StorefrontController::class, 'home'])->name('home');

// Educational page
Route::get('/que-es-la-luz-azul', [StorefrontController::class, 'blueLight'])->name('blue-light');

// Product catalog
Route::get('/lentes', [ProductController::class, 'index'])->name('products.index');
Route::get('/lentes/{slug}', [ProductController::class, 'show'])->name('products.show');

// Cart
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
Route::patch('/carrito/actualizar/{itemId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrito/eliminar/{itemId}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/confirmacion/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
Route::post('/checkout/create-payment-intent', [CheckoutController::class, 'createPaymentIntent'])->name('checkout.createPaymentIntent');
Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.removeCoupon');

// Order tracking
Route::get('/pedido/{tracking_token}', [CheckoutController::class, 'track'])->name('order.track');

// Stripe webhook
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Lead capture
Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');

// Landing pages & Quiz
Route::get('/landing', [LandingController::class, 'index'])->name('landing.index');
Route::get('/quiz', [LandingController::class, 'quiz'])->name('landing.quiz');
Route::post('/quiz/resultado', [LandingController::class, 'quizResult'])->name('landing.quiz.result');

// SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Admin Authentication (outside admin middleware group)
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])
    ->name('admin.login')
    ->middleware('guest');

Route::post('/admin/login', [AdminLoginController::class, 'login'])
    ->name('admin.login.submit')
    ->middleware('guest');

Route::post('/admin/logout', [AdminLoginController::class, 'logout'])
    ->name('admin.logout')
    ->middleware('auth');
