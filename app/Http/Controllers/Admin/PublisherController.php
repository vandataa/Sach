<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Publisher;
use App\Models\Book;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;
class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publishers = Publisher::withTrashed('id', 'DESC')->search()->paginate(10);

        $authCounts = [];

        foreach ($publishers as $publisher) {
            $productCount = Book::where('id_publisher', $publisher->id)->count();
            $authCounts[$publisher->id] = $productCount;
        }

        return view('admin.publisher.list', compact('publishers', 'authCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            "admin.publisher.add"
        );
    }

    public function add(Request $request)
    {

        if ($request->isMethod('post')) {

            $publisher = new Publisher();
            $publisher->name = $request->name;
            $publisher->slug = $request->slug;


            $publisher->save();
            //tạo thông báo


            if ($publisher->save()) {
                $newData = [
                    'Id' => $publisher->id,
                    'Tên NXB' => $publisher->name,
                ];
                Activity::create([
                    'description' => 'Thêm mới',
                    'subject_id' => $publisher->id,
                    'subject_type' => Publisher::class,
                    'causer_id' => auth()->id(),
                    'causer_type' => User::class,
                    'new_data' => json_encode($newData),
                ]);
                session::flash('success', 'Thêm tác giả thành công');
                return redirect()->route('publisher.list');
            } else {
                session::flash('error', 'Lỗi thêm tác giả');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public static function getListPublisher()
    {
        return $publisher = Publisher::orderBy('id', 'asc')
            ->select('id', 'name')
            ->get();
    }

    public function update(Request $request, string $id)
    {
        $publishers = Publisher::findOrFail($id);
        return view('admin.publisher.edit', compact('publishers'));
    }

    public function edit(Request $request, string $id)
    {
        $publisher = Publisher::find($id);
        $oldData = [
            'Id' => $publisher->id,
            'Tên NXB' => $publisher->name,
        ];
        $name = $request->input('name');
        $slug = $request->input('slug');
        $publisher->name = $name;
        $publisher->slug = $slug;
        $publisher->save();
        if ($publisher->save()) {
            $newData = [
                'Id' => $publisher->id,
                'Tên NXB' => $publisher->name,
            ];

            // Ghi log hoạt động ở đây
            if ($oldData !== $newData) {
                Activity::create([
                    'log_name' => 'default',
                    'description' => 'Cập nhật',
                    'subject_id' => $id,
                    'subject_type' => Publisher::class,
                    'causer_id' => auth()->id(),
                    'causer_type' => User::class,
                    'old_data' => json_encode($oldData),
                    'new_data' => json_encode($newData),
                ]);
            }
            return redirect()->route('publisher.list')
                ->with('success', 'Nhà xuất bản cập nhật thành công');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $publisher = Publisher::find($id);
        $publisher->delete();
        if ($publisher->delete()) {
            $oldData = [
                'Id' => $publisher->id,
                'Tên NXB' => $publisher->name,
            ];
            Activity::create([
                'description' => 'Xóa',
                'subject_id' => $publisher->id,
                'subject_type' => Publisher::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'old_data' => json_encode($oldData),
            ]);
            return redirect()->route('publisher.list')->with('success', 'Đã vô hiệu hóa nhà xuất bản');
        }

    }
    public function restore(string $id)
    {
        $authors = Publisher::withTrashed()->find($id);
        $authors->restore();
        if ($authors->restore()) {
            $oldData = [
                'Id' => $authors->id,
                'Tên' => $authors->name,
            ];
            Activity::create([
                'description' => 'Khôi phục',
                'subject_id' => $authors->id,
                'subject_type' => Publisher::class,
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
}