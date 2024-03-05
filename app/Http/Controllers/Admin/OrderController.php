<?php

namespace App\Http\Controllers\Admin;

use App\Models\History;
use App\Models\Order_Detail;
use App\Models\User;
use Illuminate\Support\Facades\DB;



use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class OrderController extends Controller
{
    protected $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->search()->paginate(10);
        return view("admin.orders.index", compact('orders'));
    }
    public function history()
    {
        $event = [
            'created' => 'Thêm mới',
            'updated' => 'Cập nhật',
            'deleted' => 'Xóa',
            'restored' => ' Khôi phục'
        ];
        $subject_type = [
            'App\Models\Order' => 'Đơn hàng',
        ];
        $his = History::where('subject_type', Order::class,)->get();
        $users = User::all();
        $orders = Order::all();
        return view('admin.orders.history', compact('his', 'orders', 'users', 'event', 'subject_type'));
    }
    public function orderDetail(string $id)
    {
        $order = $this->order->FindOrFail($id);
        $order_details
            = DB::table('order_details')
            ->select('order_details.book_quantity', 'books.title_book', 'books.price', 'order_details.id')
            ->join('books', 'books.id', '=', 'order_details.book_id')
            ->where('order_details.order_id', '=', $id)
            ->get();
        return view('admin.orders.order_detail', compact('order', 'order_details'));
    }
    public function filter(Request $request)
    {
        $statusOrder = $request->input('status');
        $searchInput = $request->input('searchInput');
        $code = $request->input('code_bill');
        $orderQuery = Order::query();
        // Lọc theo trạng thái đơn hàng
        if ($statusOrder) {
            $orderQuery->where('status', '=', $statusOrder);
        }
        // Tìm theo tên
        if ($searchInput) {
            $orderQuery->where('name', 'like', '%' . $searchInput . '%');
        }
        if ($code) {
            $orderQuery->where('code_bill', '=', $code);
        }
        $orders = $orderQuery->paginate(10);

        return view("admin.orders.index", compact("orders"));
    }
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
        $order = DB::table('orders')->where('id', $id)->update(['status' => $status]);

        return redirect()->back()->with(['message' => '']);

    }
    public function updateStatus2(Request $request, $id)
    {
        $order =  $this->order->findOrFail($id);
        $oldData = [
            'Id' => $order->id,
            'Code Bill' => $order->code_bill,
            'Trạng thái' => $order->status,
            'PT Thanh toán' => $order->payment,
        ];
        $order_details = Order_Detail::where('order_id', $id)->get();
        $order->update(['status' => $request->status]);
        if ($order->update()) {
            $newData = [
                'Id' => $order->id,
                'Code Bill' => $order->code_bill,
                'Trạng thái' => $order->status,
                'PT Thanh toán' => $order->payment,
            ];
            Activity::create([
                'description' => 'Cập nhật',
                'subject_id' => $order->id,
                'subject_type' => Order::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'old_data' => json_encode($oldData),
                'new_data' => json_encode($newData),
            ]);
        }
        //update book
        if( $request->status == 'Hủy đơn hàng'){
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
        }
        if( $request->status == 'Giao hàng thành công'){
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
        }

    }
}