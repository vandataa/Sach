<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckOutRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupone;
use App\Models\Publisher;
use App\Models\Freeship;
use App\Models\Order;
use App\Models\Order_Detail;
use App\Models\Quanhuyen;
use App\Models\Sale;
use App\Models\Tinhtp;
use App\Models\User;
use App\Models\Xaphuong;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use PHPUnit\Event\TestSuite\Loaded;

class CartController extends Controller
{
    protected $cart;
    protected $book;
    protected $user;
    protected $order;
    public function __construct(Book $book, Cart $cart, User $user, Order $order)
    {
        $this->book = $book;
        $this->cart = $cart;
        $this->user = $user;
        $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tinhtp = Tinhtp::all();
        $quanhuyen = Quanhuyen::all();
        $xaphuong = Xaphuong::all();
        $ships = Freeship::paginate(10);
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();

        $carts
            = DB::table('carts')
                ->select('carts.quantity', 'carts.money', 'books.title_book', 'books.book_image', 'carts.id')
                ->join('books', 'books.id', '=', 'carts.book_id')
                ->where('carts.user_id', '=', Auth::user()->id)
                ->get();

        return view('client.carts.index', ['publishers' => $publishers, 'carts' => $carts, 'auth' => $auth, 'cate' => $cate, 'tinhtp' => $tinhtp, 'quanhuyen' => $quanhuyen, 'xaphuong' => $xaphuong, 'ships' => $ships]);
    }

