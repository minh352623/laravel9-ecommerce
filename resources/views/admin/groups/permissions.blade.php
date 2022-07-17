@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Phân quyền Nhóm - {{$group->name}}</h1>
</div>

@if (session('msg'))
    <div class="alert alert-success">{{session('msg')}}</div>
@endif
<form action="" method="POST">
<table class="table table-bordered">
    <thead>
        <tr class="text-center">
            <th width="20%">Module</th>
            <th>Quyền</th>
        </tr>
    </thead>
    <tbody>
        @if ($modules->count()>0)
            @foreach ($modules as $module)
                <tr>
                    <td>{{$module->title}}</td>
                    <td>
                        <div class="row">
                            <style>
                                label{
                                    font-weight: bold;
                                }
                            </style>
                            @if (!empty($roleListArr))
                                @foreach ($roleListArr as $roleName=>$roleLabel)
                                    <div class="col-2">
                                        <label for="role_{{$module->name}}_{{$roleName}}">
                                            <input {{$roleName=='add'?'class=add':false}} id="role_{{$module->name}}_{{$roleName}}" type="checkbox" name="role[{{$module->name}}][]" value="{{$roleName}}"  {{isRole($roleArr,$module->name,$roleName)?'checked':false}}>
                                            {{$roleLabel}}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                          
                    
                            @if ($module->name=="groups")
                                
                            <div class="col-2">
                                <label for="role_{{$module->name}}_permission">
                                    <input {{isRole($roleArr,$module->name,'permission')?'checked':false}} type="checkbox" name="role[{{$module->name}}][]" id="role_{{$module->name}}_permission" value="permission">
                                    Phân quyền
                                </label>
                            </div>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
     
    </tbody>
</table>
<button class="btn btn-primary">Phân quyền</button>
<a href="{{route('admin.groups.index')}}" class="btn btn-warning">Danh sách nhóm</a>

@csrf
</form>
<script>
    window.addEventListener('load', function(){
        let views = document.querySelectorAll('input.add');
        function handleCheckView(e){
            let inputView = this.parentElement.parentElement.previousElementSibling;
            // console.log(inputView);
            if(this.checked){

                inputView.querySelector('input').checked =true;
            }
        }
        views.forEach(item=>item.addEventListener('click',handleCheckView));
    })
</script>
@endsection