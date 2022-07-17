@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách bài viết</h1>
</div>
@can('create', App\Models\Posts::class)
    
<p><a href="{{route('admin.posts.add')}}" class="btn btn-primary">Thêm mới</a></p>
@endcan
@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr class='text-center font-weight-bold'>
            <td style="width:5%">Stt</td>
            <td>Tiêu đề</td>
            <td style="width:10%">Người đăng</td>
            @can('posts.edit') 
            <td style="width:5%">Sửa</td>
            @endcan

            @can('posts.delete') 
            <td style="width:5%">Xóa</td>
            @endcan

        </tr>
    </thead>
    <tbody>
        @if ($lists->count()>0)
            @foreach ($lists as $key=>$item)
                <tr class="text-center mt-auto">
                    <td>{{$key+1}}</td>
                    <td class="font-weight-bold text-info">{{$item->title}}</td>
                    <td class="font-weight-bold text-primary">{{$item->user->name}}</td>
                    @can('posts.edit') 
                        <td>
                            @if (Auth::user()->id == $item->user_id)
                                <a href="{{route('admin.posts.edit',$item)}}" class="btn btn-warning">Sửa</a>
                            @endif
                                
                        </td>
                    @endcan

                    @can('posts.delete') 
                    <td>
                        @if (Auth::user()->id == $item->user_id)
                        
                            <a onclick="return confirm('Bạn có chắc chắn muốn xóa?'); " href="{{route('admin.posts.delete',$item)}}" class="btn btn-danger">Xóa</a>
                            
                            @endif
                     </td>
                    @endcan

                </tr>
        @endforeach

        @endif

    </tbody>
</table>
<div class="d-flex justify-content-end">

    {{ $lists->withQueryString()->links() }}
</div>
@endsection