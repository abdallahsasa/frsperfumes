<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Catalog;
use App\Livewire\ProductShow;
use App\Livewire\CartCheckout;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', Home::class)->name('home');
Route::get('/shop', Catalog::class)->name('shop');
Route::get('/brands', \App\Livewire\BrandsIndex::class)->name('brands');
Route::get('/perfume/{slug}', ProductShow::class)->name('perfume.show');
Route::get('/cart', CartCheckout::class)->name('cart');

// Language switcher
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');
