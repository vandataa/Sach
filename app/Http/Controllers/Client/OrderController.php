<?php

namespace App\Http\Controllers\Client;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Evaluate;
use App\Models\Order;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Order_Detail;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\Favourite;


use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $cart;
    protected $book;
    protected $order;
    protected $user;
    protected $order_detail;
    protected $favourite;
    public function __construct(Book $book, Cart $cart, Order $order, User $user, Order_Detail $order_detail, Favourite $favourite)
    {
        $this->book = $book;
        $this->cart = $cart;
        $this->order = $order;
        $this->user = $user;
        $this->order_detail = $order_detail;
        $this->favourite = $favourite;
    }
    public function index()
    {
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();
        $orders =
            DB::table('orders')
            ->select('orders.name', 'orders.address', 'orders.email', 'orders.phone', 'orders.id', 'orders.ship', 'orders.total', 'orders.payment', 'orders.date', 'orders.note', 'orders.status', 'orders.code_bill')
            ->where('orders.id_customer', '=',  Auth::user()->id)
            ->get();
        return view('client.customer.my-Account.History', compact('publishers','orders', 'cate', 'auth'));
    }
    public function DetailOrder(string $id)
    {
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();
        $order = $this->order->FindOrFail($id);
        $order_details = DB::table('order_details')
            ->select(
                'orders.status as order_status',
                'order_details.id as order_detail_id',
                'order_details.book_quantity',
                'books.title_book',
                'books.book_image',
                'books.id as book_id',
                'books.price'
            )
            ->join('books', 'books.id', '=', 'order_details.book_id')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->where('order_details.order_id', '=', $id)
            ->get();

    // Lấy danh sách sản phẩm đã được đánh giá bởi người dùng hiện tại
    $ratedBooks = $this->getRatedBooks(auth()->id());

    return view('client.customer.my-Account.order_detail', compact('publishers','order', 'order_details', 'cate', 'auth', 'ratedBooks'));
    }
    private function getRatedBooks($userId)
{
    return DB::table('evaluate')
        ->where('user_id', $userId)
        ->pluck('book_id','orderDetail_id')
        ->toArray();
}
    public function cancel($id)
    {
        $order = $this->order->findOrFail($id);

        $order_details = $this->order_detail->where('order_id', $id)->get();
    
        $order->update(['status' => 'Hủy đơn hàng']);
    
        foreach ($order_details as $order_detail) {
            $book_id = $order_detail->book_id;
            $book_quantity = $order_detail->book_quantity;
    
            // Lấy số lượng hiện tại của sách
            $current_quantity = DB::table('books')
                ->where('id', $book_id)
                ->value('quantity');
    
            // Cập nhật số lượng mới của sách
            $new_quantity = $current_quantity + $book_quantity;
    
            // Thực hiện cập nhật
            DB::table('books')
                ->where('id', $book_id)
                ->update(['quantity' => $new_quantity]);
        }
    
        $user = Auth::user();
        Mail::send('emails/mail2', ['user' => $user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Cập nhật trạng thái đơn hàng!');
        });
    
        return redirect()->back()->with(['message' => 'Hủy đơn hàng thành công']);
    }
    public function updateSTT($id)
    {
    $order = $this->order->findOrFail($id);
    $order_details = $this->order_detail->where('order_id', $id)->get();

    $order->update(['status' => "Giao hàng thành công"]);

    foreach ($order_details as $order_detail) {
        $book_id = $order_detail->book_id;
        $book_quantity = $order_detail->book_quantity;

        // Lấy số lượng đã bán hiện tại của sách
        $current_sold_quantity = DB::table('books')
            ->where('id', $book_id)
            ->value('sold_quantity');

        // Cập nhật số lượng sách đã bán mới
        $new_sold_quantity = $current_sold_quantity + $book_quantity;

        // Thực hiện cập nhật
        DB::table('books')
            ->where('id', $book_id)
            ->update(['sold_quantity' => $new_sold_quantity]);
    }

    $user = Auth::user();
    Mail::send('emails/mail1', ['user' => $user], function ($message) use ($user) {
        $message->to($user->email);
        $message->subject('Cập nhật trạng thái đơn hàng!');
    });

        return redirect()->back()->with(['message' => 'Bạn đã xác nhận hàng thành công']);
    }
    public function checkBill()
    {
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();
        $responseCode = $_GET['vnp_ResponseCode'];
        $bill = Order::where('code_bill', $_GET['vnp_TxnRef'])->first();
        // dd($_GET['vnp_TxnRef']);
        $order_id = DB::table('orders')->orderBy('id', 'desc')->value('id');
        $order = Order_Detail::where('order_id', $order_id);
        $order_details
            = DB::table('order_details')
            ->select('order_details.book_quantity', 'books.title_book', 'books.price', 'order_details.id')
            ->join('books', 'books.id', '=', 'order_details.book_id')
            ->where('order_details.order_id', '=', $order_id)
            ->get();

        if ($bill) {
            if ($responseCode == '00') {
                $order = Order::where('code_bill', $_GET['vnp_TxnRef'])->first();
                return view('client.orders.billSuccess', compact('publishers','order', 'cate', 'auth', 'order_details'))->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng của shop ♥');
            } else {
                $order->delete();
                $bill->delete();
                return view('client.orders.billFailure', compact('publishers','cate', 'auth'));
            }
        } else {
            $bill->delete();
            return view('client.orders.billFailure', compact('publishers','cate', 'auth'));
        }
    }

    
    public function create()
    {
        //
    }

    
    public function storeEvaluate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'orderDetail_id' => 'required|exists:order_details,id',
            'comment' => 'required|string',
            'rating' => 'required|numeric|between:1,5',
        ],[
            'rating.required' => 'Bạn chưa chọn đánh giá sao.',
            'rating.comment' => 'Bạn chưa nhập nội dung đánh giá',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

       
        $evaluate = new Evaluate([
            'book_id' => $request->input('book_id'),
            'user_id' => $request->input('user_id'),
            'orderDetail_id' => $request->input('orderDetail_id'),
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
        ]);

      
        $evaluate->save();


        return redirect()->back()->with('message', 'Cảm ơn bạn đã đánh giá sản phẩm của tôi');
    }

        // SẢN PHẨM YÊU THÍCH

        public function addFavorite(Request $request)
        {
            
            $user = Auth::user();
            $book = $this->book->findOrFail($request->book_id);

           
            $exists = $user->favorites()->where('book_id', $book->id)->exists();

            if ($exists) {
                return redirect()->back()->with(['message' => 'Sản phẩm đã tồn tại trong danh sách yêu thích.']);
            }

            $dataCreate = [
                'user_id' => $user->id,
                'book_id' => $request->book_id,
            ];

            
            $this->favourite->create($dataCreate);

            return redirect()->back()->with(['message' => 'Sản phẩm đã được thêm vào danh sách yêu thích.']);
        }

        public function showFavourite()
        {
            $cate = Category::all();
            $auth = Author::all();
            $publishers = Publisher::all();
            $user = Auth::user();
            $favourites = $user->favorites()->with('book')->get();

    
            return view('client.customer.my-Account.showFavourite', compact('favourites','publishers', 'cate', 'auth'));
        }
        public function deleteFavourite(Request $request)
        {
            $user = Auth::user();
            $bookId = $request->input('book_id');
        
            // Xóa sản phẩm yêu thích của người dùng
            $user->favorites()->where('book_id', $bookId)->delete();
        
            return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi danh sách yêu thích.');
        }
}