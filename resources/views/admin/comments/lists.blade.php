@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách comment</h1>
</div>


@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
<form action="" class="mb-1" method="get">
    <div class="row">
        <div class="col-4">
            
        </div>
        <div class="col-8">
            <div class="form-group d-flex gap-3">

                <input type="text" name="keyword" placeholder="Từ khóa tìm kiếm" class="form-control">
                <button type="submit" class="btn btn-primary w-25">Tìm kiếm</button>
            </div>
        </div>
    </div>
</form>
<table class="table table-bordered">
    <thead>
        <tr class='text-center font-weight-bold'>
            <td style="width:5%">Stt</td>
            <td >Thông tin</td>
            <td style="width:30%">Nội dung</td>
            <td>Sản phẩm</td>
            <td>Ngày gửi</td>
            <td style="width:5%">Xóa</td>
        </tr>
    </thead>
    <tbody>
        @if ($comments->count()>0)
            @foreach ($comments as $key=>$item)
                <tr class="text-center mt-auto">
                    <td>{{$key +1}}</td>
                    <td class="font-weight-bold text-start text-info">
                       Email: <span class="text-dark"> {{$item->user->email ?? $item->email_user}}</span>
                       <br/>

                       Tên: <span class="text-dark"> {{$item->user->name ?? $item->name_user}}</span>

                  

                    </td>
                    <td class="font-weight-bold text-primary">{{$item->message}}</td>
                    <td>
                        {{$item->product->name ?? $item->name_product}}
                    </td>
                    <td>
                        {{$item->created_at}}
                    </td>
                    <td>
                                
                            <a href="{{route('admin.comments.delete',$item->id)}}" class="action_delete btn btn-danger">Xóa</a>
                                
                    </td>

                </tr>
        @endforeach

        @endif

    </tbody>
</table>
<div class="d-flex justify-content-end">

    {{ $comments->withQueryString()->links() }}
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