    public function selectShip(Request $request)
    {
        $data = $request->all();
        if ($data['action']) {
            $output = '';
            if ($data['action'] == "city") {
                $output .= '<option value="">----Chọn----</option>';
                $quanhuyen = Quanhuyen::where('id_tp', '=', $data['id_tp'])->get();
                foreach ($quanhuyen as $quan) {
                    $output .= '<option value="' . $quan->id . '">' . $quan->name . '</option>';
                }
            } else {
                $output .= '<option value="">----Chọn----</option>';
                $xaphuong = Xaphuong::where('id_qh', '=', $data['id_tp'])->get();
                foreach ($xaphuong as $quan) {
                    $output .= '<option value="' . $quan->id . '">' . $quan->name . '</option>';
                }
            }
        }
        echo $output;
    }
    public function ShipCount(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        if ($data['matp']) {
            $freeship = Freeship::where('id_tp', $data['matp'])->where('id_qh', $data['maqh'])->where('id_xa', $data['maxa'])->first();
            $ct = Tinhtp::findOrfail($data['matp']);
            $huyen = Quanhuyen::findOrfail($data['maqh']);
            $xa = Xaphuong::findOrfail($data['maxa']);
            $diachi = '';
            $diachi .= $xa->name . ' - ' . $huyen->name . ' - ' . $ct->name;
            if ($freeship) {
                Session::put('ship', ['price' => $freeship->price, 'diachi' => $diachi]);
                $user->address = $diachi;
                $user->save();
                Session::save();
            } else {
                Session::put('ship', ['price' => 50000, 'diachi' => $diachi]);
                $user->address = $diachi;
                $user->save();
                Session::save();
            }
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $book = $this->book->findOrFail($request->book_id);
        $cartBook = $this->cart->getBy1($book->id, $user->id);
        if ($request->qty > $book->quantity) {
            return redirect()->back()->with(['error' => 'Bạn đã đặt quá số lượng !']);
        }
        if ($cartBook) {
            $quantity = $cartBook->quantity;
            if ($quantity + $request->qty > $book->quantity) {
                return redirect()->back()->with(['message' => 'Bạn đã đặt quá số lượng !']);
            } else {
                $cartBook->update(['quantity' => ($quantity + $request->qty)]);
            }
        } else {
            $dataCreate['user_id'] = $user->id;
            $dataCreate['book_id'] = $request->book_id;
            $dataCreate['quantity'] = $request->qty ?? 1;
            $dataCreate['money'] = $book->price;
            $this->cart->create($dataCreate);
        }
        ;
        return redirect()->back()->with(['message' => 'Thêm Vào Giỏ Hàng Thành Công']);
    }
    public function storeBook(Request $request)
    {
        $user = Auth::user();
        $book = $this->book->findOrFail($request->book_id);
        $cartBook1 = $this->cart->getBy1($book->id, $user->id);


        if ($cartBook1) {
            if ($request->quantity) {
                $quantity = $cartBook1->qty;
                $cartBook1->update([
                    'quantity' => ($quantity + $request->qty)
                ]);
            } else {
                $quantity = $cartBook1->quantity;
                $cartBook1->update(['quantity' => ($quantity + 1)]);
            }
        } else {
            $dataCreate['user_id'] = $user->id;
            $dataCreate['book_id'] = $request->book_id;
            $dataCreate['quantity'] = $request->qty ?? 1;
            $dataCreate['money'] = $book->price;
            $this->cart->create($dataCreate);
        }

        ;
        return redirect()->back()->with(['message' => 'Thêm Vào Giỏ Hàng Thành Công']);
    }

    public function upIndex(Request $request)
    {
        $cartItem = Cart::find($request->input('id'));
    }
    public function updateCart(Request $request)
    {

        $cartItem = Cart::find($request->input('id'));
        // Kiểm tra xem có sản phẩm trong giỏ hàng không
        if (!$cartItem) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
        }
        // Kiểm tra số lượng thêm vào
        $newQuantity = $request->input('quantity');
        // Kiểm tra số lượng không âm
        if ($newQuantity <= 0) {
            return response()->json(['status' => 'error', 'message' => 'Số lượng phải là một số nguyên dương.']);
        }
        // Kiểm tra số lượng sách trong kho
        $book = Book::find($cartItem->book_id);
        if (!$book) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại trong kho.']);
        }
        if ($newQuantity > $book->quantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Số lượng sách "' . $book->title_book . '" trong giỏ hàng của bạn vượt quá số lượng có sẵn (' . $book->quantity . ') trong kho.'
            ]);
        }
        // Kiểm tra số lượng là số dương
        if ($newQuantity <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Số lượng sách "' . $book->title . '" bạn chọn phải là một số dương và lớn hơn 0.'
            ]);
        }
        // Cập nhật số lượng
        $cartItem->update(['quantity' => $newQuantity]);
        // Tính lại tổng tiền sau khi cập nhật số lượng
        $newPrice = $cartItem->money * $newQuantity;
        $carts
            = DB::table('carts')
                ->select('carts.quantity', 'carts.money', 'books.title_book', 'books.book_image', 'carts.id')
                ->join('books', 'books.id', '=', 'carts.book_id')
                ->where('carts.user_id', '=', Auth::user()->id)
                ->get();
        $total = 0;
        $discount = 0;
        $ship = $request->input('ship') * 1000;
        foreach ($carts as $cart) {
            $total += $cart->money * $cart->quantity;
        }

        if (session('discount')) {
            $discount = session('discount')['sale'];
            if (session('discount')['type'] == "%") {
                $totalDis = $total - $total * $discount;
                $discount = $total * $discount;
                if ($totalDis <= 0) {
                    $totalDis = 0 + $ship;
                } else {
                    $totalDis = $totalDis + $ship;
                }
            } else {
                $totalDis = $total - $discount;

                if ($totalDis <= 0) {
                    $totalDis = 0 + $ship;
                } else {
                    $totalDis = $totalDis + $ship;
                }
            }

            return response()->json([
                'status' => 'success',
                'new_price_formatted' => number_format($newPrice, 0, ',', '.') . ' VNĐ',
                'total' => number_format($total, 0, ',', '.') . ' VNĐ',
                'ship' => number_format($ship, 0, ',', '.'),
                'discount' => number_format($discount, 0, ',', '.') . ' VNĐ',
                'final_total' => number_format($totalDis, 0, ',', '.') . ' VNĐ'
            ]);
        } else {
            $totalDis = $total + $ship;
            return response()->json([
                'status' => 'success',
                'new_price_formatted' => number_format($newPrice, 0, ',', '.') . ' VNĐ',
                'ship' => number_format($ship, 0, ',', '.'),
                'total' => number_format($total, 0, ',', '.') . ' VNĐ',
                'final_total' => number_format($totalDis, 0, ',', '.') . ' VNĐ'
            ]);
        }

    }

    public function deleteCart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->back()->with(['message' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
    }
    public function checkout()
    {
        $carts
            = DB::table('carts')
                ->select('carts.quantity', 'carts.money', 'books.title_book', 'books.book_image', 'carts.id')
                ->join('books', 'books.id', '=', 'carts.book_id')
                ->where('carts.user_id', '=', Auth::user()->id)
                ->get();
        if ($carts->isNotEmpty()) {
            $cate = Category::all();
            $auth = Author::all();
            $publishers = Publisher::all();
            $user = $this->user->findOrFail(Auth::user()->id);
            $carts
                = DB::table('carts')
                    ->select('carts.quantity', 'carts.money', 'books.title_book', 'books.book_image', 'carts.id')
                    ->join('books', 'books.id', '=', 'carts.book_id')
                    ->where('carts.user_id', '=', Auth::user()->id)
                    ->get();
            $order = Order::where('total', '1428')->get();
            return view('client.carts.checkout', ['publishers' => $publishers, 'carts' => $carts, 'user' => $user, 'order' => $order, 'cate' => $cate, 'auth' => $auth]);
        } else {
            $cate = Category::all();
            $auth = Author::all();
            $publishers = Publisher::all();
            return view('client.carts.index', ['publishers' => $publishers, 'carts' => $carts, 'auth' => $auth, 'cate' => $cate]);
        }
    }
    public function processCheckout(CheckOutRequest $request)
    {

        $diachi = '';
        $diachi .= $request->customer_address . '-' . $request->customer_address_1;

        if ($request->thanhtoan == 1) {
            $carts
                = DB::table('carts')
                    ->select('carts.quantity', 'carts.money', 'books.title_book', 'books.book_image', 'carts.id', 'carts.book_id')
                    ->join('books', 'books.id', '=', 'carts.book_id')
                    ->where('carts.user_id', '=', Auth::user()->id)
                    ->get();
            $auth = Auth::user();
            $dataCreate1['name'] = $request->customer_name;
            $dataCreate1['phone'] = $request->customer_phone;
            $dataCreate1['address'] = $diachi;
            $dataCreate1['status'] = 'Đang xử lý';
            $dataCreate1['email'] = $request->customer_email;
            $dataCreate1['note'] = $request->note;
            $dataCreate1['ship'] = $request->ship;
            $dataCreate1['total'] = $request->total;
            $dataCreate1['id_customer'] = Auth::user()->id;
            $dataCreate1['code_bill'] = $request->code_bill;
            $dataCreate1['payment'] = "Nhận Hàng Thanh Toán";
            $dataCreate1['date'] = new DateTime('now');

            if (session('discount')) {
                $id = $request->input('id_sale');
                $sale = Sale::where('id', $id)->first();
                $code_sale = $sale->code;
                $dataCreate1['code_sale'] = $code_sale;
                $count = $sale->count;
                Sale::where('id', $id)->update([
                    'count' => $count - 1,
                ]);
                //tạo 1 coupone để code chỉ được sử dụng 1 lần
                $dataCoupone = [
                    'id_user' => $request->input('id_user'),
                    'id_sale' => $request->input('id_sale'),
                ];
                Coupone::create($dataCoupone);
                //xóa session của discount
                session()->remove('discount');

            }
            $order = Order::create($dataCreate1);

            $order_id = DB::table('orders')->orderBy('id', 'desc')->value('id');

            foreach ($carts as $cart) {

                $dataCreate2['book_quantity'] = $cart->quantity;
                $dataCreate2['book_id'] = $cart->book_id;
                $dataCreate2['order_id'] = $order_id;

                //Thêm số lượng sản phẩm đã bán
                // $book = Book::find($cart->book_id);
                // $book->sold_quantity += $cart->quantity;
                // $book->save();
                $order_detail = Order_Detail::create($dataCreate2);

                //trứ số lượng sách trong kho
                $book_olds = DB::table('books')
                    ->select('books.quantity')
                    ->where('books.id', '=', $cart->book_id)
                    ->get();
                foreach ($book_olds as $book_old) {
                    $book_quantity = $book_old->quantity;
                    $bookNew = Book::where('id', $cart->book_id)->update(['quantity' => $book_quantity - $cart->quantity]);
                }
            }
            $order_details
                = DB::table('order_details')
                    ->select('order_details.book_quantity', 'books.title_book', 'books.price', 'order_details.id')
                    ->join('books', 'books.id', '=', 'order_details.book_id')
                    ->where('order_details.order_id', '=', $order_id)
                    ->get();
            //Gửi mail xác nhận đơn hàng
            Mail::send('emails.check_order', compact('order', 'auth', 'order_details'), function ($email) use ($request) {
                $email->to($request->customer_email);
                $email->subject('Checkout Carts');
            });
            // XÓa giở hàng đẵ order
            $cart = $this->cart->getBy2(Auth::user()->id);
            $cart->delete();




            $order = $this->order->orderBy('id', 'desc')->first();
            $order_details
                = DB::table('order_details')
                    ->select('order_details.book_quantity', 'books.title_book', 'books.price', 'order_details.id')
                    ->join('books', 'books.id', '=', 'order_details.book_id')
                    ->where('order_details.order_id', '=', $order_id)
                    ->get();
            $cate = Category::all();
            $auth = Author::all();
            $publishers = Publisher::all();
            return view('client.orders.billSuccess', compact('publishers', 'order', 'cate', 'auth', 'order_details'))->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng của shop ♥');
        } elseif ($request->thanhtoan == 2) {

            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://127.0.0.1:8000/bill_detail";
            $vnp_TmnCode = "DPZBK1M6"; //Mã website tại VNPAY
            $vnp_HashSecret = "WOALGVDYWSIWTZBFIHYMXRBPVDRISUGC"; //Chuỗi bí mật

            $vnp_TxnRef = $request->code_bill; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = 'Thanh toàn đơn hàng test';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $request->total * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            //Add Params of 2.0.1 Version
            // $vnp_ExpireDate = $_POST['txtexpire'];
            //Billing

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array(
                'code' => '00',
                'message' => 'success',
                'data' => $vnp_Url
            );
            // Thêm vào bảng order
            $carts
                = DB::table('carts')
                    ->select('carts.quantity', 'carts.money', 'books.title_book', 'books.book_image', 'carts.id', 'carts.book_id')
                    ->join('books', 'books.id', '=', 'carts.book_id')
                    ->where('carts.user_id', '=', Auth::user()->id)
                    ->get();

            $auth = Auth::user();
            $dataCreate1['name'] = $request->customer_name;
            $dataCreate1['phone'] = $request->customer_phone;
            $dataCreate1['address'] = $diachi;
            $dataCreate1['status'] = 'Đang xử lý';

            $dataCreate1['email'] = $request->customer_email;
            $dataCreate1['note'] = $request->note;
            $dataCreate1['ship'] = $request->ship;
            $dataCreate1['total'] = $request->total;
            $dataCreate1['code_bill'] = $request->code_bill;
            $dataCreate1['id_customer'] = Auth::user()->id;
            $dataCreate1['payment'] = "Đã Thanh Toán VNPAY";
            $dataCreate1['date'] = new DateTime('now');


            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);

                if ($returnData['code'] == '00') {

                    $order = $this->order->create($dataCreate1);
                    $order_id = DB::table('orders')->orderBy('id', 'desc')->value('id');
                    foreach ($carts as $cart) {

                        $dataCreate2['book_quantity'] = $cart->quantity;
                        $dataCreate2['book_id'] = $cart->book_id;
                        $dataCreate2['order_id'] = $order_id;

                        $order_detail = Order_Detail::create($dataCreate2);
                        //update book
                        $book_olds = DB::table('books')
                            ->select('books.quantity')
                            ->where('books.id', '=', $cart->book_id)
                            ->get();
                        foreach ($book_olds as $book_old) {
                            $book_quantity = $book_old->quantity;
                            $bookNew = Book::where('id', $cart->book_id)->update(['quantity' => $book_quantity - $cart->quantity]);
                        }
                    }
                    $order_details
                        = DB::table('order_details')
                            ->select('order_details.book_quantity', 'books.title_book', 'books.price', 'order_details.id')
                            ->join('books', 'books.id', '=', 'order_details.book_id')
                            ->where('order_details.order_id', '=', $order_id)
                            ->get();

                    //Gửi mail xác nhận đơn hàng
                    Mail::send('emails.check_order', compact('order', 'auth', 'order_details'), function ($email) use ($request) {
                        $email->to($request->customer_email);
                        $email->subject('Checkout Carts');
                    });
                    // XÓa giở hàng đẵ order
                    $cart = $this->cart->getBy2(Auth::user()->id);
                    $cart->delete();



                }
                die();
            } else {
                echo json_encode($returnData);
            }
        } else {
            return redirect()->back()->with('message', "Vui lòng chọn phương thức thanh toán");
        }
    }
}
