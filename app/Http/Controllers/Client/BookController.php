<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Evaluate;
use App\Models\Publisher;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function show(Request $request)
    {
        $data = Book::query();
        if ($request->fillter == 0) {
            $data = Book::query();
        } else if ($request->fillter == 1) {
            $data = Book::orderBy('id', 'DESC');
        } else if ($request->fillter == 2) {
            $data = Book::orderByRaw('CAST(price AS DECIMAL(15, 2)) ASC');
        } else if ($request->fillter == 3) {
            $data = Book::orderByRaw('CAST(price AS DECIMAL(15, 2)) DESC');
        }
        $datas = $data->paginate(12);
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();
        $categoryCounts = [];
        $authCounts = [];
        $publisherCounts = [];
        
        foreach ($cate as $category) {
            $productCount = Book::where('id_cate', $category->id)->count();
            $categoryCounts[$category->id] = $productCount;
        }
        foreach ($auth as $author) {
            $productCount = Book::where('id_author', $author->id)->count();
            $authCounts[$author->id] = $productCount;
        }
        foreach ($publishers as $au) {
            $productCount = Book::where('id_publisher', $au->id)->count();
            $publisherCounts[$au->id] = $productCount;
        }
        return view("client.books.books", compact('publisherCounts','publishers','datas', 'auth', 'cate', 'categoryCounts', 'authCounts'));
    }
    public function index()
    {
        $datas = Book::orderBy('id', 'DESC')->paginate(12);
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();
        $categoryCounts = [];
        foreach ($cate as $category) {
            $productCount = Book::where('id_cate', $category->id)->count();
            $categoryCounts[$category->id] = $productCount;
        }
        foreach ($auth as $author) {
            $productCount = Book::where('id_author', $author->id)->count();
            $authCounts[$author->id] = $productCount;
        }
        return view("layout.header", compact('publishers','datas', 'auth', 'cate', 'categoryCounts', 'authCounts'));
    }

    public function detailBook(string $id)
    {
        $detail = Book::find($id);
        if (!$detail) {
            abort(404);
        }
        $cate = Category::all();
        $auth = Author::all();
        $data = Book::find($id);
        $publishers = Publisher::all();
        $auths = Author::where('id', $data->id_author)->first();
        $cates = Category::where('id', $data->id_cate)->first();
        $publis = Publisher::where('id', $data->id_publisher)->first();
        $image = DB::table('image_details')->select('*')->where('id_book', $id)->get();
        $comment = Review::with('user')->where('id_book', $id)->get();
        $evaluate = Evaluate::with('user')->where('book_id', $id)->get();
        $user = User::all();
        $averageRating = number_format(Evaluate::where('book_id', $id)->avg('rating'), 1);
        $numberOfRatings = Evaluate::where('book_id', $id)->count();
        $numberOfReviews = Review::where('id_book', $id)->count();
        $same = DB::table('books')->select('*')->where('id_cate', $data->id_cate)->where('id', '!=', $data->id)->get();
        $upsells = DB::table('books')->select('*')->orderBy('sold_quantity', 'desc')->limit(5)->get();
        return view("client.books.detail", ["publishers" => $publishers,"numberOfReviews" => $numberOfReviews,"numberOfRatings" => $numberOfRatings,"publis" => $publis,"averageRating" => $averageRating,"evaluate" => $evaluate,"cates" => $cates, "auths" => $auths, "cate" => $cate, "auth" => $auth, "book" => $data, "image" => $image, "same" => $same, "comment" => $comment, "user" => $user, "upsells" => $upsells]);
    }
    public function filter(Request $request)
    {
        $fillter = $request->fillter;
        $bookQuery = Book::paginate(12);
        // Lọc theo trạng thái đơn hàng
        if ($fillter == '0') {
            $bookQuery = Book::paginate(12);
        }
        if ($fillter == '1') {
            $bookQuery = Book::orderBy('id', 'DESC')->paginate(12);
        }
        if ($fillter == '2') {
            $bookQuery = Book::orderBy('price', 'ASC')->paginate(12);
        }
        if ($fillter == '3') {
            $bookQuery = Book::orderBy('price', 'DESC')->paginate(12);
        }
        $datas = $bookQuery;
        $cate = Category::all();
        $auth = Author::all();

        $categoryCounts = [];
        foreach ($cate as $category) {
            $productCount = Book::where('id_cate', $category->id)->count();
            $categoryCounts[$category->id] = $productCount;
        }
        foreach ($auth as $author) {
            $productCount = Book::where('id_author', $author->id)->count();
            $authCounts[$author->id] = $productCount;
        }
        return view("client.books.books", compact('datas', 'auth', 'cate', 'categoryCounts', 'authCounts'));
    }
    public function viewcategory(Request $request, $slug)
    {
        if (Category::where('slug', $slug)->exists()) {
            $auth = Author::all();
            $cate = Category::all();
            $publishers = Publisher::all();
            $category = Category::where('slug', $slug)->first();
            $product1 = Book::where('id_cate', $category->id)->get();
            $products = Book::where('id_cate', $category->id)->paginate(12);
            $fillter = $request->input('fillter');
            if ($fillter == '0') {
                $products = Book::where('id_cate', $category->id)->paginate(12);
            } else if ($fillter == '1') {
                $products = Book::where('id_cate', $category->id)->orderBy('id', 'DESC')->paginate(12);
            } else if ($fillter == '2') {
                $products = Book::where('id_cate', $category->id)->orderBy('price', 'ASC')->paginate(12);
            } else if ($fillter == '3') {
                $products = Book::where('id_cate', $category->id)->orderBy('price', 'DESC')->paginate(12);
            }
            // Tính toán số lượng sản phẩm cho mỗi category
            $categoryCounts = [];
            foreach ($cate as $cat) {
                $productCount = Book::where('id_cate', $cat->id)->count();
                $categoryCounts[$cat->id] = $productCount;
            }
            $authorCounts = [];
            foreach ($auth as $au) {
                $productCount = Book::where('id_author', $au->id)->count();
                $authorCounts[$au->id] = $productCount;
            }
            $publisherCounts = [];
            foreach ($publishers as $au) {
                $productCount = Book::where('id_publisher', $au->id)->count();
                $publisherCounts[$au->id] = $productCount;
            }

            return view('client.books.filter', compact('publisherCounts','publishers','cate', 'products', 'product1', 'auth', 'categoryCounts', 'authorCounts'));
        } else {
            // Handle invalid slug
            return redirect('/')->with('status', "Slug does not exist");
        }
    }
    public function viewauth($slug)
    {
        if (Author::where('slug', $slug)->exists()) {

            $cate = Category::all();
            $auth = Author::all();
            $publishers = Publisher::all();
            $author = Author::where('slug', $slug)->first();
            $product1 = Book::where('id_cate', $author->id)->get();
            $products = Book::where('id_author', $author->id)->paginate(12);
            // Tính toán số lượng sản phẩm cho mỗi category
            $categoryCounts = [];
            foreach ($cate as $cat) {
                $productCount = Book::where('id_cate', $cat->id)->count();
                $categoryCounts[$cat->id] = $productCount;
            }
            // Tính toán số lượng sản phẩm cho mỗi author
            $authorCounts = [];
            foreach ($auth as $au) {
                $productCount = Book::where('id_author', $au->id)->count();
                $authorCounts[$au->id] = $productCount;
            }
            $publisherCounts = [];
            foreach ($publishers as $au) {
                $productCount = Book::where('id_publisher', $au->id)->count();
                $publisherCounts[$au->id] = $productCount;
            }

            return view('client.books.filter', compact('publisherCounts','publishers','cate', 'products', 'product1', 'auth', 'categoryCounts', 'authorCounts'));
        } else {
            // Handle invalid slug
            return redirect('/')->with('status', "Slug does not exist");
        }
    }

    public function viewpublisher($id)
    {
        if (Publisher::where('id', $id)->exists()) {

            $cate = Category::all();
            $auth = Author::all();
            $publishers = Publisher::all();
            $publisherss = Publisher::where('id', $id)->first();
            $product1 = Book::where('id_publisher', $publisherss->id)->get();
            $products = Book::where('id_publisher', $publisherss->id)->paginate(12);
            // Tính toán số lượng sản phẩm cho mỗi category
            $categoryCounts = [];
            foreach ($cate as $cat) {
                $productCount = Book::where('id_cate', $cat->id)->count();
                $categoryCounts[$cat->id] = $productCount;
            }
            // Tính toán số lượng sản phẩm cho mỗi author
            $authorCounts = [];
            foreach ($auth as $au) {
                $productCount = Book::where('id_author', $au->id)->count();
                $authorCounts[$au->id] = $productCount;
            }
            $publisherCounts = [];
            foreach ($publishers as $au) {
                $productCount = Book::where('id_publisher', $au->id)->count();
                $publisherCounts[$au->id] = $productCount;
            }

            return view('client.books.filter', compact('publisherCounts','publishers','cate', 'products', 'product1', 'auth', 'categoryCounts', 'authorCounts'));
        } else {
            // Handle invalid slug
            return redirect('/')->with('status', "Slug does not exist");
        }
    }

   
}