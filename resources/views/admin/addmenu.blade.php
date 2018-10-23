@extends('adminlte::page')

@section('title', '小米后台首页')

@section('content_header')
    <!-- <h1>管理员添加</h1> -->
@stop

@section('top_user')
 <li>
    <a href="">
       <i class="fa fa-fw fa-book"></i> {{ $userinfo['name'] }}
    </a>
 </li>
@stop

@section('content')
    <ol class="breadcrumb">
        <li><a href="/admin/home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/admin/menu">权限列表</a></li>
        <li>添加权限</li>
    </ol>
    <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">添加权限</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{URL::asset('admin/addmenudo')}}" method="post">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputUsername">名称</label>
                  <input type="text" class="form-control" name="text" id="exampleInputUsername" placeholder="请输入名称">
                  <label for="exampleInputUsername">uri</label>
                  <input type="text" class="form-control" name="url" id="exampleInputUsername" placeholder="请输入uri">
                  <label>父级</label>
                  <select class="form-control" name="p_id">
                    <option selected="selected" value="0">此为父级</option>
                    @foreach($parentmenu as $k=>$v)
                    <option value="{{$v['id']}}">{{ $v['text'] }}</option>
                    @endforeach
                  </select>
                  <div class="radio">
                    <label>
                      <input type="radio" name="is_menu" id="optionsRadios1" value="1" >展示
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="is_menu" id="optionsRadios1" value="0" checked="">不展示
                    </label>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">添加</button>
              </div>
            </form>
          </div>
@stop
@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
    <!-- <script> console.log('Hi!'); </script> -->
@stop