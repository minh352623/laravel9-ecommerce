@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Danh sách sản phẩm</h1>
</div>

@can('products.add') 
<span><a href="{{route('admin.products.add')}}" class="btn btn-primary mb-3">Thêm mới</a></span>
@endcan
<span><a href="{{route('admin.products.trash')}}" class="btn btn-success mb-3">Thùng rác</a></span>

@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
@section('css')

<style>

    img{
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>
    
@endsection
<table class="table table-bordered">
    <thead>
        <tr class='text-center  font-weight-bold'>
            <td style="width:5%">Stt</td>
            <td>Tên sản phẩm</td>
            <td width="25%" >Hình sản phẩm</td>
            <td style="width:15%">Giá sản phẩm</td>
            <td style="width:15%">Danh mục sản phẩm</td>

            @can('products.edit') 
            <td style="width:5%">Sửa</td>
            @endcan
            @can('products.delete') 
            <td style="width:5%">Xóa</td>
            @endcan
        </tr>
    </thead>
    <tbody>
        @if ($lists->count()>0)
            @foreach ($lists as $key=>$item)
                <tr class="text-center mt-auto">
                    <td>{{$key+1}}</td>
                    <td class="font-weight-bold text-info">{{$item->name}}</td>
                    <td height="180px"><img src="{{$item->feature_image_path}}" alt=""></td>
                    <td class=" text-danger">${{($item->price)}}</td>
                    <td>{{optional($item->categories)->name}}</td>

                    @can('products.edit') 
                    <td>
                        <a href="{{route('admin.products.edit',$item)}}" class="btn btn-warning">Sửa</a>
                    </td>
                    @endcan

                    @can('products.delete') 
                    <td>
                        {{-- @if (Auth::user()->id !== $item->id) --}}
                        
                        <a  href="{{route('admin.products.delete',$item)}}" class="btn btn-danger action_delete">Xóa</a>
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