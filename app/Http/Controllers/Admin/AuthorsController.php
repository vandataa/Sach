<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UpdateAuth;
use App\Models\Author;
use App\Models\History;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;

class AuthorsController extends Controller
{
    //
    public function index()
    {
        $authors = Author::withTrashed('id', 'DESC')->search()->paginate(10);
        $authCounts = [];
        foreach ($authors as $author) {
            $productCount = Book::where('id_author', $author->id)->count();
            $authCounts[$author->id] = $productCount;
        }
        return view('admin.authors.list', compact('authors', 'authCounts'));
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
            'App\Models\Author' => 'Tác giả',
        ];
        $his = History::where('subject_type', Author::class,)->get();
        $users = User::all();
        $author = Author::withTrashed()->get();
        return view('admin.authors.history', compact('his', 'author', 'users', 'event', 'subject_type'));
    }
    public function create()
    {
        return view(
            "admin.authors.add"
        );
    }
    public function add(AuthRequest $request)
    {

        if ($request->isMethod('post')) {

            $authors = new Author();
            $authors->name_author = $request->name_author;
            $authors->slug = $request->slug;
            $authors->info = $request->info;

            if ($request->hasFile('author_image')) {
                $file = $request->file('author_image');
                $extention = $file->getClientOriginalName();
                $filename = $extention;
                $file->move('storage/images/', $filename);
                $authors->author_image = $filename;
            }
            $authors->save();
            //tạo thông báo


            if ($authors->save()) {
                $newData = [
                    'Id' => $authors->id,
                    'Tên' => $authors->name_author,
                    'Thông tin' => $authors->info,
                    'Ảnh' => $authors->author_image,
                ];
                Activity::create([
                    'description' => 'Thêm mới',
                    'subject_id' => $authors->id,
                    'subject_type' => Author::class,
                    'causer_id' => auth()->id(),
                    'causer_type' => User::class,
                    'new_data' => json_encode($newData),
                ]);
                session::flash('success', 'Thêm tác giả thành công');
                return redirect()->route('list.authors');

            } else {
                session::flash('error', 'Lỗi thêm tác giả');
            }
        }
    }
    public function update($id)
    {
        $authors = Author::findOrFail($id);
        return view('admin.authors.edit', compact('authors'));
    }
    public function edit(UpdateAuth $request, string $id)
    { {
            $authors = Author::find($id);
        $oldData = [
            'Id' => $authors->id,
            'Tên' => $authors->name_author,
            'Thông tin' => $authors->info,
            'Ảnh' => $authors->author_image,
        ];
            if ($request->isMethod('POST')) {
                $authors->name_author = $request->name_author;
                $authors->slug = $request->slug;
                $authors->info = $request->info;
                if ($request->hasFile('author_image')) {
                    $file = $request->file('author_image');
                    $extention = $file->getClientOriginalName();
                    $filename = $extention;
                    $file->move('storage/images/', $filename);
                    $authors->author_image = $filename;
                }
                $authors->update();
                if ($authors->update()){
                    $newData = [
                        'Id' => $authors->id,
                        'Tên' => $authors->name_author,
                        'Thông tin' => $authors->info,
                        'Ảnh' => $authors->author_image,
                    ];

                    // Ghi log hoạt động ở đây
                    if ($oldData !== $newData) {
                        Activity::create([
                            'log_name' => 'default',
                            'description' => 'Cập nhật',
                            'subject_id' => $id,
                            'subject_type' => Author::class,
                            'causer_id' => auth()->id(),
                            'causer_type' => User::class,
                            'old_data' => json_encode($oldData),
                            'new_data' => json_encode($newData),
                        ]);
                    }   Session::flash('success', 'Sửa thành công');
                    return redirect()->route('list.authors');
                } else {
                    Session::flash('error', 'Sửa lỗi');
                }
            }
        }
    }

    public function delete(string $id)
    {
        $authors = Author::find($id);
        $authors->delete();
        if ($authors->delete()) {
            $oldData = [
                'Id' => $authors->id,
                'Tên' => $authors->name_author,
                'Thông tin' => $authors->info,
                'Ảnh' => $authors->author_image,
            ];
            Activity::create([
                'description' => 'Xóa',
                'subject_id' => $authors->id,
                'subject_type' => Author::class,
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
    public function restore(string $id)
    {
        $authors = Author::withTrashed()->find($id);
        $authors->restore();
        if ($authors->restore()) {
            $oldData = [
                'Id' => $authors->id,
                'Tên' => $authors->name_author,
                'Thông tin' => $authors->info,
                'Ảnh' => $authors->author_image,
            ];
            Activity::create([
                'description' => 'Khôi phục',
                'subject_id' => $authors->id,
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
    public function detail($id)
    {
        $detail = Author::find($id);

        return view('admin.authors.detail', compact('detail'));
    }
}