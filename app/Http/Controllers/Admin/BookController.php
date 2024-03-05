<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Imports\BookImport;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\History;
use App\Models\Image_Detail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Hub;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::withTrashed('id', 'DESC')->search()->paginate(10);
        $category = Category::get();
        return view("admin.books.list", compact("books", "category"));
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
            'App\Models\Book' => 'Sách',
        ];
        $his = History::where('subject_type', Book::class, )->get();
        $users = User::all();
        $book = Book::withTrashed()->get();
        return view('admin.books.history', compact('his', 'book', 'users', 'event', 'subject_type'));
    }

    public function restore(string $id)
    {
        $book = Book::withTrashed()->find($id);
        $book->restore();
        if ( $book->restore()) {
            $oldData = [
                'Id' => $book->id,
                'Tiêu đề' => $book->title_book,
                'Giá gốc' => $book->original_price,
                'Giá bán' => $book->price,
                'Ảnh' => $book->book_image,
                'Mô tả' => $book->description,
                'Số lượng' => $book->quantity,
                'Tác giả' => $book->id_author,
                'Thể loại' => $book->id_cate,
                'NXB' => $book->id_publisher,

            ];
            Activity::create([
                'description' =>'Khôi phục',
                'subject_id' => $book->id,
                'subject_type' => Author::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'old_data' => json_encode($oldData),
            ]);
            Session::flash('success', 'Khôi phục thành công');
            return redirect()->back();
        } else {
            Session::flash('error', 'Khôi phục lỗi');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function filter(Request $request)
    {
        $status = $request->input('status');
        $searchInput = $request->input('searchInput');
        $category = $request->input('id_cate');
        $booksQuery = Book::query();

        // Lọc theo trạng thái
        if ($status) {
            if ($status == 'Còn hàng') {
                $booksQuery->where('quantity', '>', 0);
            } elseif ($status == 'Hết hàng') {
                $booksQuery->where('quantity', 0);
            }
        }
        // Tìm theo tên sách
        if ($searchInput) {
            $booksQuery->where('title_book', 'like', '%' . $searchInput . '%');
        }
        if ($category) {
            $booksQuery->where('id_cate', $category);
        }
        $books = $booksQuery->paginate(10);
        $category = Category::get();
        return view("admin.books.list", compact("books", "category"));
    }
    // public function filter2(Request $rq){
    //     if($rq->)
    // }

    public function create()
    {
        $listAuthor = $this->getAuthor();
        $listCate = $this->getListCate();
        $listPublisherr = $this->getListPublishers();
        return view(
            "admin.books.create",
            [
                'listCate' => $listCate,
                'listAuthor' => $listAuthor,
                'listPublishers' => $listPublisherr,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $title_book = $request->input('title_book');
        $original_price = $request->input('original_price');
        $price = $request->input('price');
        $description = $request->input('description');
        $quantity = $request->input('quantity');
        $id_author = $request->input('id_author');
        $id_cate = $request->input('id_cate');
        $id_publisher = $request->input('id_publisher');

        if ($request->file('book_image')) {
            $book_image = $request->file('book_image')->getClientOriginalName(); // lấy tên file
            $path = $request->file('book_image')->storeAs('public/images', $book_image); // lưu file vào đường dẫn
        }
        $book = new Book;
        $book->title_book = $title_book;
        $book->original_price = $original_price;
        $book->price = $price;
        $book->description = $description;
        $book->id_author = $id_author;
        $book->id_cate = $id_cate;
        $book->quantity = $quantity;
        $book->book_image = $book_image;
        $book->id_publisher = $id_publisher;
        $book->save();
        // thêm nhiều ảnh
        $image_path = array();
        foreach ($request->image_detail as $value) {
            $imageName = $value->getClientOriginalName();
            $path = $value->storeAs('public/images', $imageName);
            $image_path[] = $imageName;
            $image_detail = new Image_Detail;
            $image_detail->image_path = $imageName;
            $image_detail->id_book = $book->id;
            $image_detail->save();
        }
        if ($book->save()) {
            $newData = [
                'Id' => $book->id,
                'Tiêu đề' => $book->title_book,
                'Giá gốc' => $book->original_price,
                'Giá bán' => $book->price,
                'Ảnh' => $book->book_image,
                'Mô tả' => $book->description,
                'Số lượng' => $book->quantity,
                'Tác giả' => $book->author->name_author, // Sử dụng relationship trong mô hình Book
                'Thể loại' => $book->category->cate_Name, // Sử dụng relationship trong mô hình Book
                'NXB' => $book->publisher->name,

            ];
            Activity::create([
                'description' => 'Thêm mới',
                'subject_id' => $book->id,
                'subject_type' => Book::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'new_data' => json_encode($newData),
            ]);
            Session::flash('success', 'Thâm thành công');
            return redirect()->route('book.index');
        } else {
            Session::flash('error', 'Thêm Lỗi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $listCate = Category::all();
        $listAuthor = Author::all();
        $listPublisherr = $this->getListPublishers();
        $listImage = DB::table('image_details')->select('*')->where('id_book', $book->id)->get();

        return view(
            "admin.books.edit",
            [
                'book' => $book,
                'listAuthor' => $listAuthor,
                'listCate' => $listCate,
                'listImage' => $listImage,
                'listPublishers' => $listPublisherr
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateBookRequest $request,string $id)
    {
        $book = Book::find($id);
        $oldData = [
            'Id' => $book->id,
            'Tiêu đề' => $book->title_book,
            'Giá gốc' => $book->original_price,
            'Giá bán' => $book->price,
            'Ảnh' => $book->book_image,
            'Mô tả' => $book->description,
            'Số lượng' => $book->quantity,
            'Tác giả' => $book->author->name_author,
            'Thể loại' => $book->category->cate_Name,
            'NXB' => $book->publisher->name,

        ];
        $title_book = $request->input('title_book');
        $original_price = $request->input('original_price');
        $price = $request->input('price');
        $description = $request->input('description');
        $quantity = $request->input('quantity');
        $publish_house = $request->input('publish_house');
        $id_author = $request->input('id_author');
        $id_cate = $request->input('id_cate');
        $id_publisher = $request->input('id_publisher');
        if ($request->file('book_image') != null) {
            $book_image = $request->file('book_image')->getClientOriginalName(); // lấy tên file
            $path = $request->file('book_image')->storeAs('public/images', $book_image); // lưu file vào đường dẫn
            $book->fill([
                'title_book' => $title_book,
                'original_price' => $original_price,
                'price' => $price,
                'description' => $description,
                'publish_house' => $publish_house,
                'book_image' => $book_image,
                'id_author' => $id_author,
                'id_cate' => $id_cate,
                'id_publisher' => $id_publisher,
            ])->save();
        } else {
            $book->fill([
                'title_book' => $title_book,
                'original_price' => $original_price,
                'price' => $price,
                'description' => $description,
                'publish_house' => $publish_house,
                'id_author' => $id_author,
                'id_cate' => $id_cate,
                'id_publisher' => $id_publisher,

            ])->save();
        }
        Book::where('id', $book->id)->update(['quantity' => $quantity,]);
        if($book->update()) {
            $newData = [
                'Id' => $book->id,
                'Tiêu đề' => $book->title_book,
                'Giá gốc' => $book->original_price,
                'Giá bán' => $book->price,
                'Ảnh' => $book->book_image,
                'Mô tả' => $book->description,
                'Số lượng' => $book->quantity,
                'Tác giả' => $book->author->name_author,
                'Thể loại' => $book->category->cate_Name,
                'NXB' => $book->publisher->name,
            ];

            // Ghi log hoạt động ở đây
            if ($oldData !== $newData) {
                Activity::create([
                    'log_name' => 'default',
                    'description' => 'Cập nhật',
                    'subject_id' => $id,
                    'subject_type' => Book::class,
                    'causer_id' => auth()->id(),
                    'causer_type' => User::class,
                    'old_data' => json_encode($oldData),
                    'new_data' => json_encode($newData),
                ]);
            }
        }
        return redirect()->route('book.index')->with('success', '');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id)
    {
        $book = Book::find($id);
        $book->delete();
        if ($book->delete()) {
            $oldData = [
                'Id' => $book->id,
                'Tiêu đề' => $book->title_book,
                'Giá gốc' => $book->original_price,
                'Giá bán' => $book->price,
                'Ảnh' => $book->book_image,
                'Mô tả' => $book->description,
                'Số lượng' => $book->quantity,
                'Tác giả' => $book->id_author,
                'Thể loại' => $book->id_cate,
                'NXB' => $book->id_publisher,

            ];
            Activity::create([
                'description' => 'Xóa',
                'subject_id' => $book->id,
                'subject_type' => Book::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'old_data' => json_encode($oldData),
            ]);
            Session::flash('success', 'Xóa thành công');
            return redirect()->back();
        } else {
            Session::flash('error', 'Xóa lỗi');
        }
    }
    public static function getAuthor()
    {
        return Author::getListAuthor();
    }
    public static function getListCate()
    {
        return CategoryController::listCategories();
    }
    public static function getListPublishers()
    {
        return PublisherController::getListPublisher();
    }
    public function changeList($id)
    {
        $image_detail = Image_Detail::where('id_book', $id)->get();
        return view('admin.books.changeList', ['image' => $image_detail, 'id' => $id]);
    }
    public function changeform(Request $request)
    {
        $id = $request->id;
        $list = DB::table('image_details')->select('*')->where('id', $id)->get();
        $book = DB::table('image_details')->select('id_book')->where('id', $id)->get(1);
        return view('admin.books.updateImage', ['list' => $list, 'book' => $book]);
    }
    public function changeImage(Request $request)
    {
        $id = $request->input('id');
        $image = $request->file('images')->getClientOriginalName();
        $request->file('images')->storeAs('public/images', $image);
        Image_Detail::where('id', $id)->update([
            'image_path' => $image
        ]);
        Storage::delete('storage/images/' . $image);
        $id_book = $request->input('id_book');
        return redirect()->route("book.changeList", $id_book);
    }
    public function addNewImage($id)
    {
        return view('admin.books.addNewImage', ['id' => $id]);
    }
    public function addImage(Request $request)
    {
        $image_path = array();
        foreach ($request->image_detail as $value) {
            $imageName = $value->getClientOriginalName();
            $path = $value->storeAs('public/images', $imageName);
            $image_path[] = $imageName;
            $image_detail = new Image_Detail;
            $image_detail->image_path = $imageName;
            $image_detail->id_book = $request->input('id_book');
            $image_detail->save();
        }
        return redirect()->route("book.edit", $request->input('id_book'));
    }

    public function deleteImage(Request $request, $id)
    {
        $id_image = $id;
        $image_detail = DB::table("image_details")->where("id", $id)->delete();
        $old_image = $request->input('old_image');
        Storage::delete('storage/images' . $old_image);
        return redirect()->back();
    }
    public function review($id)
    {
        $review = Book::find($id);
        $image = DB::table('image_details')->select('*')->where('id_book', $id)->get();
        return view('admin.books.review', ['review' => $review, 'image' => $image]);
    }
}