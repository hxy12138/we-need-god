@extends('adminlte::page')

@section('title', '小米后台首页')

@section('content_header')
    <h1>权限列表</h1>
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
        <li>权限列表</li>
    </ol>
    <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">权限列表</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                <i class="fa fa-minus"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>名称</th>
                  <th>URL</th>
                  <th>是否展示</th>
                  <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;操作</th>
                </tr>
                @foreach($menu as $k => $v)
                <tr>
                  <td>{{  str_repeat('|--',substr_count($v['path'],'-')).$v['text'] }}</td>
                  <td>{{ $v['url'] }}</td>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@if($v['is_menu']==0)
                    <span class="label label-danger">否</span>
                    @else
                    <span class="label label-success">是</span>
                    @endif</td>
                  <td><a href="{{URL::asset('admin/updatemenu?id='.$v['id'])}}" class="btn"><i class="fa fa-refresh"></i></a>
                    <a href="{{URL::asset('admin/delmenu?id='.$v['id'])}}" class="btn"><i class="fa fa-trash"></i></a></td>
                </tr>
                @endforeach
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
<a href="{{URL::asset('admin/addmenu')}}" class="btn btn-app""><i class="fa fa-edit"></i>添加权限</a>
@stop
@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
    <!-- <script> console.log('Hi!'); </script> -->
@stop