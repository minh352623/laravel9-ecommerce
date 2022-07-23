@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm Danh Mục</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger">Vui lòng kiểm tra dữ liệu nhập vào</div>
@endif
@if (session('msg'))
<div class="alert alert-success">{{session('msg')}}</div>
    
@endif
<form action="" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <label for="">Tên danh mục</label>
                <input value="{{old('name')}}" name="name" type="text" class="form-control" placeholder="Tên danh mục...">
                @error('name')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="">Chọn danh mục cha</label>
                <select class="form-control" name=parent_id>
                    <option value="0">Chọn danh mục cha</option>
                    {!!($htmlOption)!!}
                </select>
                @error('parent_id')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
             <div class="mb-4">
                <label for="">Ảnh đại diện</label>
                <input value="{{old('image')}}" name="image"   type="file" class="form-control-file @error('image') is-invalid @enderror">
                @error('image')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Thêm mới</button>
    <a href="{{route('admin.category.index')}}" class="btn btn-warning">Danh sách danh mục</a>
    @csrf
</form>
@endsection