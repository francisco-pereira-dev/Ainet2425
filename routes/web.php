<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShippingCostController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\StatisticsController;



Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
Route::post('email/verification-notification', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/', function () {
    return view('home');
})->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Auth::routes(['verify' => true]);
//Auth::routes();

Route::post('logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


Route::middleware('auth')->group(function () {
    // Listar categorias (apenas para board)
    Route::get('/categories', function () {
        if (auth()->user()->type !== 'board') {
            abort(403);
        }
        return app(CategoryController::class)->index();
    })->name('categories.index');

    // Mostrar formulário de criação (board)
    Route::get('/categories/create', function () {
        if (auth()->user()->type !== 'board') {
            abort(403);
        }
        return app(CategoryController::class)->create();
    })->name('categories.create');

    // Guardar nova categoria
    Route::post('/categories', function () {
        if (auth()->user()->type !== 'board') {
            abort(403);
        }
        return app(CategoryController::class)->store(request());
    })->name('categories.store');

    // Editar categoria
    Route::get('/categories/{category}/edit', function ($id) {
        if (auth()->user()->type !== 'board') {
            abort(403);
        }
        $controller = app(CategoryController::class);
        return $controller->edit(\App\Models\Category::findOrFail($id));
    })->name('categories.edit');

    // Atualizar categoria
    Route::put('/categories/{category}', function ($id) {
        if (auth()->user()->type !== 'board') {
            abort(403);
        }
        $controller = app(CategoryController::class);
        return $controller->update(request(), \App\Models\Category::findOrFail($id));
    })->name('categories.update');

    // Remover categoria (soft delete)
    Route::delete('/categories/{category}', function ($id) {
        if (auth()->user()->type !== 'board') {
            abort(403);
        }
        $controller = app(CategoryController::class);
        return $controller->destroy(\App\Models\Category::findOrFail($id));
    })->name('categories.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/orders/pending', [OrderController::class, 'pending'])
        ->name('orders.pending')
        ->middleware('can:handle-orders'); // opcional, se quiseres validar tipo de user
});

Route::middleware(['auth'])->group(function () {
    Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('/orders/completed', [OrderController::class, 'completed'])->name('orders.completed');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::post('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

Route::get('/product-images/{filename}', function ($filename) {
    $path = database_path('seeders/products_photos/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return Response::file($path);
})->name('product.image');

Route::get('/settings/membership', [SettingsController::class, 'editMembership'])->name('settings.membership.edit');
Route::put('/settings/membership', [SettingsController::class, 'updateMembership'])->name('settings.membership.update');
Route::resource('settings/shipping-costs', ShippingCostController::class)->except(['show']);

// Catálogo
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

//Adicionar ao carrinho — placeholder
Route::post('/catalog/add-to-cart/{product}', function ($productId) {
    return back()->with('success', 'Produto adicionado ao carrinho!');
})->name('catalog.addToCart');

// Carrinho
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
//Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm');

//Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/card', [CardController::class, 'show'])->name('card.show');
    Route::get('/card/history', [CardController::class, 'history'])->name('card.history');
    Route::get('/card/topup', [CardController::class, 'showTopUpForm'])->name('card.topup.form');
    Route::post('/card/topup', [CardController::class, 'topUp'])->name('card.topup');
});

Route::middleware(['auth', 'verified', 'can:isBoard'])->group(function () {
    Route::get('/statistics', [StatisticsController::class, 'dashboard'])->name('statistics.dashboard');
    Route::get('/statistics/export', [StatisticsController::class, 'export'])->name('statistics.export');
});

Route::get('receipts/{file}', function($file){
    return response()->file(storage_path('app/private/receipts/'.$file));
})->name('receipts.view');