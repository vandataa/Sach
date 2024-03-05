<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FreeshipController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\BookController as ClientBookController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Client\SearchController;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/admin', function () {
    return view('admin');
})->name('admin');


//Client
Route::get('/', function () {
    $products = Book::orderBy('id', 'desc')->limit(4)->get();
    $product = Book::get();
    $cate = Category::all();
    $auth = Author::all();
    $publishers = Publisher::all();
    $topSellingBooks = Book::orderByDesc('sold_quantity')->limit(4)->get();
    return view('index', ['publishers' => $publishers,'products' => $products, 'product' => $product, 'cate' => $cate, 'auth' => $auth, 'topSellingBooks' => $topSellingBooks]);
})->name('home');
// Show book
Route::get('/show', [ClientBookController::class, 'show'])->name('books.show');
Route::get('/detail/{id}', [ClientBookController::class, 'detailBook'])->name('book.detail');
Route::get('view-category/{slug}', [ClientBookController::class, 'viewcategory']);
Route::get('view-auth/{slug}', [ClientBookController::class, 'viewauth']);
Route::get('view-publis/{id}', [ClientBookController::class, 'viewpublisher']);
Route::post('/show/fillterBy-Price', [ClientBookController::class, 'filter'])->name('fillterByPrice');
Route::get('comment', [\App\Http\Controllers\Client\ReviewController::class, 'index'])->name('show.comment');
// Tìm kiếm sách theo tên sách
Route::get('/search', [SearchController::class, 'searchKey'])->name('search.key');

//contact

Route::get('contact', function () {
    $cate = Category::all();
    $auth = Author::all();
    $publishers = Publisher::all();
    return view('client.contact.contact', ['publishers' => $publishers,'cate' => $cate, 'auth' => $auth]);
})->name('contact');

//blog
Route::get('blog', function () {
    $cate = Category::all();
    $auth = Author::all();
    return view('client.blog.blog', ['cate' => $cate, 'auth' => $auth]);
})->name('blog');


// Customer
Route::get('/signin', [UserController::class, 'signin'])->name('signin');
Route::post('/signin', [UserController::class, 'signinPost'])->name('signin.post');
Route::get('/signup', [UserController::class, 'signup'])->name('signup');
Route::post('/signup', [UserController::class, 'signupPost'])->name('signup.post');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
//cart
route::middleware('auth')->group(function () {


    Route::post('/add-code', [SaleController::class, 'applyCode'])->name('sale.code');
    Route::post('/discode', [SaleController::class,  'disCode'])->name('sale.disable');


    
    Route::post('/cart/update-ship', [CartController::class,  'selectShip'])->name('cart.ship');
    Route::post('/cart/count-ship', [CartController::class,  'ShipCount'])->name('cart.ship.count');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/deleteCart/{id}', [CartController::class, 'deleteCart'])->name('cart.delete');
    Route::patch('updateCart', [CartController::class, 'updateCart'])->name('cart.updateCart');
    Route::patch('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');

    Route::post('/detail/add-to-cart', [CartController::class, 'store'])->name('client.carts.add');
    Route::post('/add-to-cart', [CartController::class, 'storeBook'])->name('client.carts.add.nhanh');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/process-payment', [CartController::class, 'processCheckout'])->name('checkout.process');
    Route::post('/VNPayMent', [CartController::class, 'vnpay_payment'])->name('vnpay_payment');

    Route::post('/add-to-favourite', [ClientOrderController::class, 'addFavorite'])->name('client.favourite.add');

    //    Route::post('/remove-book/{id}',[CartController::class,'removeBookInCart'])->name('carts.remove_book');

    //order
    Route::get('/order', [ClientOrderController::class, 'index'])->name('client.order.index');
    Route::get('/order_detail/{id}', [ClientOrderController::class, 'DetailOrder'])->name('client.order.detail');
    Route::get('/bill_detail', [ClientOrderController::class, 'checkBill'])->name('bill.detail');
    Route::post('/orders/cancel/{id}', [ClientOrderController::class, 'cancel'])->name('client.orders.cancel');
    Route::post('/orders/updateSTT/{id}', [ClientOrderController::class, 'updateSTT'])->name('client.orders.updateSTT');
    Route::get('/billDetail', [ClientOrderController::class, 'billDetail'])->name('bill.detail');
    Route::post('/EvaluateUser', [ClientOrderController::class, 'storeEvaluate'])->name('add.evaluate');
    //revoew
    Route::match(['get', 'post'], '/post-comment', [\App\Http\Controllers\Client\ReviewController::class, 'postComment'])->name('post.comment');
    Route::match(['get', 'post'], '/delete-comment/{id}', [\App\Http\Controllers\Client\ReviewController::class, 'deleteComment'])->name('delete.comment');
    Route::match(['get', 'post'], '/edit-comment/{id}', [\App\Http\Controllers\Client\ReviewController::class, 'editComment'])->name('edit.comment');
    Route::get('/favourite', [ClientOrderController::class, 'showFavourite'])->name('client.favourite.index');
    Route::post('/favourite/delete', [ClientOrderController::class, 'deleteFavourite'])->name('client.favourite.delete');
});



