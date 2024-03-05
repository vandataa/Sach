<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Customer;
use App\Models\History;
use App\Models\Order;
use App\Models\Review;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $event = [
            'created' => 'Thêm mới',
            'updated' => 'Cập nhật',
            'deleted' => 'Xóa',
            'restored' => ' Khôi phục'
        ];
        $subject_type = [
            'App\Models\Author' => 'Tác giả',
            'App\Models\Sale' => 'Giảm Giá',
            'App\Models\Category' => 'Thể loại',
            'App\Models\Book' => 'Sách',
            'App\Models\User' => 'Tài khoản',
            'App\Models\Review' => 'Bình luận',
            'App\Models\Order' => 'Đơn hàng',
            'App\Models\Customer' => ' Tài khoản',
            'App\Models\Publisher' => ' Nhà xuất bản',
        ];
        $his = History::paginate(10);
        $author = Author::withTrashed()->get();
        $sales = Sale::withTrashed()->get();
        $categories = Category::withTrashed()->get();
        $book = Book::withTrashed()->get();
        $users = User::withTrashed()->get();
        $reviews = Review::withTrashed()->get();
        $orders = Order::all();
        $customers = Customer::all();
        return view('admin.history.history', compact('his', 'event', 'users', 'subject_type', 'author', 'book', 'sales', 'orders', 'reviews', 'customers', 'categories'));
    }
    public function detail(string $id)
    {
        $event = [
            'created' => 'Thêm mới',
            'updated' => 'Cập nhật',
            'deleted' => 'Xóa',
            'restored' => ' Khôi phục'
        ];
        $subject_type = [
            'App\Models\Author' => 'Tác giả',
            'App\Models\Sale' => 'Giảm Giá',
            'App\Models\Category' => 'Thể loại',
            'App\Models\Book' => 'Sách',
            'App\Models\User' => 'Tài khoản',
            'App\Models\Review' => 'Bình luận',
            'App\Models\Order' => 'Đơn hàng',
            'App\Models\Customer' => ' Tài khoản',
            'App\Models\Publisher' => ' Nhà xuất bản',
        ];
        $his = History::find($id);
        $author = Author::withTrashed()->get();
        $sales = Sale::withTrashed()->get();
        $categories = Category::withTrashed()->get();
        $book = Book::withTrashed()->get();
        $users = User::withTrashed()->get();
        $reviews = Review::withTrashed()->get();
        $orders = Order::all();
        $customers = Customer::all();
        return view('admin.history.detail', compact('his', 'event', 'users', 'subject_type', 'author', 'book', 'sales', 'orders', 'reviews', 'customers', 'categories'));
    }
    public function filter(Request $request)
    {
        $log_name = $request->searchInput;
        $event = [
            'created' => 'Thêm mới',
            'updated' => 'Cập nhật',
            'deleted' => 'Xóa',
            'restored' => ' Khôi phục'
        ];
        $subject_type = [
            'App\Models\Author' => 'Tác giả',
            'App\Models\Sale' => 'Giảm Giá',
            'App\Models\Category' => 'Thể loại',
            'App\Models\Book' => 'Sách',
            'App\Models\User' => 'Tài khoản',
            'App\Models\Review' => 'Bình luận',
            'App\Models\Order' => 'Đơn hàng',
            'App\Models\Customer' => ' Tài khoản',
            'App\Models\Publisher' => ' Nhà xuất bản',
        ];

        $his = History::all();
        if ($log_name) {
            $his = History::whereHas('user', function ($query) use ($log_name) {
                $query->where('name', 'like', "%$log_name%");
            })->paginate(10);
        }
        if ($request->action) {
            $his = History::where('description', $request->action)->paginate(10);
        }
        if ($request->table) {
            $his = History::where('subject_type', $request->table)->paginate(10);
        }
        if ($request->table && $request->action) {
            $his = History::where('subject_type', $request->table)->where('description', $request->action)->paginate(10);
        }

        $author = Author::withTrashed()->get();
        $sales = Sale::withTrashed()->get();
        $categories = Category::withTrashed()->get();
        $book = Book::withTrashed()->get();
        $users = User::withTrashed()->get();
        $reviews = Review::withTrashed()->get();
        $orders = Order::all();
        $customers = Customer::all();
        return view('admin.history.history', compact('his', 'event', 'users', 'subject_type', 'author', 'book', 'sales', 'orders', 'reviews', 'customers', 'categories'));
    }
}
