<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CateExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\History;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Exports\UsersExport;
use App\Models\Book;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::withTrashed('id', 'DESC')->search()->paginate(10);
        $books = Book::all();
        // $category = Category::all();
        return view("admin.category.list", compact("category", 'books'));
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
            'App\Models\Category' => 'Thể loại sách',
        ];
        $his = History::where('subject_type', Category::class,)->get();
        $users = User::all();
        $category = Category::withTrashed()->get();
        return view('admin.category.history', compact('his', 'category', 'users', 'event', 'subject_type'));
    }

    public function restore(string $id)
    {
        $category = Category::withTrashed()->find($id);
        $category->restore();
        if ($category->restore()) {
            $oldData = [
                'Id' => $category->id,
                'Tên' => $category->cate_Name,
            ];
            Activity::create([
                'description' => 'Khôi phục',
                'subject_id' => $category->id,
                'subject_type' => Category::class,
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
    public function create()
    {
        return view(
            "admin.category.create"
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

        $cate_Name = $request->input('cate_Name');
        $slug = $request->input('slug');
        $category = new Category;
        $category->cate_Name = $cate_Name;
        $category->slug = $slug;
        $category->save();
        if ($category->save()) {
            $newData  = [
                'Id' => $category->id,
                'Tên' => $category->cate_Name,
            ];
            Activity::create([
                'description' => 'Thêm mới',
                'subject_id' => $category->id,
                'subject_type' => Category::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'new_data' => json_encode($newData),
            ]);
            Session::flash('success', 'Thêm thành công');
            return redirect()->route('category.index');

        } else {
            Session::flash('error', 'Thêm Lỗi');
        }
    }
    public static function listCategories()
    {
        return $categories = Category::orderBy('id', 'asc')

            ->select('id', 'cate_name')
            ->get();
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public static function getSelect($id)
    {
        return CategoryController::selectCategories($id, CategoryController::listCategories());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view(
            "admin.category.edit",
            compact('category')
        );
    }
    //  HÀM ĐỆ QUY HIỂN THỊ CATEGORIES
    public static function selectCategories($id, $categories, $char = '|----', $tableStr = '')
    {

        foreach ($categories as $key => $item) {

            // Nếu là chuyên mục con thì hiển thị
            $tableStr .= "<option value='$item->id'>";
            $tableStr .= $char . $item->category_name;
            $tableStr .= '</option>';
            // Xóa chuyên mục đã lặp
            unset($categories[$key]);
            // echo $item->id;
            // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
            $tableStr = CategoryController::selectCategories($id, $categories, $item->id, $char . '|------', $tableStr);
        }

        return $tableStr;
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::find($id);
        $oldData  = [
            'Id' => $category->id,
            'Tên' => $category->cate_Name,
        ];
        $cate_Name = $request->input('cate_Name');
        $slug = $request->input('slug');
        $category->cate_Name = $cate_Name;
        $category->slug = $slug;
        $category->save();
        $update = $category->save();
        if ($update) {
            $newData = [
                'Id' => $category->id,
                'Tên' => $category->cate_Name,
            ];

            // Ghi log hoạt động ở đây
            if ($oldData !== $newData) {
                Activity::create([
                    'log_name' => 'default',
                    'description' => 'Cập nhật',
                    'subject_id' => $id,
                    'subject_type' => Category::class,
                    'causer_id' => auth()->id(),
                    'causer_type' => User::class,
                    'old_data' => json_encode($oldData),
                    'new_data' => json_encode($newData),
                ]);
            }
            return redirect()->route('category.index')
                ->with('success', 'Thể loại cập nhật thành công');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        if($category->delete()){
            $oldData  = [
                'Id' => $category->id,
                'Tên' => $category->cate_Name,
            ];
            Activity::create([
                'description' => 'Xóa',
                'subject_id' => $category->id,
                'subject_type' => Category::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'old_data' => json_encode($oldData),
            ]);
         return redirect()->route('category.index')->with('success', 'Đã vô hiệu hóa thể loại sách');
         }
        }
}
