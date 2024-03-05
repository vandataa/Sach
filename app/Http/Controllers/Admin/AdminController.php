<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAdminRequest;
use App\Models\Book;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use App\Models\Publisher;
use App\Models\Order_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{

    public function index(Request $request)
    {

        $books = Book::count();
        $order = Order::count();
        $review = Review::count();
        $user = User::where('role', '3')->count();
        $processOrders = Order::where('status', 'Đang xử lý')->count();
        // $totalRevenue = Order::where('status', 'Giao hàng thành công')->sum('total');
        $totalRevenuees = Order::where(function ($query) {
            $query->where('status', 'Giao hàng thành công')
                ->orWhere('payment', 'Đã Thanh Toán VNPAY');
        })
            ->whereNotIn('status', ['Hủy đơn hàng'])
            ->sum('total');

        //Thống Kê doanh thu
        $start_datet = Carbon::parse($request->input('start_datet'))->startOfDay();
        $end_datet = Carbon::parse($request->input('end_datet'))->endOfDay();


        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total) as revenue')
            ->where(function ($query) {
                $query->where('status', 'Giao hàng thành công')
                    ->orWhere('payment', 'Đã Thanh Toán VNPAY');
            })
            ->whereNotIn('status', ['Hủy đơn hàng'])
            ->whereBetween('created_at', [$start_datet, $end_datet])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $selectedDatesst = [
            'start_datet' => $start_datet->format('d/m/Y'),
            'end_datet' => $end_datet->format('d/m/Y'),
        ];

        //Top 5 sản phẩm bán chạy nhất trong tháng
        $bookStartDate = $request->filled('start_datee') ? Carbon::parse($request->input('start_datee'))->startOfDay() : '';
        $bookEndDate = $request->filled('end_datee') ? Carbon::parse($request->input('end_datee'))->endOfDay() : '';

        try {
            if (is_null($bookStartDate) || is_null($bookEndDate)) {
                $result = '';

            } else {
                $parsedStartDate = Carbon::parse($bookStartDate)->startOfDay();
                $parsedEndDate = Carbon::parse($bookEndDate)->endOfDay();

                // Thực hiện câu truy vấn để lấy thông tin top 5 sản phẩm theo tháng

                $result = Order_Detail::select(
                    'book_id',
                    'books.title_book as book_name',
                    'books.book_image',
                    DB::raw('SUM(book_quantity) as total_quantity')
                )
                    ->join('orders', 'order_details.order_id', '=', 'orders.id')
                    ->join('books', 'order_details.book_id', '=', 'books.id')
                    ->whereBetween('orders.created_at', [$parsedStartDate, $parsedEndDate])
                    ->where(function ($query) {
                        $query->where('orders.status', 'Giao hàng thành công')
                            ->orWhere('orders.payment', 'Đã Thanh Toán VNPAY');
                    })
                    ->whereNotIn('orders.status', ['Hủy đơn hàng'])
                    ->groupBy('book_id', 'books.title_book', 'books.book_image')
                    ->orderByDesc('total_quantity')
                    ->limit(5)
                    ->get();
                // Truyền dữ liệu ngày tháng năm đã chọn vào View
                $selectedDates = [
                    'start_datee' => $parsedStartDate->format('d/m/Y'),
                    'end_datee' => $parsedEndDate->format('d/m/Y'),
                ];
            }
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            // In ra thông báo lỗi để kiểm tra
            dd($e->getMessage());
        }

        //Top 5 khách hàng đặt hàng nhiều nhất trong tháng
        $userdStartDate = $request->filled('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : '';
        $userdEndDate = $request->filled('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : '';

        try {
            if (is_null($userdStartDate) || is_null($userdStartDate)) {
                $topUser = '';

            } else {
                // Chuyển đổi ngày bắt đầu và kết thúc thành đối tượng Carbon
                $parsedStartDatee = Carbon::parse($userdStartDate)->startOfDay();
                $parsedEndDatee = Carbon::parse($userdEndDate)->endOfDay();

                $topUser = DB::table('orders')
                    ->select('users.id', 'users.name', 'users.email', DB::raw('SUM(order_details.book_quantity) as total_books_ordered'))
                    ->join('users', 'orders.id_customer', '=', 'users.id')
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->whereBetween('orders.created_at', [$parsedStartDatee, $parsedEndDatee])
                    ->where(function ($query) {
                        $query->where('orders.status', 'Giao hàng thành công')
                            ->orWhere('orders.payment', 'Đã Thanh Toán VNPAY');
                    })
                    ->whereNotIn('orders.status', ['Hủy đơn hàng'])
                    ->groupBy('users.id', 'users.name', 'users.email')
                    ->orderByDesc('total_books_ordered')
                    ->limit(5)
                    ->get();
                $selectedDatess = [
                    'start_date' => $parsedStartDatee->format('d/m/Y'),
                    'end_date' => $parsedEndDatee->format('d/m/Y'),
                ];
            }
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            // In ra thông báo lỗi để kiểm tra
            dd($e->getMessage());
        }

        $revenueByPublisher = Publisher::select('publisher.name as publisher_name', 'publisher.id as id_publisher', DB::raw('SUM(IFNULL(books.sold_quantity, 0) * books.price) as total_revenue'))
            ->leftJoin('books', 'publisher.id', '=', 'books.id_publisher')
            ->groupBy('publisher.id', 'publisher.name')
            ->orderByDesc('total_revenue')
            ->limit(5)->get();
        return view('admin', compact('selectedDatesst', 'selectedDatess', 'selectedDates', 'revenueByPublisher', 'topUser', 'result', 'books', 'totalRevenuees', 'order', 'review', 'user', 'processOrders'), ['dailyRevenue' => $dailyRevenue]);
    }

    protected function getTopProducts($selectedMonth)
    {
        $result = Order_Detail::select(
            'book_id',
            'books.title_book as book_name',
            DB::raw('SUM(book_quantity) as total_quantity')
        )
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('books', 'order_details.book_id', '=', 'books.id')
            ->whereRaw('YEAR(orders.created_at) = ?', [Carbon::parse($selectedMonth)->year])
            ->whereRaw('MONTH(orders.created_at) = ?', [Carbon::parse($selectedMonth)->month])
            ->groupBy('book_id', 'books.title_book')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return $result;
    }
    public function login()
    {
        return view('admin.login');
    }

    public function loginPost(LoginAdminRequest $request)
    {
        $user = $request->only('email', 'password');
        if (Auth::attempt($user)) {
            return redirect()->route('admin');
        }
        $error = 'Sai thông tin đăng nhập!';
        return redirect()->back()->withErrors(['error' => $error])->with('error', $error);
    }

    function logout()
    {
        FacadesSession::flush();
        Auth::logout();
        return redirect()->route('login');
    }
    public function topds(Request $request){
        $books = Book::count();
        $order = Order::count();
        $review = Review::count();
        $user = User::where('role', '3')->count();
        $processOrders = Order::where('status', 'Đang xử lý')->count();
        // $totalRevenue = Order::where('status', 'Giao hàng thành công')->sum('total');
        $totalRevenuees = Order::where(function ($query) {
            $query->where('status', 'Giao hàng thành công')
                ->orWhere('payment', 'Đã Thanh Toán VNPAY');
        })
            ->whereNotIn('status', ['Hủy đơn hàng'])
            ->sum('total');

        //Thống Kê doanh thu
        $start_datet = Carbon::parse($request->input('start_datet'))->startOfDay();
        $end_datet = Carbon::parse($request->input('end_datet'))->endOfDay();


        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total) as revenue')
            ->where(function ($query) {
                $query->where('status', 'Giao hàng thành công')
                    ->orWhere('payment', 'Đã Thanh Toán VNPAY');
            })
            ->whereNotIn('status', ['Hủy đơn hàng'])
            ->whereBetween('created_at', [$start_datet, $end_datet])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $selectedDatesst = [
            'start_datet' => $start_datet->format('d/m/Y'),
            'end_datet' => $end_datet->format('d/m/Y'),
        ];

        //Top 5 sản phẩm bán chạy nhất trong tháng
        
        return view('admin.dashboard.topds', compact('selectedDatesst', 'books', 'totalRevenuees', 'order', 'review', 'user', 'processOrders'), ['dailyRevenue' => $dailyRevenue]);
    }
    public function top5sp(Request $request){
        
        $books = Book::count();
        $order = Order::count();
        $review = Review::count();
        $user = User::where('role', '3')->count();
        $processOrders = Order::where('status', 'Đang xử lý')->count();
        // $totalRevenue = Order::where('status', 'Giao hàng thành công')->sum('total');
        $totalRevenuees = Order::where(function ($query) {
            $query->where('status', 'Giao hàng thành công')
                ->orWhere('payment', 'Đã Thanh Toán VNPAY');
        })
            ->whereNotIn('status', ['Hủy đơn hàng'])
            ->sum('total');

        //Thống Kê doanh thu
        $start_datet = Carbon::parse($request->input('start_datet'))->startOfDay();
        $end_datet = Carbon::parse($request->input('end_datet'))->endOfDay();


        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total) as revenue')
            ->where(function ($query) {
                $query->where('status', 'Giao hàng thành công')
                    ->orWhere('payment', 'Đã Thanh Toán VNPAY');
            })
            ->whereNotIn('status', ['Hủy đơn hàng'])
            ->whereBetween('created_at', [$start_datet, $end_datet])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $selectedDatesst = [
            'start_datet' => $start_datet->format('d/m/Y'),
            'end_datet' => $end_datet->format('d/m/Y'),
        ];

        //Top 5 sản phẩm bán chạy nhất trong tháng
        $bookStartDate = $request->filled('start_datee') ? Carbon::parse($request->input('start_datee'))->startOfDay() : '';
        $bookEndDate = $request->filled('end_datee') ? Carbon::parse($request->input('end_datee'))->endOfDay() : '';

        try {
            if (is_null($bookStartDate) || is_null($bookEndDate)) {
                $result = '';

            } else {
                $parsedStartDate = Carbon::parse($bookStartDate)->startOfDay();
                $parsedEndDate = Carbon::parse($bookEndDate)->endOfDay();

                // Thực hiện câu truy vấn để lấy thông tin top 5 sản phẩm theo tháng

                $result = Order_Detail::select(
                    'book_id',
                    'books.title_book as book_name',
                    'books.book_image',
                    DB::raw('SUM(book_quantity) as total_quantity')
                )
                    ->join('orders', 'order_details.order_id', '=', 'orders.id')
                    ->join('books', 'order_details.book_id', '=', 'books.id')
                    ->whereBetween('orders.created_at', [$parsedStartDate, $parsedEndDate])
                    ->where(function ($query) {
                        $query->where('orders.status', 'Giao hàng thành công')
                            ->orWhere('orders.payment', 'Đã Thanh Toán VNPAY');
                    })
                    ->whereNotIn('orders.status', ['Hủy đơn hàng'])
                    ->groupBy('book_id', 'books.title_book', 'books.book_image')
                    ->orderByDesc('total_quantity')
                    ->limit(5)
                    ->get();
                // Truyền dữ liệu ngày tháng năm đã chọn vào View
                $selectedDates = [
                    'start_datee' => $parsedStartDate->format('d/m/Y'),
                    'end_datee' => $parsedEndDate->format('d/m/Y'),
                ];
            }
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            // In ra thông báo lỗi để kiểm tra
            dd($e->getMessage());
        }

        //Top 5 khách hàng đặt hàng nhiều nhất trong tháng
        $userdStartDate = $request->filled('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : '';
        $userdEndDate = $request->filled('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : '';

        try {
            if (is_null($userdStartDate) || is_null($userdStartDate)) {
                $topUser = '';

            } else {
                // Chuyển đổi ngày bắt đầu và kết thúc thành đối tượng Carbon
                $parsedStartDatee = Carbon::parse($userdStartDate)->startOfDay();
                $parsedEndDatee = Carbon::parse($userdEndDate)->endOfDay();

                $topUser = DB::table('orders')
                    ->select('users.id', 'users.name', 'users.email', DB::raw('SUM(order_details.book_quantity) as total_books_ordered'))
                    ->join('users', 'orders.id_customer', '=', 'users.id')
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->whereBetween('orders.created_at', [$parsedStartDatee, $parsedEndDatee])
                    ->where(function ($query) {
                        $query->where('orders.status', 'Giao hàng thành công')
                            ->orWhere('orders.payment', 'Đã Thanh Toán VNPAY');
                    })
                    ->whereNotIn('orders.status', ['Hủy đơn hàng'])
                    ->groupBy('users.id', 'users.name', 'users.email')
                    ->orderByDesc('total_books_ordered')
                    ->limit(5)
                    ->get();
                $selectedDatess = [
                    'start_date' => $parsedStartDatee->format('d/m/Y'),
                    'end_date' => $parsedEndDatee->format('d/m/Y'),
                ];
            }
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            // In ra thông báo lỗi để kiểm tra
            dd($e->getMessage());
        }

        $revenueByPublisher = Publisher::select('publisher.name as publisher_name', 'publisher.id as id_publisher', DB::raw('SUM(IFNULL(books.sold_quantity, 0) * books.price) as total_revenue'))
            ->leftJoin('books', 'publisher.id', '=', 'books.id_publisher')
            ->groupBy('publisher.id', 'publisher.name')
            ->orderByDesc('total_revenue')
            ->limit(5)->get();
        return view('admin.dashboard.top5sp', compact('selectedDatesst', 'selectedDatess', 'selectedDates', 'revenueByPublisher', 'topUser', 'result', 'books', 'totalRevenuees', 'order', 'review', 'user', 'processOrders'), ['dailyRevenue' => $dailyRevenue]);
    }

    public function topnsx(Request $request){

        $books = Book::count();
        $order = Order::count();
        $review = Review::count();
        $user = User::where('role', '3')->count();
        $processOrders = Order::where('status', 'Đang xử lý')->count();
        // $totalRevenue = Order::where('status', 'Giao hàng thành công')->sum('total');
        $totalRevenuees = Order::where(function ($query) {
            $query->where('status', 'Giao hàng thành công')
                ->orWhere('payment', 'Đã Thanh Toán VNPAY');
        })
            ->whereNotIn('status', ['Hủy đơn hàng'])
            ->sum('total');

        //Thống Kê doanh thu
        $start_datet = Carbon::parse($request->input('start_datet'))->startOfDay();
        $end_datet = Carbon::parse($request->input('end_datet'))->endOfDay();


        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total) as revenue')
            ->where(function ($query) {
                $query->where('status', 'Giao hàng thành công')
                    ->orWhere('payment', 'Đã Thanh Toán VNPAY');
            })
            ->whereNotIn('status', ['Hủy đơn hàng'])
            ->whereBetween('created_at', [$start_datet, $end_datet])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $selectedDatesst = [
            'start_datet' => $start_datet->format('d/m/Y'),
            'end_datet' => $end_datet->format('d/m/Y'),
        ];

        //Top 5 sản phẩm bán chạy nhất trong tháng
        $bookStartDate = $request->filled('start_datee') ? Carbon::parse($request->input('start_datee'))->startOfDay() : '';
        $bookEndDate = $request->filled('end_datee') ? Carbon::parse($request->input('end_datee'))->endOfDay() : '';

        try {
            if (is_null($bookStartDate) || is_null($bookEndDate)) {
                $result = '';

            } else {
                $parsedStartDate = Carbon::parse($bookStartDate)->startOfDay();
                $parsedEndDate = Carbon::parse($bookEndDate)->endOfDay();

                // Thực hiện câu truy vấn để lấy thông tin top 5 sản phẩm theo tháng

                $result = Order_Detail::select(
                    'book_id',
                    'books.title_book as book_name',
                    'books.book_image',
                    DB::raw('SUM(book_quantity) as total_quantity')
                )
                    ->join('orders', 'order_details.order_id', '=', 'orders.id')
                    ->join('books', 'order_details.book_id', '=', 'books.id')
                    ->whereBetween('orders.created_at', [$parsedStartDate, $parsedEndDate])
                    ->where(function ($query) {
                        $query->where('orders.status', 'Giao hàng thành công')
                            ->orWhere('orders.payment', 'Đã Thanh Toán VNPAY');
                    })
                    ->whereNotIn('orders.status', ['Hủy đơn hàng'])
                    ->groupBy('book_id', 'books.title_book', 'books.book_image')
                    ->orderByDesc('total_quantity')
                    ->limit(5)
                    ->get();
                // Truyền dữ liệu ngày tháng năm đã chọn vào View
                $selectedDates = [
                    'start_datee' => $parsedStartDate->format('d/m/Y'),
                    'end_datee' => $parsedEndDate->format('d/m/Y'),
                ];
            }
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            // In ra thông báo lỗi để kiểm tra
            dd($e->getMessage());
        }

        //Top 5 khách hàng đặt hàng nhiều nhất trong tháng
        $userdStartDate = $request->filled('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : '';
        $userdEndDate = $request->filled('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : '';

        try {
            if (is_null($userdStartDate) || is_null($userdStartDate)) {
                $topUser = '';

            } else {
                // Chuyển đổi ngày bắt đầu và kết thúc thành đối tượng Carbon
                $parsedStartDatee = Carbon::parse($userdStartDate)->startOfDay();
                $parsedEndDatee = Carbon::parse($userdEndDate)->endOfDay();

                $topUser = DB::table('orders')
                    ->select('users.id', 'users.name', 'users.email', DB::raw('SUM(order_details.book_quantity) as total_books_ordered'))
                    ->join('users', 'orders.id_customer', '=', 'users.id')
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->whereBetween('orders.created_at', [$parsedStartDatee, $parsedEndDatee])
                    ->where(function ($query) {
                        $query->where('orders.status', 'Giao hàng thành công')
                            ->orWhere('orders.payment', 'Đã Thanh Toán VNPAY');
                    })
                    ->whereNotIn('orders.status', ['Hủy đơn hàng'])
                    ->groupBy('users.id', 'users.name', 'users.email')
                    ->orderByDesc('total_books_ordered')
                    ->limit(5)
                    ->get();
                $selectedDatess = [
                    'start_date' => $parsedStartDatee->format('d/m/Y'),
                    'end_date' => $parsedEndDatee->format('d/m/Y'),
                ];
            }
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            // In ra thông báo lỗi để kiểm tra
            dd($e->getMessage());
        }

        $revenueByPublisher = Publisher::select('publisher.name as publisher_name', 'publisher.id as id_publisher', DB::raw('SUM(IFNULL(books.sold_quantity, 0) * books.price) as total_revenue'))
            ->leftJoin('books', 'publisher.id', '=', 'books.id_publisher')
            ->groupBy('publisher.id', 'publisher.name')
            ->orderByDesc('total_revenue')
            ->limit(5)->get();
        return view('admin.dashboard.topnsx', compact('selectedDatesst', 'selectedDatess', 'selectedDates', 'revenueByPublisher', 'topUser', 'result', 'books', 'totalRevenuees', 'order', 'review', 'user', 'processOrders'), ['dailyRevenue' => $dailyRevenue]);
    }

    public function topuser(Request $request){

        $books = Book::count();
        $order = Order::count();
        $review = Review::count();
        $user = User::where('role', '3')->count();
        $processOrders = Order::where('status', 'Đang xử lý')->count();
        // $totalRevenue = Order::where('status', 'Giao hàng thành công')->sum('total');
        $totalRevenuees = Order::where(function ($query) {
            $query->where('status', 'Giao hàng thành công')
                ->orWhere('payment', 'Đã Thanh Toán VNPAY');
        })
            ->whereNotIn('status', ['Hủy đơn hàng'])
            ->sum('total');

        //Thống Kê doanh thu
        $start_datet = Carbon::parse($request->input('start_datet'))->startOfDay();
        $end_datet = Carbon::parse($request->input('end_datet'))->endOfDay();


        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total) as revenue')
            ->where(function ($query) {
                $query->where('status', 'Giao hàng thành công')
                    ->orWhere('payment', 'Đã Thanh Toán VNPAY');
            })
            ->whereNotIn('status', ['Hủy đơn hàng'])
            ->whereBetween('created_at', [$start_datet, $end_datet])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $selectedDatesst = [
            'start_datet' => $start_datet->format('d/m/Y'),
            'end_datet' => $end_datet->format('d/m/Y'),
        ];

        //Top 5 sản phẩm bán chạy nhất trong tháng
        $bookStartDate = $request->filled('start_datee') ? Carbon::parse($request->input('start_datee'))->startOfDay() : '';
        $bookEndDate = $request->filled('end_datee') ? Carbon::parse($request->input('end_datee'))->endOfDay() : '';

        try {
            if (is_null($bookStartDate) || is_null($bookEndDate)) {
                $result = '';

            } else {
                $parsedStartDate = Carbon::parse($bookStartDate)->startOfDay();
                $parsedEndDate = Carbon::parse($bookEndDate)->endOfDay();

                // Thực hiện câu truy vấn để lấy thông tin top 5 sản phẩm theo tháng

                $result = Order_Detail::select(
                    'book_id',
                    'books.title_book as book_name',
                    'books.book_image',
                    DB::raw('SUM(book_quantity) as total_quantity')
                )
                    ->join('orders', 'order_details.order_id', '=', 'orders.id')
                    ->join('books', 'order_details.book_id', '=', 'books.id')
                    ->whereBetween('orders.created_at', [$parsedStartDate, $parsedEndDate])
                    ->where(function ($query) {
                        $query->where('orders.status', 'Giao hàng thành công')
                            ->orWhere('orders.payment', 'Đã Thanh Toán VNPAY');
                    })
                    ->whereNotIn('orders.status', ['Hủy đơn hàng'])
                    ->groupBy('book_id', 'books.title_book', 'books.book_image')
                    ->orderByDesc('total_quantity')
                    ->limit(5)
                    ->get();
                // Truyền dữ liệu ngày tháng năm đã chọn vào View
                $selectedDates = [
                    'start_datee' => $parsedStartDate->format('d/m/Y'),
                    'end_datee' => $parsedEndDate->format('d/m/Y'),
                ];
            }
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            // In ra thông báo lỗi để kiểm tra
            dd($e->getMessage());
        }

        //Top 5 khách hàng đặt hàng nhiều nhất trong tháng
        $userdStartDate = $request->filled('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : '';
        $userdEndDate = $request->filled('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : '';

        try {
            if (is_null($userdStartDate) || is_null($userdStartDate)) {
                $topUser = '';

            } else {
                // Chuyển đổi ngày bắt đầu và kết thúc thành đối tượng Carbon
                $parsedStartDatee = Carbon::parse($userdStartDate)->startOfDay();
                $parsedEndDatee = Carbon::parse($userdEndDate)->endOfDay();

                $topUser = DB::table('orders')
                    ->select('users.id', 'users.name', 'users.email', DB::raw('SUM(order_details.book_quantity) as total_books_ordered'))
                    ->join('users', 'orders.id_customer', '=', 'users.id')
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->whereBetween('orders.created_at', [$parsedStartDatee, $parsedEndDatee])
                    ->where(function ($query) {
                        $query->where('orders.status', 'Giao hàng thành công')
                            ->orWhere('orders.payment', 'Đã Thanh Toán VNPAY');
                    })
                    ->whereNotIn('orders.status', ['Hủy đơn hàng'])
                    ->groupBy('users.id', 'users.name', 'users.email')
                    ->orderByDesc('total_books_ordered')
                    ->limit(5)
                    ->get();
                $selectedDatess = [
                    'start_date' => $parsedStartDatee->format('d/m/Y'),
                    'end_date' => $parsedEndDatee->format('d/m/Y'),
                ];
            }
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            // In ra thông báo lỗi để kiểm tra
            dd($e->getMessage());
        }

        $revenueByPublisher = Publisher::select('publisher.name as publisher_name', 'publisher.id as id_publisher', DB::raw('SUM(IFNULL(books.sold_quantity, 0) * books.price) as total_revenue'))
            ->leftJoin('books', 'publisher.id', '=', 'books.id_publisher')
            ->groupBy('publisher.id', 'publisher.name')
            ->orderByDesc('total_revenue')
            ->limit(5)->get();
        return view('admin.dashboard.topuser', compact('selectedDatesst', 'selectedDatess', 'selectedDates', 'revenueByPublisher', 'topUser', 'result', 'books', 'totalRevenuees', 'order', 'review', 'user', 'processOrders'), ['dailyRevenue' => $dailyRevenue]);
    }

    
    

}
