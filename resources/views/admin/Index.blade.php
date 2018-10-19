
@extends('adminlte::page')

@section('title', '小米后台首页')

@section('content_header')
    <h1>小米后台首页</h1>
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
        <li><i class="fa fa-dashboard"></i> Home</li>
    </ol>
    <div class="box">
        <div class="box-header with-border">
          <h2 class="box-title">欢迎{{ $userinfo['name'] }}</h2>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body" style="">
            <h3>一份权利一份责任</h3><br><br>
            权利越大责任越大请谨慎操作！
        </div>
        <!-- /.box-body -->
        <div class="box-footer" style="">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
@stop
@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
    <!-- <script> console.log('Hi!'); </script> -->
@stop