/////////////////////////////////////////////////////////////////////////////////
//Lay lai password
Route::get('/forget-password', [UserController::class, 'forgetPassword'])->name('forget.password');
Route::post('/forget-password', [UserController::class, 'forgetPasswordPost'])->name('forget.password.post');
Route::get('/reset-password/{token}', [UserController::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password', [UserController::class, 'resetPasswordPost'])->name('reset.password.post');

/////////////////////////////////////////////////////////////////////////////
//Chinh sua thong tin tai khoan
Route::prefix('/')->middleware('auth')->group(function () {
    Route::get('/my-account/detail', [UserController::class, 'showDetail'])->name('my.account.detail');
    Route::get('/my-account/edit-detail', [UserController::class, 'editDetail'])->name('my.account.editDetail');
    Route::post('/my-account/edit-detail', [UserController::class, 'editDetailPost'])->name('my.account.editDetail.post');
    Route::get('/my-account/changePass', [UserController::class, 'showPass'])->name('my.account.pass');
    Route::post('/my-account/changePass', [UserController::class, 'changePass'])->name('my.account.pass.post');
});

////////////////////////////////////////////////////////////////////////////////////
// Admin
Route::get('/loginAdmin', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'loginPost'])->name('login.post');
Route::get('/logoutAdmin', [AdminController::class, 'logout'])->name('logoutAdmin');


///////////////////////////////////////////////////////////////////////////////////
//Sau khi đăng nhập role admin
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    //Thong ke
    Route::get('/admin/index/{month?}', [AdminController::class, 'index'])->name('admin.index');
    //Export
    Route::get('/users/export', [AdminUserController::class, 'export'])->name('export.user');
    Route::get('/categorys/export', [CategoryController::class, 'export'])->name('export.cate');
    //Import
    Route::get('/books/import', [BookController::class, 'import'])->name('import.book');

    // User
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.list');
    Route::get('/create-user', [AdminUserController::class, 'createUser'])->name('users.create');
    Route::post('/create-user', [AdminUserController::class, 'createUserPost'])->name('users.create.post');
    Route::get('/edit-user/{id}', [AdminUserController::class, 'editUser'])->name('users.edit');
    Route::post('/edit-user/{id}', [AdminUserController::class, 'editUserPost'])->name('users.edit.post');
    Route::get('/delete-user/{id}', [AdminUserController::class, 'deleteUser'])->name('users.delete');
    Route::post('/users/filter', [AdminUserController::class, 'filter'])->name('users.filter');
    Route::get('/users/history', [\App\Http\Controllers\Admin\UserController::class, 'history'])->name('history.user');
    Route::get('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'restore'])->name('user.restore');
    //sale
    Route::get('/list', [SaleController::class, 'list'])->name('sale.list');
    Route::get('/add', [SaleController::class, 'add'])->name('sale.add');
    Route::post('/add-sale', [SaleController::class, 'store'])->name('sale.store');
    Route::get('/edit/{id}', [SaleController::class, 'edit'])->name('sale.edit');
    Route::put('/update/{id}', [SaleController::class, 'update'])->name('sale.update');
    Route::delete('/delete/{id}', [SaleController::class, 'destroy'])->name('sale.destroy');
    Route::get('/sale/history', [\App\Http\Controllers\Admin\SaleController::class, 'history'])->name('history.sale');
    Route::get('/sale/{id}', [\App\Http\Controllers\Admin\SaleController::class, 'restore'])->name('sale.restore');

    //order
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order_detail/{id}', [OrderController::class, 'orderDetail'])->name('order.detail');
    Route::post('update-status/{id}', [OrderController::class, 'updateStatus2'])->name('admin.orders.update_status');
    Route::put('update-status/{id}', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::post('/order/filter', [OrderController::class, 'filter'])->name('order.filter');
    Route::get('/order/history', [OrderController::class, 'history'])->name('order.category');
    // Category
    Route::resource('category', CategoryController::class);
    Route::get('/categories/history', [CategoryController::class, 'history'])->name('history.category');
    Route::get('/categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'restore'])->name('category.restore');

    // publishers
    Route::get('/publishers', [PublisherController::class, 'index'])->name('publisher.list');
    Route::get('/create-publishers', [\App\Http\Controllers\Admin\PublisherController::class, 'create'])->name('publisher.create');
    Route::post('/create-publishers', [\App\Http\Controllers\Admin\PublisherController::class, 'add'])->name('publisher.create');
    Route::match(['get', 'post'], '/delete-publishers/{id}', [\App\Http\Controllers\Admin\PublisherController::class, 'destroy'])->name('publisher.delete');
    Route::get('/edit-publishers/{id}', [\App\Http\Controllers\Admin\PublisherController::class, 'update'])->name('publisher.edit');
    Route::post('/edit-publishers/{id}', [\App\Http\Controllers\Admin\PublisherController::class, 'edit'])->name('publisher.edit.post');
    Route::get('publishers/detail/{id}', [\App\Http\Controllers\Admin\PublisherController::class, 'detail'])->name('publisher.detail');
    Route::get('/publishers/history', [\App\Http\Controllers\Admin\PublisherController::class, 'history'])->name('history.publisher');
    Route::get('/publishers/restore/{id}', [\App\Http\Controllers\Admin\PublisherController::class, 'restore'])->name('publisher.restore');
    // Book
    Route::resource('book', BookController::class);
    Route::get('/changeList/{id}', [BookController::class, 'changeList'])->name('book.changeList');
    Route::get('/change/{id}', [BookController::class, 'changeform'])->name('book.change');
    Route::get('/newImage/{id}', [BookController::class, 'addNewImage'])->name('book.newImage');
    Route::post('/addImage', [BookController::class, 'addImage'])->name('book.addImage');
    Route::post('/change_image/{id}', [BookController::class, 'changeImage'])->name('book.change_image');
    Route::get('/review/{id}', [BookController::class, 'review'])->name('book.review');
    Route::delete('/deleteImage/{id}', [BookController::class, 'deleteImage'])->name('book.deleteImage');
    Route::post('/book/filter', [BookController::class, 'filter'])->name('books.filter');
    Route::get('/books/history', [BookController::class, 'history'])->name('history.books');
    Route::get('/restore/{id}', [\App\Http\Controllers\Admin\BookController::class, 'restore'])->name('books.restore');

    //authors
    Route::get('/authors', [\App\Http\Controllers\Admin\AuthorsController::class, 'index'])->name('list.authors');
    Route::get('/create-authors', [\App\Http\Controllers\Admin\AuthorsController::class, 'create'])->name('authors.create');
    Route::post('/create-authors', [\App\Http\Controllers\Admin\AuthorsController::class, 'add'])->name('authors.create');
    Route::match(['get', 'post'], '/delete-authors/{id}', [\App\Http\Controllers\Admin\AuthorsController::class, 'delete'])->name('authors.delete');
    Route::get('/edit-authors/{id}', [\App\Http\Controllers\Admin\AuthorsController::class, 'update'])->name('authors.edit');
    Route::post('/edit-authors/{id}', [\App\Http\Controllers\Admin\AuthorsController::class, 'edit'])->name('authors.edit.post');
    Route::get('author/detail/{id}', [\App\Http\Controllers\Admin\AuthorsController::class, 'detail'])->name('author.detail');
    Route::get('/author/history', [\App\Http\Controllers\Admin\AuthorsController::class, 'history'])->name('history.author');
    Route::get('/author/restore/{id}', [\App\Http\Controllers\Admin\AuthorsController::class, 'restore'])->name('authors.restore');

    //Review
    Route::get('/comment', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('review.index');
    Route::match(['get', 'post'], '/delete-comment/{id}', [\App\Http\Controllers\Admin\ReviewController::class, 'delete'])->name('review.delete');
    Route::get('/comment/history', [\App\Http\Controllers\Admin\ReviewController::class, 'history'])->name('history.comment');
    Route::get('/comment/{id}', [\App\Http\Controllers\Admin\ReviewController::class, 'restore'])->name('comment.restore');

    //History
    Route::get('/history', [\App\Http\Controllers\Admin\HistoryController::class, 'index'])->name('history.index');
    Route::post('/history', [\App\Http\Controllers\Admin\HistoryController::class, 'filter'])->name('history.filter');
    Route::get('/history-detail/{id}', [\App\Http\Controllers\Admin\HistoryController::class, 'detail'])->name('history.detail');

    //freeship
    
    Route::get('/freeship', [FreeshipController::class, 'index'])->name('freeship.index');
    Route::post('/freeship-create', [FreeshipController::class, 'create'])->name('freeship.create');
    Route::post('/freeship-list', [FreeshipController::class, 'list'])->name('freeship.list');
    Route::post('/freeship-add', [FreeshipController::class, 'add'])->name('freeship.add');
    Route::post('/freeship-edit', [FreeshipController::class, 'edit'])->name('freeship.edit');

    //dashboard
    Route::get('/dashboard-topds/{month?}', [AdminController::class, 'topds'])->name('dashboard.topds');
    Route::get('/dashboard-top5sp/{month?}', [AdminController::class, 'top5sp'])->name('dashboard.top5sp');
    Route::get('/dashboard-topnsx/{month?}', [AdminController::class, 'topnsx'])->name('dashboard.topnsx');
    Route::get('/dashboard-topuser/{month?}', [AdminController::class, 'topuser'])->name('dashboard.topuser');
});