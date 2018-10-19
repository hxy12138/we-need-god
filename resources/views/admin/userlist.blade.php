@extends('adminlte::page')

@section('title', '小米后台首页')

@section('content_header')
    <h1>管理员列表</h1>
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
        <li>管理员列表</li>
    </ol>
    <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">管理员列表</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>账号</th>
                  <th>名字</th>
                  <th>创建时间</th>
                  <th>更改时间</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
                @foreach($data as $v)
                <tr>
                  <td>{{ $v['id'] }}</td>
                  <td>{{ $v['username'] }}</td>
                  <td>{{ $v['name'] }}</td>
                  <td>{{ $v['created_at'] }}</td>
                  <td>{{ $v['updated_at'] }}</td>
                  <td>@if($v['is_freeze']==1)
                    @if($v['is_super']==0)<a href="{{URL::asset('admin/userstatus?id='.$v['id'].'&status='.$v['is_freeze'])}}">@endif
                    <span class="label label-danger
                    @if($v['is_super']==1)btn disabled @endif
                    ">禁用</span>@if($v['is_super']==0)</a>@endif
                    @else
                    @if($v['is_super']==0)<a href="{{URL::asset('admin/userstatus?id='.$v['id'].'&status='.$v['is_freeze'])}}">@endif
                    <span class="label label-success
                    @if($v['is_super']==1)btn disabled @endif
                    ">启用</span>@if($v['is_super']==0)</a>@endif
                    @endif
                  </td>
                  <td><a href=""><i class="fa btn  fa-refresh"></i></a>&nbsp;&nbsp;
                    @if($v['is_super']==0)<a href="">@endif<i class="fa fa-trash
                          @if($v['is_super']==1)disabled @endif
                      "></i>@if($v['is_super']==0)</a>@endif</td>
                </tr>
                @endforeach
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
<a href="{{URL::asset('admin/adduser')}}" class="btn btn-app""><i class="fa fa-edit"></i>添加管理员</a>
@stop
@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
    <!-- <script> console.log('Hi!'); </script> -->
@stop