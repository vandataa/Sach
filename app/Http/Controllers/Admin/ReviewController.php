<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Author;
use App\Models\Book;
use App\Models\History;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;
class ReviewController extends Controller
{
    public function index()
    {
        $review =  Review::withTrashed('id', 'DESC')->search()->paginate(10);
        $user = User::all();
        $book = Book::all();
        return view('admin.review.list', compact('review', 'user', 'book'));
    }
    public function history()
    {
        $event = [
            'created' => 'Thêm mới',
            'updated' => 'Cập nhật',
            'deleted' => 'Ẩn',
            'restored'=> 'Hiện'
        ];
        $subject_type = [
            'App\Models\Review' => 'Bình Luận',
        ];
        $his = History::where('subject_type', Review::class,)->get();
        $users = User::all();
        $review = Review::withTrashed()->get();
        return view('admin.review.history',compact('his','review','users','event','subject_type'));
    }

    public function delete(string $id)
    {
        $comment = Review::find($id);
        $comment->delete();
        if ($comment) {
            $oldData = [
                'Id' => $comment->id,
                'Nội dung' => $comment->content,
                'Ảnh' => $comment->image,
                'Tài khoản' => $comment->user->username,
                'Sách' => $comment->book->title_book,
                'Ngày' => $comment->deleted_at,
            ];
            Activity::create([
                'description' => 'Xóa',
                'subject_id' => $comment->id,
                'subject_type' => Review::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'old_data' => json_encode($oldData),
            ]);
            Session::flash('success', 'Xóa thành công');
            return redirect()->route('review.index');
        } else {
            Session::flash('error', 'Xóa lỗi');
        }
    }

    public function restore(string $id)
    {
        $comment = Review::withTrashed()->find($id);
        $comment->restore();
        if ($comment) {
            $oldData = [
                'Id' => $comment->id,
                'Nội dung' => $comment->content,
                'Ảnh' => $comment->image,
                'Tài khoản' => $comment->user->username,
                'Sách' => $comment->book->title_book,
                'Ngày' => $comment->deleted_at,
            ];
            Activity::create([
                'description' => 'Khôi phục',
                'subject_id' => $comment->id,
                'subject_type' => Review::class,
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
