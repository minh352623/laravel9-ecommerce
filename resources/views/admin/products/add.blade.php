@extends('layouts.admin')

@section('css')
<link href="{{asset('assets/admins/vendor/select2')}}/select2.min.css" rel="stylesheet" />
<style>
    .select2-selection__choice{background-color: #000 !important; color: #fff !important}
</style>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thêm Sản Phẩm</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger">Vui lòng kiểm tra dữ liệu nhập vào</div>
@endif
@if (session('msg'))
<div class="alert alert-success">{{session('msg')}}</div>
    
@endif
<form action="" method="POST" enctype="multipart/form-data" >
    <div class="row">
        <div class="col-6">
            <div class="mb-4">
                <label for="">Tên sản phẩm</label>
                <input value="{{old('name')}}" name="name" type="text" class="form-control  @error('name') is-invalid @enderror" placeholder="Tên sản phẩm...">
                @error('name')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="col-6"> <div class="mb-4">
            <label >Giá sản phẩm</label>
            <input value="{{old('price')}}" name="price" type="text" class="form-control @error('price') is-invalid @enderror" placeholder="Giá sản phẩm...">
            @error('price')
                <span class="text-danger mt-2">{{$message}}</span>
            @enderror
        </div></div>
        <div class="col-6"> <div class="mb-4">
            <label for="">Ảnh đại diện</label>
            <input value="{{old('feature_image_path')}}" name="feature_image_path"   type="file" class="form-control-file @error('feature_image_path') is-invalid @enderror">
            @error('feature_image_path')
                <span class="text-danger mt-2">{{$message}}</span>
            @enderror
        </div></div>
        <div class="col-6">   <div class="mb-4">
            <label for="">Ảnh chi tiết</label>
            <input value="{{old('image_path')}}" multiple name="image_path[]"  type="file" class="form-control-file @error('image_path') is-invalid @enderror">
            @error('image_path')
                <span class="text-danger mt-2">{{$message}}</span>
            @enderror
        </div></div>
        <div class="col-6">  <div class="mb-4">
            <label for="">Nhập Tags</label>
            <select class="form-control tag_select2_choose" name="tags[]" multiple="multiple">
            </select>
        </div></div>
       
        <div class="col-6"> <div class="mb-4">
            <label for="">Chọn danh mục</label>
            <select class="form-control selected2_init @error('category_id') is-invalid @enderror" name="category_id">
                <option value="0">Chọn danh mục</option>
                {!!($htmlOption)!!}
            </select>
            @error('category_id')
                <span class="text-danger mt-2">{{$message}}</span>
            @enderror
        </div></div>
        <div class="col-12"><div class="mb-4">
            <label for="">Nội dung</label>
            <textarea name="content" rows="3"  type="text" class="form-control my-editor @error('content') is-invalid @enderror">{{old('content')}}</textarea>
            @error('content')
                <span class="text-danger mt-2">{{$message}}</span>
            @enderror
        </div></div>
    </div>
    <div class="mb-3">

    <button type="submit" class="btn btn-primary">Thêm mới</button>
    <a href="{{route('admin.products.index')}}" class="btn btn-warning">Danh sách sản phẩm</a>
    </div>
    @csrf
</form>
@endsection

@section('script')
<script src="{{asset('assets/admins/vendor/select2')}}/select2.min.js"></script>
   <script>
    $(function(){
        $(".tag_select2_choose").select2({
            tags: true,
            tokenSeparators: [',']
        });
        $(".selected2_init").select2({
            placeholder: "Select a state",
            allowClear: true
        });
    });
    </script> 
  <script src="https://cdn.tiny.cloud/1/1dnd16pp1u3k2hu5r68h113r39yu55bku2pc760cem97t0t3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    var editor_config = {
      path_absolute : "/",
      selector: 'textarea.my-editor',
      relative_urls: false,
      plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table directionality",
        "emoticons template paste textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
      file_picker_callback : function(callback, value, meta) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
  
        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
        if (meta.filetype == 'image') {
          cmsURL = cmsURL + "&type=Images";
        } else {
          cmsURL = cmsURL + "&type=Files";
        }
  
        tinyMCE.activeEditor.windowManager.openUrl({
          url : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizable : "yes",
          close_previous : "no",
          onMessage: (api, message) => {
            callback(message.content);
          }
        });
      }
    };
  
    tinymce.init(editor_config);
  </script>
@endsection