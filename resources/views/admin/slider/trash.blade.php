@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách slider</h1>
</div>
<span><a href="{{route('admin.slider.add')}}" class="btn btn-primary mb-3">Thêm mới</a></span>
<a href="{{route('admin.slider.index')}}" class="btn btn-warning mb-3">Danh sách slider</a>

@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
@section('css')

<style>

    img{
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>
    
@endsection
<table class="table table-bordered">
    <thead>
        <tr class='text-center  font-weight-bold'>
            <td style="width:5%">Stt</td>
            <td width="20%">Tên slide</td>
            <td width="25%" >Hình slide</td>
            <td >Mô tả

            </td>

            <td style="width:5%">Sửa</td>

            <td style="width:5%">Xóa</td>
        </tr>
    </thead>
    <tbody>
        @if ($lists->count()>0)
            @foreach ($lists as $key=>$item)
                <tr class="text-center mt-auto">
                    <td>{{$key+1}}</td>
                    <td class="font-weight-bold text-info">{{$item->name}}</td>
                    <td height="180px"><img src="{{$item->image_path}}" alt=""></td>
                    <td>{!!$item->description!!}</td>

                    
                    <td>
                        <a href="{{route('admin.slider.restore',$item->id)}}" class="btn btn-secondary">Phục hồi</a>

                    </td>
                    <td>
                        {{-- @if (Auth::user()->id !== $item->id) --}}
                        
                        <a href="{{route('admin.slider.forceDelete',$item->id)}}" class="btn btn-danger">Xóa vĩnh viễn</a>

                        {{-- @endif --}}

                    </td>
                </tr>
        @endforeach

        @endif

    </tbody>
</table>
<div class="d-flex justify-content-end">

    {{ $lists->withQueryString()->links() }}
</div>
@endsection

@section('script')
