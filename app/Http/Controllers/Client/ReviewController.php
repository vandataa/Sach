<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function postComment(Request $request,){

        if($request->isMethod('post')){
            $comment = new Review();
            $comment->content = $request->content;
            $comment->id_customer = Auth::id();
            $comment->id_book = $request->id_book;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extention = $file->getClientOriginalName();
                $filename = $extention;
                $file->move('storage/images/', $filename);
                $comment->image = $filename;
            }

            $comment->save();
        }
        return redirect()->back();
    }

    public function editComment(Request $request,$id)
    {
        $cm = Review::find($id);
        if($request->isMethod('post')){
            $cm->content = $request->content;
            $cm->id_customer = Auth::id();
            $cm->id_book = $request->id_book;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extention = $file->getClientOriginalName();
                $filename = $extention;
                $file->move('storage/hinh/', $filename);
                $cm->image = $filename;
            }

            $cm->update();
        }
        return redirect()->back();
    }

    public function deleteComment($id)
    {
        $cm = Review::find($id);
        $book = Book::find($cm->id_post);
        $user = User::find($cm->id_customer);
        if ($cm->id_customer != Auth::user()->id) {
            return abort(403);
        } else {
            $cm->delete();
            return redirect()->back();
        }
    }
}
