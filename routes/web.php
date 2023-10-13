<?php

use App\Models\Order;
use App\Models\Product;
use App\Http\Livewire\CartRender;
use App\Http\Livewire\FreeRender;
use App\Http\Livewire\ShopRender;
use App\Http\Livewire\ShowRender;
use App\Http\Livewire\PackageShow;
use App\Http\Livewire\PackageRender;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\MembershipShow;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IpController;
use App\Http\Livewire\AccountPackages;
use App\Http\Livewire\AccountProducts;
use App\Http\Livewire\Admin\SalesEdit;
use App\Http\Livewire\AccountShowOrder;
use App\Http\Livewire\MembershipRender;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Livewire\AccountShowPackages;
use App\Http\Livewire\Admin\IndexComments;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhooksController;
use App\Http\Livewire\AccountShowMembership;
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



Route::get('/link', function () {
  $target = '/home3/materi65/maca/storage/app/public';
  $link =   '/home3/materi65/public_html/storage';
  symlink($target, $link);
  echo "Link done";
});

Route::get('/foo', function () {
  Artisan::call('storage:link');
});



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/banned', [HomeController::class, 'banned'])->name('banned');


Auth::routes();




//auth
Route::group(['middleware' => ['auth']], function () {
  //profile
  Route::get('profile', [HomeController::class, 'profile'])->name('profile.edit');
  Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');

  Route::get('customer/orders', [MainController::class, 'customerOrders'])->name('customer.orders');
  Route::get('customer/memberships', [MainController::class, 'customerMemberships'])->name('customer.memberships');

  Route::group(['middleware' => ['auth.banned', 'ip.banned']], function () {
    //ventas

  
    Route::get('customer/orders/{id}', AccountShowOrder::class)->name('order.show');
    Route::get('customer/products', AccountProducts::class)->name('customer.products');
    Route::get('customer/packages', [MainController::class, 'customerPackages'])->name('customer.packages');
    Route::get('customer/packages/{order}/{id}', AccountShowPackages::class)->name('customer.packages-show');

    Route::get('customer/memberships/{order}/{id}', AccountShowMembership::class)->name('customer.membership-show');
  });
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
  Route::resource('dashboard/sales', SalesControler::class);
  Route::resource('dashboard/ips', IpController::class)->only(['index']);
});




//guest

Route::get('tienda/productos', ShopRender::class)->name('shop.index');
Route::get('tienda/productos/{id}', ShowRender::class)->name('shop.show');
Route::get('membresia-vip', MembershipRender::class)->name('membership');
Route::get('tienda/paquetes', PackageRender::class)->name('paquete');
Route::get('membresia-vip/{id}', MembershipShow::class, '__invoke')->name('membership.show');
Route::get('tienda/paquetes/{id}', PackageShow::class, '__invoke')->name('paquete.show');
Route::get('gratuito', FreeRender::class)->name('free');
Route::get('cart', CartRender::class)->name('cart.index');
Route::get('search/products', [MainController::class, 'search'])->name('search.products');




//informacion
Route::get('contact', [MainController::class, 'contact'])->name('information.contact');
Route::post('contact', [MainController::class, 'storeContact'])->name('contact');
Route::get('frequent-questions', [MainController::class, 'questions'])->name('information.questions');
Route::get('términos-y-condiciones', [MainController::class, 'terminos'])->name('information.terminos');
Route::get('aviso-de-privacidad', [MainController::class, 'aviso'])->name('information.aviso');







Route::get('thanks_you', [MainController::class, 'thanks_you'])->name('shop.thanks');
Route::POST('thanks_you1', [MainController::class, 'thanks_you1'])->name('shop.thanks1');
Route::POST('createOrder', [MainController::class, 'createOrder'])->name('shop.createOrder');





Route::post('webhooks', WebhooksController::class);
