@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách người dùng</h1>
</div>
@can('create', App\Models\User::class)
{{-- @can('users.add') --}}
<p><a href="{{route('admin.users.add')}}" class="btn btn-primary">Thêm mới</a></p>
@endcan
@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr class='text-center  font-weight-bold'>
            <td style="width:5%">Stt</td>
            <td>Họ tên</td>
            <td>Email</td>
            <td style="width:15%">Nhóm</td>

            @can('users.edit')
            <td style="width:10%">Sửa</td>
            @endcan

            @can('users.delete')
            <td style="width:10%">Xóa</td>
            @endcan
        </tr>
    </thead>
    <tbody>
        @if ($lists->count()>0)
            @foreach ($lists as $key=>$item)
                <tr class="text-center mt-auto">
                    <td>{{$key+1}}</td>
                    <td class="font-weight-bold text-info">{{$item->name}}</td>
                    <td class=" text-danger">{{$item->email}}</td>
                    <td class="font-weight-bold text-primary">{{$item->groups->name}}</td>

                    @can('users.edit')
                        <td>
                            <a href="{{route('admin.users.edit',$item)}}" class="btn btn-warning">Sửa</a>
                        </td>
                    @endcan

                    @can('users.delete')
                    <td>
                        @if (Auth::user()->id !== $item->id)
                        
                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa?'); " href="{{route('admin.users.delete',$item)}}" class="btn btn-danger">Xóa</a>
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