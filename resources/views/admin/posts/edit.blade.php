@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sửa bài viết</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger">Vui lòng kiểm tra dữ liệu nhập vào</div>
@endif
<form action="" method="POST">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <label for="">Tiêu đề</label>
                <input value="{{old('title') ?? $post->title}}" name="title" type="text" class="form-control" placeholder="Tiêu đề...">
                @error('title')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="mb-4">
                <label for="">Nội dung</label>
                <textarea name="content" class="form-control" rows="8">{{old('content') ?? $post->content}}</textarea>
                @error('content')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{route('admin.posts.index')}}" class="btn btn-warning">Danh sách bài viết</a>
    @csrf
</form>
@endsection