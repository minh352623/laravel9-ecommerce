@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Menu đã xóa</h1>
</div>

<span><a href="{{route('admin.menu.add')}}" class="btn btn-primary mb-3">Thêm mới</a></span>
<a href="{{route('admin.menu.index')}}" class="btn btn-warning mb-3">Danh sách menu</a>

@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr class='text-center  font-weight-bold'>
            <td style="width:5%">Stt</td>
            <th >Tên menu</th>

         
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
                        
                        <a href="{{route('admin.menu.restore',$item->id)}}" class="btn btn-secondary">Phục hồi</a>
                    </td>
                    <td>
                        {{-- @if (Auth::user()->id == $item->user_id || $item->user_id == 0) --}}
                        
                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa?'); " href="{{route('admin.menu.forceDelete',$item->id)}}" class="btn btn-danger">Xóa vĩnh viễn</a>
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