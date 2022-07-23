@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sửa cài đặt</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger">Vui lòng kiểm tra dữ liệu nhập vào</div>
@endif
<form action="" method="POST">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <label for="">Cấu hình tên</label>
                <input value="{{old('config_key') ?? $setting->config_key}}" name="config_key" type="text" class="form-control @error('config_key') is-invalid @enderror" placeholder="Nhập tên cấu hình...">
                @error('config_key')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
        </div>
        @if ( $setting->type === 'text')
        <div class="col-12">
            <div class="mb-4">
                <label for="">Cấu hình giá trị</label>
                <input value="{{old('config_value') ?? $setting->config_value}}" name="config_value" type="text" class="form-control @error('config_value') is-invalid @enderror" placeholder="Nhập giá trị cấu hình...">
                @error('config_value')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
        </div>
        @elseif( $setting->type === 'textarea')
        <div class="col-12">
            <div class="mb-4">
                <label for="">Cấu hình giá trị</label>
                <textarea  name="config_value" rows="5" type="text" class="form-control" placeholder="Nhập giá trị cấu hình...">{{old('config_value') ?? $setting->config_value}}</textarea>
                @error('config_value')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
        </div>
        @endif
     
       
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{route('admin.setting.index')}}" class="btn btn-warning">Danh sách cài đặt</a>
    @csrf
</form>
@endsection