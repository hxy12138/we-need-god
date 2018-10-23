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
        <li><a href="/admin/rolelist">角色列表</a></li>
        <li>添加角色</li>
    </ol>
    <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">添加角色</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{URL::asset('admin/addroledo')}}" method="post">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputUsername">名字</label>
                  <input type="text" class="form-control" name="role_name" id="exampleInputUsername" placeholder="请输入名字">
                </div>
              </div>
              <!-- /.box-body -->
                <div class="form-group">

                  @foreach($resource as $v)
                  <div class="checkbox">
                    &nbsp;&nbsp;&nbsp;&nbsp;<label>
                      <input type="checkbox" name="resource[]" value="{{ $v['id'] }}">
                      {{ $v['text'] }}
                    </label>
                    @if(!empty($v['submenu']))
                    <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @foreach($v['submenu'] as $va)
                    <label>
                      <input type="checkbox" name="resource[]" value="{{ $va['id'] }}">
                      {{ $va['text'] }}
                    </label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    @endforeach
                    @endif
                  </div>
                  @endforeach

                </div>
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