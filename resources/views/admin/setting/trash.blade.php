@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách cài đặt</h1>
</div>
@can('create', App\Models\Posts::class)
    
<span ><a href="{{route('admin.setting.add')}}?type=text" class="btn btn-primary mb-2">Thêm mới text</a></span>
<span><a href="{{route('admin.setting.add')}}?type=textarea" class="btn btn-primary mb-2">Thêm mới textarea</a></span>
<span><a href="{{route('admin.setting.index')}}" class="btn btn-success mb-2">Danh sách cài đặt</a></span>


@endcan
@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr class='text-center font-weight-bold'>
            <td style="width:5%">Stt</td>
            <td>Cấu hình tên</td>
            <td>Cấu hình giá trị</td>

            <td style="width:5%">Sửa</td>

            <td style="width:5%">Xóa</td>

        </tr>
    </thead>
    <tbody>
        @if ($lists->count()>0)
            @foreach ($lists as $key=>$item)
                <tr class="text-center mt-auto">
                    <td>{{$key+1}}</td>
                    <td class="font-weight-bold text-info">{{$item->config_key}}</td>
                    <td class="font-weight-bold text-primary">{{$item->config_value}}</td>
                        <td>
                            
                            <a href="{{route('admin.setting.restore',$item->id)}}" class="btn btn-secondary">Phục hồi</a>

                                
                        </td>

                    <td>
                        
                        
                        <a href="{{route('admin.setting.forceDelete',$item->id)}}" class="btn btn-danger">Xóa vĩnh viễn</a>

                            
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