<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //

    public function add(Request $request)
    {
        $comment = new Comments();
        $comment->user_id = Auth::user()->id;
        $comment->product_id = $request->productId;
        $comment->message = $request->message;
        $comment->rating = $request->rating;

        $comment->save();

        $comments = Comments::where('product_id', $request->productId)->orderBy('created_at', 'desc')->get();
        if ($comments->count() > 0) {
            foreach ($comments as $comment) {
                $comment->name_user = $comment->user->name;
                $comment->avatar = $comment->user->image;
                $comment->created_at = date($comment->created_at);
            }
        }
        return response()->json($comments);
    }
}
