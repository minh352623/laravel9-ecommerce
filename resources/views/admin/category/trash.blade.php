@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh mục đã xóa gần đây</h1>
</div>

<span><a href="{{route('admin.category.add')}}" class="btn btn-primary mb-3">Thêm mới</a></span>
<a href="{{route('admin.category.index')}}" class="btn btn-warning mb-3">Danh sách danh mục</a>

@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr class='text-center  font-weight-bold'>
            <td style="width:5%">Stt</td>
            <th >Tên danh mục</th>

         
            <td style="width:10%">Phục hồi</td>

            <td style="width:15%">Xóa</td>

        </tr>
    </thead>
    <tbody>
        @if ($lists->count()>0)
            @foreach ($lists as $key=>$item)
                <tr class="text-center mt-auto">
                    <td>{{$key+1}}</td>
                    <td class="font-weight-bold text-info   ">{{$item->name}}</td>

                  

                    
            
                    <td>
                        
                        <a href="{{route('admin.category.restore',$item->id)}}" class="btn btn-secondary">Phục hồi</a>
                    </td>
                    <td>
                        
                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa?'); " href="{{route('admin.category.forceDelete',$item->id)}}" class="btn btn-danger">Xóa vĩnh viễn</a>

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