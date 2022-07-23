@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Menu</h1>
</div>
@can('menus.add') 

<span><a href="{{route('admin.menu.add')}}" class="btn btn-primary mb-3">Thêm mới</a></span>
@endcan
<span><a href="{{route('admin.menu.trash')}}" class="btn btn-success mb-3">Thùng rác</a></span>

@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr class='text-center  font-weight-bold'>
            <td style="width:5%">Stt</td>
            <th >Tên menu</th>

            @can('menus.edit') 
            <td style="width:10%">Sửa</td>
            @endcan
            @can('menus.delete') 

            <td style="width:10%">Xóa</td>
            @endcan
        </tr>
    </thead>
    <tbody>
        @if ($lists->count()>0)
            @foreach ($lists as $key=>$item)
                <tr class="text-center mt-auto">
                    <td>{{$key+1}}</td>
                    <td class="font-weight-bold text-info   ">{{$item->name}}</td>

                  
                    @can('menus.edit') 

                    <td>
                        <a href="{{route('admin.menu.edit',$item)}}" class="btn btn-warning">Sửa</a>
                    </td>
                    @endcan
                    @can('menus.delete') 

                    <td>
                        {{-- @if (Auth::user()->id == $item->user_id || $item->user_id == 0) --}}
                        
                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa?'); " href="{{route('admin.menu.delete',$item)}}" class="btn btn-danger">Xóa</a>
                        {{-- @endif --}}

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