<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Components\Recusive;
use Illuminate\Support\Str;
use App\Traits\StorageImageTrait;

class CategoryController extends Controller
{
    //
    use StorageImageTrait;

    const PER_PAGE = 5;


    public function index()
    {
        $lists = Category::orderBy('created_at', 'desc')->paginate(self::PER_PAGE);
        return view('admin.category.lists', compact('lists'));
    }
    public function add()
    {
        $htmlOption = $this->getCategory();
        return view('admin.category.add', compact('htmlOption'));
    }
    public function categoryAdd(Request $request)
    {

        $request->validate(
            [
                'name' => 'required|unique:categories,name'

            ],
            [
                'name.required' => 'Tên không được để trống !',
                'name.unique' => 'Tên nhóm đã có trong hệ thống. Vui lòng chọn tên khác!',


            ]
        );
        $dataImage = $this->storageTraitUpload($request, 'image', 'product');

        $category = new Category();
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->slug = Str::of($request->name)->slug('-');
        if (!empty($dataImage)) {
            $category->image = $dataImage['file_path'];
        }
        // dd($request->all());
        $category->save();

        return redirect()->route('admin.category.index')->with('msg', 'Thêm danh mục thành công!');
    }
    public function getCategory($idSelected = 0)
    {
        $data = Category::all();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive($idSelected, 0, '');
        return $htmlOption;
    }

    public function edit(Category $category)
    {

        $htmlOption = $this->getCategory($category->parent_id);
        return view('admin.category.edit', compact('category', 'htmlOption'));
    }

    public function postEdit(Category $category, Request $request)
    {

        $request->validate(
            [
                'name' => 'required|unique:groups,name,' . $category->id,

            ],
            [
                'name.required' => 'Tên không được để trống !',
                'name.unique' => 'Tên nhóm đã có trong hệ thống. Vui lòng chọn tên khác!',


            ]
        );



        //
        $dataImage = $this->storageTraitUpload($request, 'image', 'product');
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->slug = Str::of($request->name)->slug('-');
        if (!empty($dataImage)) {
            $category->image = $dataImage['file_path'];
        }
        $category->save();

        return back()->with('msg', 'Cập nhật danh mục thành công!');
    }
    public function delete(Category $category)
    {

        //đếm số user có trong group, nếu không k còn user nào thì mới xóa dc.

        // $usersCount = $category->users->count();
        // dd($usersCount);
        // if ($usersCount == 0) {

        // if (Auth::user()->id == $group->user_id) {
        //thực hiện xóa
        Category::destroy($category->id);
        return redirect()->route('admin.category.index')->with('msg', 'Xóa danh mục thành công!');
        // }
        // }

        // return redirect()->route('admin.groups.index')->with('msg', 'Bạn không thể xóa nhóm này, Trong nhóm vẫn còn ' . $usersCount . ' người dùng!');
    }

    public function trash()
    {
        $lists = Category::onlyTrashed()->paginate(self::PER_PAGE);
        // dd($lists);
        return view('admin.category.trash', compact('lists'));
    }

    public function restore($id)
    {
        // onlyTrashed cchỉ lấy ra những bản ghi đã bị xóa mềm
        // Category::withTrashed()->where('id', $id)->restore(); //cách 1 
        $categoryNew = Category::onlyTrashed()->where('id', $id)->first(); //cách 2
        if (!empty($categoryNew)) {
            $categoryNew->restore();
            return redirect()->route('admin.category.index')->with('msg', 'Khôi phục danh mục thành công!')->with('type', 'success');
        }
        return redirect()->route('admin.category.index')->with('msg', 'Không thể khôi phục danh mục lúc này. Vui lòng thử lại!')->with('type', 'danger');
    }


    public function forceDelete($id)
    {
        $post = Category::onlyTrashed()->where('id', $id)->first(); //cách 2
        if (!empty($post)) {
            $post->forceDelete();
            return redirect()->route('admin.category.index')->with('msg', 'Xóa danh mục vĩnh viễn thành công!')->with('type', 'success');
        }
        return redirect()->route('admin.category.index')->with('msg', 'Danh mục không tồn tại. Vui lòng thử lại!')->with('type', 'danger');
    }
}
