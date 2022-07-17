@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách nhóm</h1>
</div>
@can('create', App\Models\Groups::class)

<p><a href="{{route('admin.groups.add')}}" class="btn btn-primary">Thêm mới</a></p>
@endcan
@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr class='text-center  font-weight-bold'>
            <td style="width:5%">Stt</td>
            <td>Tên</td>
            <th style="width:15%">Người tạo</th>

            @can('groups.permission')
            <td style="width:15%">Phân quyền</td>
            @endcan
            @can('groups.edit')
            <td style="width:10%">Sửa</td>
            @endcan

            @can('groups.delete')
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
                    <td class="text-danger">{{!empty($item->postBy->name) ? $item->postBy->name :'Root';}}</td>

                     @can('groups.permission')
                    <td><a href="{{route('admin.groups.permissions',$item)}}" class="btn btn-primary">Phân quyền</a></td>
                    @endcan

                    @can('groups.edit')
                    <td>
                        <a href="{{route('admin.groups.edit',$item)}}" class="btn btn-warning">Sửa</a>
                    </td>
                    @endcan

                    @can('groups.delete')
                    <td>
                        {{-- @if (Auth::user()->id == $item->user_id || $item->user_id == 0) --}}
                        
                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa?'); " href="{{route('admin.groups.delete',$item)}}" class="btn btn-danger">Xóa</a>
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