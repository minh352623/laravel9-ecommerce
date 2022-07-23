<?php

namespace App\Http\Controllers\Admin;

use App\Components\Recusive;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Products;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Traits\StorageImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    //
    use StorageImageTrait;
    const PER_PAGE = 3;

    public function index()
    {
        $lists = Products::orderBy('created_at', 'desc')->paginate(self::PER_PAGE);

        return view('admin.products.lists', compact('lists'));
    }
    public function add()
    {
        $htmlOption = $this->getCategory();

        return view('admin.products.add', compact('htmlOption'));
    }
    public function getCategory($idSelected = 0)
    {
        $data = Category::all();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive($idSelected, 0, '');
        return $htmlOption;
    }
    public function postAdd(Request $request)
    {
        // dd($data);

        $request->validate(
            [
                'name' => 'required|unique:products,name',
                'price' => 'required',
                'feature_image_path' => 'required',
                'image_path' => 'required',

                'tags' => ['required', function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Vui lòng chọn tag !');
                    }
                }],
                'content' => 'required',
                'category_id' => ['required', function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Vui lòng chọn danh mục !');
                    }
                }],

            ],
            [
                'name.required' => 'Tên không được để trống !',
                'name.unique' => 'Tên đã có trên hệ thống, Vui lòng chọn tên khác !',

                'price.required' => 'Giá không được để trống !',
                'feature_image_path.required' => 'Ảnh đại diện không được để trống !',
                'image_path.required' => 'Ảnh chi tiết không được để trống !',

                'tags.required' => 'Tag không được để trống !',
                'content.required' => 'Nội dung không được để trống !',
                'category_id.required' => 'Danh mục không được để trống !',


            ]
        );
        try {
            DB::beginTransaction();
            //code...



            //nếu validate thành công
            $dataImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');

            $product = new Products();
            $dataInsert = [

                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'user_id' => Auth::user()->id,
            ];

            if (!empty($dataImage)) {
                $dataInsert['feature_image_path'] = $dataImage['file_path'];
                $dataInsert['feature_image_name'] = $dataImage['file_name'];
            }
            $product = $product->create($dataInsert);

            //insert data to product_image
            if (!empty($request->hasFile('image_path'))) {
                foreach ($request->image_path as $fileName) {
                    $dataProductImageDetail = $this->storageTraitUploadMultiple($fileName, 'product');
                    $product->images()->create(
                        [
                            'image_path' => $dataProductImageDetail['file_path'],
                            'image_name' => $dataProductImageDetail['file_name'],

                        ]
                    );
                }
            }

            //insert tags
            $tagIds = [];
            if (!empty($request->tags)) {

                foreach ($request->tags as $tagItem) {
                    $tagInstance =  Tag::firstOrCreate([
                        'name' => $tagItem
                    ]);
                    //cachs 1
                    // ProductTag::create([
                    //     'product_id' => $product->id,
                    //     'tag_id' => $tagInstance->id
                    // ]);
                    //cách 2

                    $tagIds[] = $tagInstance->id;
                }
            }
            $product->tags()->attach($tagIds);

            // dd($status);
            DB::commit();
            return redirect()->route('admin.products.index')->with('msg', 'Thêm sản phẩm thành công!');
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }



    public function edit(Products $product)
    {
        // $this->authorize('edit', $product);

        $htmlOption = $this->getCategory($product->category_id);

        return view('admin.products.edit', compact('product', 'htmlOption'));
    }


    public function postEdit(Products $product, Request $request)
    {
        // $this->authorize('edit', $product);

        $request->validate(
            [
                'name' => 'required|unique:products,name,' . $product->id,
                'price' => 'required',

                'tags' => ['required', function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Vui lòng chọn tag !');
                    }
                }],
                'content' => 'required',
                'category_id' => ['required', function ($attribute, $value, $fail) {
                    if ($value == 0) {
                        $fail('Vui lòng chọn danh mục !');
                    }
                }],

            ],
            [
                'name.required' => 'Tên không được để trống !',
                'name.unique' => 'Tên đã có trên hệ thống, Vui lòng chọn tên khác !',

                'price.required' => 'Giá không được để trống !',

                'tags.required' => 'Tag không được để trống !',
                'content.required' => 'Nội dung không được để trống !',
                'category_id.required' => 'Danh mục không được để trống !',


            ]
        );
        try {
            DB::beginTransaction();
            //code...



            //nếu validate thành công
            $dataImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');

            // $product = new Products();
            $dataInsert = [

                'name' => $request->name,
                'price' => $request->price,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'user_id' => Auth::user()->id,
            ];

            if (!empty($dataImage)) {
                $dataInsert['feature_image_path'] = $dataImage['file_path'];
                $dataInsert['feature_image_name'] = $dataImage['file_name'];
            }
            $status = $product->update($dataInsert);

            //insert data to product_image
            if (!empty($request->hasFile('image_path'))) {
                $product->images()->where('product_id', $product->id)->delete();
                foreach ($request->image_path as $fileName) {
                    $dataProductImageDetail = $this->storageTraitUploadMultiple($fileName, 'product');
                    $product->images()->create(
                        [
                            'image_path' => $dataProductImageDetail['file_path'],
                            'image_name' => $dataProductImageDetail['file_name'],

                        ]
                    );
                }
            }

            //insert tags
            $tagIds = [];

            if (!empty($request->tags)) {

                foreach ($request->tags as $tagItem) {
                    $tagInstance =  Tag::firstOrCreate([
                        'name' => $tagItem
                    ]);
                    //cachs 1
                    // ProductTag::create([
                    //     'product_id' => $product->id,
                    //     'tag_id' => $tagInstance->id
                    // ]);
                    //cách 2

                    $tagIds[] = $tagInstance->id;
                }
            }
            $product->tags()->sync($tagIds); //nó sẽ check nếu id đã có r thì k thêm nữa k có thì insert

            // dd($status);
            DB::commit();
            return redirect()->route('admin.products.index')->with('msg', 'Sữa sản phẩm thành công!');
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }

    public function delete(Products $product)
    {
        // return redirect()->route('admin.products.index')->with('msg', 'Xóa sản phẩm thành công!');

        try {
            Products::destroy($product->id);
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
        $lists = Products::onlyTrashed()->paginate(self::PER_PAGE);
        // dd($lists);
        return view('admin.products.trash', compact('lists'));
    }

    public function restore($id)
    {
        // onlyTrashed cchỉ lấy ra những bản ghi đã bị xóa mềm
        // Category::withTrashed()->where('id', $id)->restore(); //cách 1 
        $menu = Products::onlyTrashed()->where('id', $id)->first(); //cách 2
        if (!empty($menu)) {
            $menu->restore();
            return redirect()->route('admin.products.index')->with('msg', 'Khôi phục sản phẩm thành công!')->with('type', 'success');
        }
        return redirect()->route('admin.products.index')->with('msg', 'Không thể khôi phục sản phẩm lúc này. Vui lòng thử lại!')->with('type', 'danger');
    }


    public function forceDelete($id)
    {
        $menu = Products::onlyTrashed()->where('id', $id)->first(); //cách 2
        if (!empty($menu)) {
            $menu->forceDelete();
            return redirect()->route('admin.products.index')->with('msg', 'Xóa sản phẩm vĩnh viễn thành công!')->with('type', 'success');
        }
        return redirect()->route('admin.products.index')->with('msg', 'Sản phẩm không tồn tại. Vui lòng thử lại!')->with('type', 'danger');
    }
}
