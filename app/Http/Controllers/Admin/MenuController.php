<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use  App\Components\MenuRecusive;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    //
    const PER_PAGE = 5;
    //
    private  $menuRecusive;
    public function __construct(MenuRecusive $menuRecusive)
    {
        $this->menuRecusive = $menuRecusive;
    }

    public function index()
    {
        $lists = Menu::orderBy('created_at', 'desc')->paginate(self::PER_PAGE);

        return view('admin.menus.lists', compact('lists'));
    }
    public function add()
    {
        $optionSelect = $this->menuRecusive->menuRecusiveAdd('');
        return view('admin.menus.add', compact('optionSelect'));
    }

    public function menuAdd(request $request)
    {

        $request->validate(
            [
                'name' => 'required|unique:menus,name'

            ],
            [
                'name.required' => 'Tên không được để trống !',
                'name.unique' => 'Tên menu đã có trong hệ thống. Vui lòng chọn tên khác!',


            ]
        );

        $menu = new Menu();
        $menu->name = $request->name;
        $menu->parent_id = $request->parent_id;
        $menu->slug = Str::of($request->name)->slug('-');
        $menu->save();

        return redirect()->route('admin.menu.index')->with('msg', 'Thêm menu thành công!');
    }

    public function edit(Menu $menu)
    {
        $optionSelect = $this->menuRecusive->menuRecusiveAdd($menu->parent_id);

        return view('admin.menus.edit', compact('menu', 'optionSelect'));
    }

    public function postEdit(Menu $menu, Request $request)
    {

        $request->validate(
            [
                'name' => 'required|unique:menus,name,' . $menu->id,

            ],
            [
                'name.required' => 'Tên không được để trống !',
                'name.unique' => 'Tên menu đã có trong hệ thống. Vui lòng chọn tên khác!',


            ]
        );



        //

        $menu->name = $request->name;
        $menu->parent_id = $request->parent_id;
        $menu->slug = Str::of($request->name)->slug('-');

        $menu->save();

        return back()->with('msg', 'Cập nhật nhóm người dùng thành công!');
    }
    public function delete(Menu $menu)
    {


        // $usersCount = $menu->users->count();
        // dd($usersCount);
        // if ($usersCount == 0) {

        // if (Auth::user()->id == $menu->user_id) {
        //thực hiện xóa
        Menu::destroy($menu->id);
        return redirect()->route('admin.menu.index')->with('msg', 'Xóa menu thành công!');
        // }
        // }

        // return redirect()->route('admin.groups.index')->with('msg', 'Bạn không thể xóa nhóm này, Trong nhóm vẫn còn ' . $usersCount . ' người dùng!');
    }


    public function trash()
    {
        $lists = Menu::onlyTrashed()->paginate(self::PER_PAGE);
        // dd($lists);
        return view('admin.menus.trash', compact('lists'));
    }



    public function restore($id)
    {
        // onlyTrashed cchỉ lấy ra những bản ghi đã bị xóa mềm
        // Category::withTrashed()->where('id', $id)->restore(); //cách 1 
        $menu = Menu::onlyTrashed()->where('id', $id)->first(); //cách 2
        if (!empty($menu)) {
            $menu->restore();
            return redirect()->route('admin.menu.index')->with('msg', 'Khôi phục menu thành công!')->with('type', 'success');
        }
        return redirect()->route('admin.menu.index')->with('msg', 'Không thể khôi phục menu lúc này. Vui lòng thử lại!')->with('type', 'danger');
    }


    public function forceDelete($id)
    {
        $menu = Menu::onlyTrashed()->where('id', $id)->first(); //cách 2
        if (!empty($menu)) {
            $menu->forceDelete();
            return redirect()->route('admin.menu.index')->with('msg', 'Xóa menu vĩnh viễn thành công!')->with('type', 'success');
        }
        return redirect()->route('admin.menu.index')->with('msg', 'Menu không tồn tại. Vui lòng thử lại!')->with('type', 'danger');
    }
}
