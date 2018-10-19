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
        <li><a href="/admin/userlist">管理员列表</a></li>
        <li>添加管理员</li>
    </ol>
    <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">添加管理员</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{URL::asset('admin/adduserdo')}}" method="post">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">邮箱</label>
                  <input type="email" class="form-control" name="username" id="exampleInputEmail1" placeholder="请填写正确邮箱">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">密码</label>
                  <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="请输入密码">
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername">名字</label>
                  <input type="text" class="form-control" name="name" id="exampleInputUsername" placeholder="请输入名字">
                </div>
              </div>
              <!-- /.box-body -->
                <div class="form-group">

                  @foreach($role as $v)
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="role[]" value="{{ $v['r_id'] }}">
                      {{ $v['role_name'] }}
                    </label>
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