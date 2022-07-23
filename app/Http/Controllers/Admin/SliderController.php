<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;

class SliderController extends Controller
{
    //
    use StorageImageTrait;
    const PER_PAGE = 5;

    public function index()
    {
        $lists = Slider::orderBy('created_at', 'desc')->paginate(self::PER_PAGE);

        return view('admin.slider.lists', compact('lists'));
    }
    public function add()
    {

        return view('admin.slider.add');
    }

    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:sliders,name',
                'description' => 'required',
                'image_path' => 'required',


            ],
            [
                'name.required' => 'Tên không được để trống !',
                'name.unique' => 'Tên đã có trên hệ thống, Vui lòng chọn tên khác !',

                'image_path.required' => 'Hình không được để trống !',
                'description.required' => 'Mô tả không được để trống !',




            ]
        );
        try {
            DB::beginTransaction();
            //code...
            //nếu validate thành công
            $dataImage = $this->storageTraitUpload($request, 'image_path', 'slider');
            // dd($dataImage);
            $slider = new Slider();
            $slider->name = $request->name;
            $slider->description = $request->description;

            if (!empty($dataImage)) {
                $slider->image_name = $dataImage['file_name'];
                $slider->image_path = $dataImage['file_path'];
            }
            $slider->save();
            // // dd($status);
            DB::commit();
            return redirect()->route('admin.slider.index')->with('msg', 'Thêm slider thành công!');
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }


    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    public function postEdit(Slider $slider, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:sliders,name,' . $slider->id,
                'description' => 'required',
                // 'image_path' => 'required',


            ],
            [
                'name.required' => 'Tên không được để trống !',
                'name.unique' => 'Tên đã có trên hệ thống, Vui lòng chọn tên khác !',

                // 'image_path.required' => 'Hình không được để trống !',
                'description.required' => 'Mô tả không được để trống !',




            ]
        );
        try {
            DB::beginTransaction();
            //code...
            //nếu validate thành công
            $dataImage = $this->storageTraitUpload($request, 'image_path', 'slider');
            // dd($dataImage);
            $slider->name = $request->name;
            $slider->description = $request->description;

            if (!empty($dataImage)) {
                $slider->image_name = $dataImage['file_name'];
                $slider->image_path = $dataImage['file_path'];
            }
            $slider->save();
            // // dd($status);
            DB::commit();
            return redirect()->route('admin.slider.index')->with('msg', 'Cập nhật slider thành công!');
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }



    public function delete(Slider $slider)
    {
        // return redirect()->route('admin.Slider.index')->with('msg', 'Xóa sản phẩm thành công!');

        try {
            Slider::destroy($slider->id);
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
        $lists = Slider::onlyTrashed()->paginate(self::PER_PAGE);
        // dd($lists);
        return view('admin.slider.trash', compact('lists'));
    }


    public function restore($id)
    {
        // onlyTrashed cchỉ lấy ra những bản ghi đã bị xóa mềm
        // Category::withTrashed()->where('id', $id)->restore(); //cách 1 
        $menu = Slider::onlyTrashed()->where('id', $id)->first(); //cách 2
        if (!empty($menu)) {
            $menu->restore();
            return redirect()->route('admin.slider.index')->with('msg', 'Khôi phục slider thành công!')->with('type', 'success');
        }
        return redirect()->route('admin.slider.index')->with('msg', 'Không thể khôi phục slider lúc này. Vui lòng thử lại!')->with('type', 'danger');
    }


    public function forceDelete($id)
    {
        $menu = Slider::onlyTrashed()->where('id', $id)->first(); //cách 2
        if (!empty($menu)) {
            $menu->forceDelete();
            return redirect()->route('admin.slider.index')->with('msg', 'Xóa slider vĩnh viễn thành công!')->with('type', 'success');
        }
        return redirect()->route('admin.slider.index')->with('msg', 'Slider không tồn tại. Vui lòng thử lại!')->with('type', 'danger');
    }
}
