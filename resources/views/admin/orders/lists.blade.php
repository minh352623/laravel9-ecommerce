@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách đơn hàng</h1>
</div>


@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
<form action="" class="mb-1" method="get">
    <div class="row">
        <div class="col-4">
            <select name="status" class="form-control">
                <option value="0">Tất cả trạng thái</option>
                <option value="3" {{request()->status && request()->status == 3 ?'selected':false}}>Đang chờ duyệt</option>
                <option value="1" {{request()->status && request()->status == 1 ?'selected':false}}>Đang giao</option>

                <option value="2" {{request()->status == 2 ?'selected':false}}>Đã giao</option>

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
            <td style="width:30%">Thông tin</td>
            <td>Tổng tiền</td>
            <td>Trạng thái</td>
            <td>Ngày đặt hàng</td>
            <td style="width:13%">Xem chi tiết</td>
        </tr>
    </thead>
    <tbody>
        @if ($bills->count()>0)
            @foreach ($bills as $key=>$item)
                @php
                    // dd($item);
                @endphp
                <tr class="text-center mt-auto">
                    <td>{{$item->id}}</td>
                    <td class="font-weight-bold text-start text-info">
                       Tên: <span class="text-dark"> {{  $item->name_user }}</span>
                        <br/>
                      Email:  <span class="text-dark"> {{ $item->email_user }}</span>
                        <br/>
                       Số điện thoại:<span class="text-dark"> {{$item->tel}}</span>
                        <br/>
                       Địa chỉ: <span class="text-dark"> {{$item->address}}</span>

                    </td>
                    <td class="font-weight-bold text-primary">${{$item->total}}</td>
                    <td>
                        <div class="flex-c-m stext-101 cl2 p-2 rounded text-light size-119 bg-{{$item->status == 0 ? 'warning': ($item->status == 1?'info':'success')}} bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                            {{getStatusBillVn($item->status)}}
                        </div>
                    </td>
                    <td>
                        {{$item->created_at}}
                    </td>
                    <td>
                            
                                <a href="{{route('admin.orders.edit',$item->id)}}" class="btn btn-secondary">Xem chi tiết</a>
                                
                    </td>

                </tr>
        @endforeach

        @endif

    </tbody>
</table>
<div class="d-flex justify-content-end">

    {{ $bills->withQueryString()->links() }}
</div>
@endsection

@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function actionDelete(e){
        e.preventDefault();
        let that =$(this);
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            console.log($(this).attr('href'));
            $.ajax({

                url:$(this).attr('href'),
                    type:'GET',
                    dataType:'json',
                    success:function(response){
                        // console.log(response);
                        that.parent().parent().remove();
                          Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                            );
                    },
                    error:function(error){
                       
                    }
            })
          
        }
})
    };
    $(function(){
        $(document).on('click','.action_delete',actionDelete);
    });
</script>
@endsection