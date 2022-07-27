<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    //

    const PER_PAGE = 6;
    //
    public function index()
    {
        $lists = Settings::orderBy('created_at', 'desc')->paginate(self::PER_PAGE);
        return view('admin.setting.lists', compact('lists'));
    }
    public function add()
    {
        return view('admin.setting.add');
    }
    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'config_key' => 'required|unique:settings,config_key',
                'config_value' => 'required',

            ],
            [
                'config_key.required' => 'Cấu hình tên không được để trống !',
                'config_key.unique' => 'Cấu hình tên đã có trong hệ thống, Vui lòng chọn tên khác !',

                'config_value.required' => 'Cấu hình giá trị không được để trống!',


            ]
        );
        //nếu validate thành công

        $setting = new Settings();
        $setting->config_key = $request->config_key;
        $setting->config_value = $request->config_value;
        $setting->type = $request->type;

        $setting->save();

        return redirect()->route('admin.setting.index')->with('msg', 'Thêm cấu hình thành công !');
    }


    public function edit(Settings $setting)
    {

        return view('admin.setting.edit', compact('setting'));
    }

    public function postEdit(Settings $setting, Request $request)
    {
        $request->validate(
            [
                'config_key' => 'required|unique:settings,config_key,' . $setting->id,
                'config_value' => 'required',

            ],
            [
                'config_key.required' => 'Cấu hình tên không được để trống !',
                'config_key.unique' => 'Cấu hình tên đã có trong hệ thống, Vui lòng chọn tên khác !',

                'config_value.required' => 'Cấu hình giá trị không được để trống!',


            ]
        );

        //nếu validate thành công
        $setting->config_key = $request->config_key;
        $setting->config_value = $request->config_value;
        $setting->type = $request->type;

        $setting->save();

        return redirect()->route('admin.setting.index')->with('msg', 'Cập nhật cấu hình thành công !');
    }

    public function delete(Settings $setting)
    {

        try {
            Settings::destroy($setting->id);
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

    public function trash()
    {
        $lists = Settings::onlyTrashed()->paginate(self::PER_PAGE);
        // dd($lists);
        return view('admin.setting.trash', compact('lists'));
    }


    public function restore($id)
    {
        // onlyTrashed cchỉ lấy ra những bản ghi đã bị xóa mềm
        // Category::withTrashed()->where('id', $id)->restore(); //cách 1 
        $menu = Settings::onlyTrashed()->where('id', $id)->first(); //cách 2
        if (!empty($menu)) {
            $menu->restore();
            return redirect()->route('admin.setting.index')->with('msg', 'Khôi phục cài đặt thành công!')->with('type', 'success');
        }
        return redirect()->route('admin.setting.index')->with('msg', 'Không thể khôi phục cài đặt lúc này. Vui lòng thử lại!')->with('type', 'danger');
    }


    public function forceDelete($id)
    {
        $menu = Settings::onlyTrashed()->where('id', $id)->first(); //cách 2
        if (!empty($menu)) {
            $menu->forceDelete();
            return redirect()->route('admin.setting.index')->with('msg', 'Xóa cài đặt vĩnh viễn thành công!')->with('type', 'success');
        }
        return redirect()->route('admin.setting.index')->with('msg', 'Cài đặt không tồn tại. Vui lòng thử lại!')->with('type', 'danger');
    }
}
