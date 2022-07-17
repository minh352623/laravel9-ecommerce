<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Groups;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    //
    const PER_PAGE = 2;
    public function __construct()
    {
    }
    public function index()
    {
        $lists = User::paginate(self::PER_PAGE);

        return view('admin.users.lists', compact('lists'));
    }
    public function add()
    {
        $groups = Groups::all();

        return view('admin.users.add', compact('groups'));
    }

    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:5',
                'group_id' => ['required', function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Vui lòng chọn nhóm !');
                    }
                }],
            ],
            [
                'name.required' => 'Tên không được để trống !',
                'email.required' => 'Email không được để trống !',
                'email.email' => 'Email không đúng định dạng !',
                'email.unique' => 'Email đã có người sử dụng !',
                'password.required' => 'Mật khẩu không được để trống !',
                'password.min' => 'Mật khẩu phải lớn hơn :min kí tự !',

                'group_id.required' => 'Nhóm không được để trống !'

            ]
        );


        //nếu validate thành công

        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->group_id = $request->group_id;
        $user->user_id = Auth::user()->id;
        $user->save();

        return redirect()->route('admin.users.index')->with('msg', 'Thêm người dùng thành công!');
    }


    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $groups = Groups::all();
        return view('admin.users.edit', compact('groups', 'user'));
    }

    public function postEdit(User $user, Request $request)
    {
        $this->authorize('update', $user);

        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id, // email mail là duy nhất nhưng khác email của chính mình vì đang sữa
                'group_id' => ['required', function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Vui lòng chọn nhóm !');
                    }
                }],
            ],
            [
                'name.required' => 'Tên không được để trống !',
                'email.required' => 'Email không được để trống !',
                'email.email' => 'Email không đúng định dạng !',
                'email.unique' => 'Email đã có người sử dụng !',

                'group_id.required' => 'Nhóm không được để trống !'

            ]
        );



        //

        $user->name = $request->name;
        if (!empty($request->password)) {

            $user->password = Hash::make($request->password);
        }
        $user->email = $request->email;
        $user->group_id = $request->group_id;
        $user->user_id = Auth::user()->id;
        $user->save();

        return back()->with('msg', 'Cập nhật người dùng thành công!');
    }


    public function delete(User $user)
    {
        $this->authorize('delete', $user);

        if (Auth::user()->id != $user->id) {
            //thực hiện xóa
            User::destroy($user->id);
            return redirect()->route('admin.users.index')->with('msg', 'Xóa người dùng thành công!');
        }
        return redirect()->route('admin.users.index')->with('msg', 'Bạn không thể xóa tài khoản này!');
    }
}
