<?php

use App\Models\Product;
use App\Http\Livewire\CartRender;
use App\Http\Livewire\FreeRender;
use App\Http\Livewire\ShopRender;
use App\Http\Livewire\ShowRender;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\MembershipShow;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\MembershipRender;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Admin\IndexComments;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SalesControler;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\MembershipController;

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

Route::get('/prueba', function () {

  $product = Product::find(61);

  return $product->grado;
});




Route::get('/', [HomeController::class, 'index'])->name('home');


Auth::routes();




//auth
Route::group(['middleware' => ['auth']], function () {
  Route::get('profile', [HomeController::class, 'profile'])->name('profile.edit');
  Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');
});



//admin
Route::group(['middleware' => ['role:admin']], function () {
  Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

  Route::resource('dashboard/products', ProductsController::class)->except('delete');
  Route::resource('dashboard/memberships', MembershipController::class)->except(['delete', 'show']);
  Route::resource('dashboard/category', CategoryController::class)->except('show');
  Route::resource('dashboard/package', PackageController::class)->except(['show', 'delete']);
  Route::resource('dashboard/degrees', GradeController::class)->except('show');
  Route::resource('dashboard/users', UsersController::class)->only(['index', 'update', 'edit']);
  Route::get('dashboard/comments', IndexComments::class)->name('comments.index');
  Route::resource('dashboard/sales', SalesControler::class)->except(['delete']);
});



//guest

Route::get('shop', ShopRender::class)->name('shop.index');
Route::get('shop/{id}', ShowRender::class)->name('shop.show');
Route::get('membresia-vip', MembershipRender::class)->name('membership');
Route::get('membresia-vip/{id}', MembershipShow::class, '__invoke')->name('membership.show');
Route::get('gratuito', FreeRender::class)->name('free');
Route::get('cart', CartRender::class)->name('cart.index');
