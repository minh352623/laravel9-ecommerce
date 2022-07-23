<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    const PER_PAGE = 5;
    //
    public function index()
    {
        $lists = Posts::orderBy('created_at', 'desc')->paginate(self::PER_PAGE);
        return view('admin.posts.lists', compact('lists'));
    }
    public function add()
    {
        return view('admin.posts.add');
    }
    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',

            ],
            [
                'title.required' => 'Tiêu đề không được để trống !',
                'content.required' => 'Nội dung không được để trống!',


            ]
        );
        //nếu validate thành công

        $posts = new Posts();
        $posts->title = $request->title;
        $posts->content = $request->content;

        $posts->user_id = Auth::user()->id;
        $posts->save();

        return redirect()->route('admin.posts.index')->with('msg', 'Thêm bài viết thành công thành công!');
    }

    public function edit(Posts $post)
    {
        $this->authorize('update', $post);

        return view('admin.posts.edit', compact('post'));
    }
    public function postEdit(Posts $post, Request $request)
    {

        $this->authorize('update', $post);

        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',

            ],
            [
                'title.required' => 'Tiêu đề không được để trống !',
                'content.required' => 'Nội dung không được để trống!',


            ]
        );
        //nếu validate thành công

        $post->title = $request->title;
        $post->content = $request->content;

        $post->save();

        return redirect()->route('admin.posts.index')->with('msg', 'Sửa bài viết thành công thành công!');
    }

    public function delete(Posts $post)
    {
        $this->authorize('delete', $post);

        $post->destroy($post->id);

        return redirect()->route('admin.posts.index')->with('msg', 'Xóa bài viết thành công!');
    }
}
