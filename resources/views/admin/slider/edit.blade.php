@extends('layouts.admin')

@section('css')
<link href="{{asset('assets/admins/vendor/select2')}}/select2.min.css" rel="stylesheet" />
<style>
    .select2-selection__choice{background-color: #000 !important; color: #fff !important}
    img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sửa Slider</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger">Vui lòng kiểm tra dữ liệu nhập vào</div>
@endif
@if (session('msg'))
<div class="alert alert-success">{{session('msg')}}</div>
    
@endif

<form action="" method="POST" enctype="multipart/form-data" >
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <label for="">Tên Slide</label>
                <input value="{{old('name') ?? $slider->name}}" name="name" type="text" class="form-control  @error('name') is-invalid @enderror" placeholder="Tên sản phẩm...">
                @error('name')
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
        </div>

        <div class="col-12"> <div class="mb-4">
            <label for="">Ảnh slide</label>
            <input value="{{old('image_path')  ?? $slider->image_path}}" name="image_path"   type="file" class="form-control-file @error('image_path') is-invalid @enderror">
            <div class="row mt-2">
                <div class="col-4">
                    <div class="width:100%; height:100px">
                        <img src="{{$slider->image_path}}" alt="">

                    </div>
                </div>
            </div>
            @error('image_path')
                <span class="text-danger mt-2">{{$message}}</span>
            @enderror

        </div></div>

      
        <div class="col-12"><div class="mb-4">
            <label for="">Nội dung</label>
            <textarea name="description" rows="3"  type="text" class="form-control my-editor @error('description') is-invalid @enderror">{{old('description')  ?? $slider->description}}</textarea>
            @error('description')
                <span class="text-danger mt-2">{{$message}}</span>
            @enderror
        </div></div>
    </div>
    <div class="mb-3">

    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="{{route('admin.slider.index')}}" class="btn btn-warning">Danh sách slider</a>
    </div>
    @csrf
</form>
@endsection

@section('script')
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