@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sửa Menu</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger">Vui lòng kiểm tra dữ liệu nhập vào</div>
@endif
@if (session('msg'))
<div class="alert alert-success">{{session('msg')}}</div>
    
@endif
<form action="" method="POST">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <label for="">Tên menu</label>
                <input value="{{old('name') ?? $menu->name}}" name="name" type="text" class="form-control" placeholder="Tên menu...">
                @error('name')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="">Chọn menu cha</label>
                <select class="form-control" name=parent_id>
                    <option value="0">Chọn menu cha</option>
                    {!!($optionSelect)!!}
                </select>
                @error('parent_id')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Thêm mới</button>
    <a href="{{route('admin.menu.index')}}" class="btn btn-warning">Danh sách menu</a>
    @csrf
</form>
@endsection