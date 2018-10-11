@extends('public.temptate')

@section('title','提示_通用平台')

@section('body')
<div style="margin:auto; width: 50%; height: auto; overflow: hidden;">
    <div class="box box-default" style="margin-top: 20%;">
        <div class="box-header with-border">
            <i class="fa fa-bullhorn"></i>
            <h3 class="box-title">提示</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @if ($data['status']=='error')
            <div class="callout callout-danger">
                <h4>错误</h4>
                <p>{{$data['message']}}</p>
                <p>浏览器页面将在<b id="loginTime_error">{{ $data['jumpTime'] }}</b>秒后跳转......<a href="javascript:void(0);" class="jump_now">立即跳转</a> </p>
            </div>
            @endif
            @if ($data['status']=='continue')
            <div class="callout callout-info">
                <h4>未完成，继续</h4>
                <p>{{$data['message']}}</p>
                <p>浏览器页面将在<b id="loginTime_continue">{{ $data['jumpTime'] }}</b>秒后跳转......<a href="javascript:void(0);" class="jump_now">立即跳转</a> </p>
            </div>
            @endif
            @if ($data['status']=='warning')
            <div class="callout callout-warning">
                <h4>警告</h4>
                <p>{{$data['message']}}</p>
                <p>浏览器页面将在<b id="loginTime_warning">{{ $data['jumpTime'] }}</b>秒后跳转......<a href="javascript:void(0);" class="jump_now">立即跳转</a> </p>
            </div>
            @endif
            @if ($data['status']=='success')
            <div class="callout callout-success">
                <h4>成功</h4>
                <p>{{$data['message']}}</p>
                <p>浏览器页面将在<b id="loginTime_success">{{ $data['jumpTime'] }}</b>秒后跳转......<a href="javascript:void(0);" class="jump_now">立即跳转</a> </p>
            </div>
            @endif
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
@endsection
<!-- jQuery 3 -->
<script src="{{URL::asset('js/jquery.js')}}"></script>
<!--本页JS-->
<script type="text/javascript">
    $(function(){
        //循环倒计时，并跳转
        var url = "{{ $data['url'] }}";
        var loginTimeID='loginTime_'+'{{$data['status']}}';
        //alert(loginTimeID);return;
        var loginTime = parseInt($('#'+loginTimeID).text());
        console.log(loginTime);
        var time = setInterval(function(){
            loginTime = loginTime-1;
            $('#'+loginTimeID).text(loginTime);
            if(loginTime==0){
                clearInterval(time);
                window.location.href=url;
            }
        },1000);
    });
    //点击跳转
    $('.jump_now').click(function () {
        var url = "{{ $data['url'] }}";
        window.location.href=url;
    });
</script>
