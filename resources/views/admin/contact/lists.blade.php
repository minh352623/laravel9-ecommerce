@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách liên hệ</h1>
</div>


@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
<form action="" class="mb-1" method="get">
    <div class="row">
        <div class="col-4">
            <select name="status" class="form-control">
                <option value="0">Tất cả trạng thái</option>
                <option value="2" {{request()->status && request()->status == 2 ?'selected':false}}>Chưa duyệt</option>
                <option value="1" {{request()->status == 1 ?'selected':false}}>Đã duyệt</option>

            </select>
        </div>
        <div class="col-8">
            <div class="form-group d-flex gap-3">

                <input type="text" name="keyword" value="{{request()->keyword}}" placeholder="Từ khóa tìm kiếm" class="form-control">
                <button type="submit" class="btn btn-primary w-25">Tìm kiếm</button>
            </div>
        </div>
    </div>
</form>
<table class="table table-bordered">
    <thead>
        <tr class='text-center font-weight-bold'>
            <td style="width:5%">ID</td>
            <td >Email</td>
            <td style="width:35%">Thông điệp</td>
            <td>Trạng thái</td>
            <td>Ngày gửi</td>
            <td style="width:5%">Duyệt</td>
        </tr>
    </thead>
    <tbody>
        @if ($contacts->count()>0)
            @foreach ($contacts as $key=>$item)
                <tr class="text-center mt-auto">
                    <td>{{$item->id}}</td>
                    <td class="font-weight-bold text-start text-info">
                       Email: <span class="text-dark"> {{$item->email}}</span>
                  

                    </td>
                    <td class="font-weight-bold text-primary">{{$item->message}}</td>
                    <td>
                        <div class="flex-c-m stext-101 cl2 p-2 rounded text-light size-119 bg-{{$item->status == 0 ? 'warning': ($item->status == 1?'info':'success')}} bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                            {{getStatusContact($item->status)}}
                        </div>
                    </td>
                    <td>
                        {{$item->created_at}}
                    </td>
                    <td>
                            @if ($item->status == 0)
                                
                            <a href="{{route('admin.contact.index')}}?censorship={{$item->id}}" class="btn btn-secondary">Duyệt</a>
                            @endif
                                
                    </td>

                </tr>
        @endforeach

        @endif

    </tbody>
</table>
<div class="d-flex justify-content-end">

    {{ $contacts->withQueryString()->links() }}
</div>
@endsection

