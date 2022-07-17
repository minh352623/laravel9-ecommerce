@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Cập nhật người dùng</h1>
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
                <label for="">Họ Tên</label>
                <input value="{{old('name') ?? $user->name}}" name="name" type="text" class="form-control" placeholder="Họ Tên...">
                @error('name')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="mb-4">
                <label for="">Email</label>
                <input name="email" value="{{old('email') ?? $user->email}}" type="text" class="form-control" placeholder="Email...">
                @error('email')
                <span class="text-danger mt-2">{{$message}}</span>
            @enderror
            </div>

        </div>
        <div class="col-12">
            <div class="mb-4">
                <label for="">Mật khẩu</label>
                <input type="password" name="password" class="form-control" placeholder="Nếu không nhập, mật khẩu sẽ được giữ nguyên...">
                @error('password')
                <span class="text-danger mt-2">{{$message}}</span>
            @enderror
            </div>

        </div>
        <div class="col-12">
            <div class="mb-4">
                <label for="">Chọn nhóm</label>
                <select name="group_id" class="form-control">
                    <option value="0">Chọn nhóm</option>
                    @if ($groups->count()>0)
                        @foreach ($groups as $item)
                            <option value="{{$item->id}}" {{(old('group_id') == $item->id || $user->group_id == $item->id)?'selected':false}}>{{$item->name}}</option>
                        @endforeach
                    @endif
                </select>
                @error('group_id')
                <span class="text-danger mt-2">{{$message}}</span>
            @enderror
            </div>

        </div>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{route('admin.users.index')}}" class="btn btn-warning">Danh sách người dùng</a>

    @csrf
</form>
@endsection