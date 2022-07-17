<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Groups;
use App\Models\Modules;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    const PER_PAGE = 2;
    //
    public function index()
    {
        $lists = Groups::orderBy('created_at', 'desc')->paginate(self::PER_PAGE);

        return view('admin.groups.lists', compact('lists'));
    }
    public function add()
    {

        return view('admin.groups.add');
    }
    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:groups,name'

            ],
            [
                'name.required' => 'Tên không được để trống !',
                'name.unique' => 'Tên nhóm đã có trong hệ thống. Vui lòng chọn tên khác!',


            ]
        );
        //nếu validate thành công

        $group = new Groups();
        $group->name = $request->name;
        $group->user_id = Auth::user()->id;
        $group->save();

        return redirect()->route('admin.groups.index')->with('msg', 'Thêm nhóm người dùng thành công!');
    }

    public function edit(Groups $group)
    {
        $this->authorize('update', $group);

        return view('admin.groups.edit', compact('group'));
    }

    public function postEdit(Groups $group, Request $request)
    {
        $this->authorize('update', $group);

        $request->validate(
            [
                'name' => 'required|unique:groups,name,' . $group->id,

            ],
            [
                'name.required' => 'Tên không được để trống !',
                'name.unique' => 'Tên nhóm đã có trong hệ thống. Vui lòng chọn tên khác!',


            ]
        );



        //

        $group->name = $request->name;

        $group->save();

        return back()->with('msg', 'Cập nhật nhóm người dùng thành công!');
    }
    public function delete(Groups $group)
    {
        $this->authorize('delete', $group);

        //đếm số user có trong group, nếu không k còn user nào thì mới xóa dc.

        $usersCount = $group->users->count();
        // dd($usersCount);
        if ($usersCount == 0) {

            // if (Auth::user()->id == $group->user_id) {
            //thực hiện xóa
            Groups::destroy($group->id);
            return redirect()->route('admin.groups.index')->with('msg', 'Xóa nhóm người dùng thành công!');
            // }
        }

        return redirect()->route('admin.groups.index')->with('msg', 'Bạn không thể xóa nhóm này, Trong nhóm vẫn còn ' . $usersCount . ' người dùng!');
    }


    public function permissions(Groups $group)
    {
        $this->authorize('permissions', $group);

        $modules = Modules::all();
        // dd($group->permissions);
        $roleJson = $group->permissions;
        if (!empty($roleJson)) {
            $roleArr  = json_decode($roleJson, true);
        } else {
            $roleArr = [];
        }
        // dd($roleArr);
        $roleListArr = [
            'view' => 'Xem',
            'add' => 'Thêm',
            'edit' => 'Sửa',
            'delete' => 'Xóa'
        ];
        return view('admin.groups.permissions', compact('group', 'modules', 'roleListArr', 'roleArr'));
    }

    public function postPermissions(Groups $group, Request $request)
    {
        // dd($group);
        $this->authorize('permissions', $group);

        if (!empty($request->role)) {

            $roleArr = $request->role;
            // dd($roleArr);
        } else {
            $roleArr = [];
        }

        $roleJson = json_encode($roleArr);
        // dd($roleJson);
        $group->permissions = $roleJson;
        $group->save();

        return back()->with('msg', 'Phân quyền thành công!');
    }
}
