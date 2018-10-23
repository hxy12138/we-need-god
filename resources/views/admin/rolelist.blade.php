@extends('adminlte::page')

@section('title', '小米后台首页')

@section('content_header')
    <h1>角色列表</h1>
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
        <li>角色列表</li>
    </ol>
    <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">角色列表</h3>

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
                  <th>名字</th>
                  <th>操作</th>
                </tr>
                @foreach($role as $v)
                <tr>
                  <td>{{ $v['r_id'] }}</td>
                  <td>{{ $v['role_name'] }}</td>
                  <td>
                    @if($userinfo['is_super']==1)<a href="updatarolepower?id={{$v['r_id']}}">@endif
                      <i class="fa btn  fa-refresh
                        @if($userinfo['is_super']==0)disabled @endif
                    "></i>
                  @if($userinfo['is_super']==1)</a>@endif
                  &nbsp;&nbsp;
                    @if($userinfo['is_super']==1)<a href="deletrolepower?id={{$v['r_id']}}">@endif
                      <i class="fa fa-trash
                          @if($userinfo['is_super']==0)disabled @endif
                      "></i>
                    @if($userinfo['is_super']==1)</a>@endif
                  </td>
                </tr>
                @endforeach
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
<a href="{{URL::asset('admin/addrole')}}" class="btn btn-app""><i class="fa fa-edit"></i>添加角色</a>
@stop
@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
    <!-- <script> console.log('Hi!'); </script> -->
@stop