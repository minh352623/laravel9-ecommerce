<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommentAdminController extends Controller
{
    //
    const PER_PAGE = 6;
    public function index(Request $request)
    {

        if (!empty($request->keyword)) {
            $keyword = $request->keyword;
            $comments = DB::table('comments')
                ->select('comments.*', 'users.name as name_user', 'users.email as email_user', 'products.name as name_product')
                ->join('users', 'users.id', '=', 'comments.user_id')->join('products', 'products.id', '=', 'comments.product_id');
            $comments = $comments->where(function ($query) use ($keyword) {
                $query->orWhere('users.email', 'like', '%' . $keyword . '%');
                $query->orWhere('users.name', 'like', '%' . $keyword . '%');
            });
            $comments = $comments->paginate(self::PER_PAGE);
            // dd($comments);
        } else {

            $comments = Comments::paginate(self::PER_PAGE);
            // dd($comments);
        }
        return view('admin.comments.lists', compact('comments'));
    }

    function delete($id)
    {
        try {
            Comments::destroy($id);
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }
    }
}
