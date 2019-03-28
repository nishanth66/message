<?php
    use App\Models\packages;
    $packages = packages::get();
    if (isset($id) && $id != '')
    {
        $plan = packages::whereId($id)->first();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Messenger | Registration Page</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @include('frontEnd.header')
</head>
<body class="hold-transition register-page">
<div class="register-box">

    <div class="register-box-body">
        <p class="login-box-msg"><b>Register a new membership</b></p>

        {{--<form method="post" action="{{ url('/register') }}">--}}
        <form method="post" action="{{ url('/register') }}">

            {!! csrf_field() !!}

            <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Full Name" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('package') ? ' has-error' : '' }}">
                @if (isset($id) && $id != '')
                    <input type="hidden" name="package" id="package" readonly class="form-control" value="{{$id}}">
                    <input type="text" readonly class="form-control" value="{{$plan->package_name}}">
                @else
                    <select class="form-control" name="package" id="package" required onchange="calamt(this.value)">
                        <option value="" selected disabled>Select any Package</option>
                        @foreach($packages as $package)
                            <option value="{{$package->id}}">{{$package->package_name}}</option>
                        @endforeach
                    </select>
                    {{--<span class="fa fa fa-dashboard form-control-feedback"></span>--}}

                    @if ($errors->has('package'))
                        <span class="help-block">
                            <strong>{{ $errors->first('package') }}</strong>
                        </span>
                    @endif
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('distributor_code') ? ' has-error' : '' }}">
                @if(isset($code) && $code != '')
                    <input type="text" name="distributor_code" id="code" readonly class="form-control" value="{{$code}}" placeholder="Distributor Code" onkeypress="hideError()" onchange="checkCode()">
                @else
                    <input type="text" name="distributor_code" id="code" class="form-control" placeholder="Distributor Code" onkeypress="hideError()" onchange="checkCode()">
                @endif
                <span class="fa fa-code form-control-feedback"></span>

                @if ($errors->has('distributor_code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('distributor_code') }}</strong>
                    </span>
                @endif
                <span class="errorCode"><font color="red">This Code is not Valid</font></span>
            </div>

            <div class="form-group has-feedback{{ $errors->has('personalKey') ? ' has-error' : '' }}">
                <input type="text" name="personalKey" id="personalKey" class="form-control" placeholder="Encryption Key">
                <span class="fa fa-key form-control-feedback"></span>

                @if ($errors->has('personalKey'))
                    <span class="help-block">
                        <strong>{{ $errors->first('personalKey') }}</strong>
                    </span>
                @endif
                {{--<span class="errorCode"><font color="red">This Code is not Valid</font></span>--}}
            </div>

            <div class="form-group has-feedback{{ $errors->has('days_remember_to_login') ? ' has-error' : '' }}">
               <input type="text" class="form-control" name="days_remember_to_login" id="days_remember_to_login" placeholder="Days to remember">
                <span class="fa fa fa-calendar form-control-feedback"></span>

                @if ($errors->has('days_remember_to_login'))
                    <span class="help-block">
                        <strong>{{ $errors->first('days_remember_to_login') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> I agree to the <a href="#">terms</a>
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" id="submitBtn" class="btn btn-primary btn-block btn-flat btnReg">Register</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="{{ url('/login') }}" class="text-center loginLink">I already have a membership</a> <br/>
        <a href="{{ url('/Register/Distributor') }}" class="text-center loginLink">Sign Up as Distributor</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
@include('frontEnd.footer')
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
<script>
    function checkCode() {
        $('.errorCode').css('display','none');
        var code = $('#code').val();
        if(code == '')
        {
            $('#submitBtn').prop("type", "submit");
        }
        else {
        $.ajax({
                url: '{{url('checkCodeEntered')}}' + '/' + code,
                success: function (data) {
                    if (data == 'success') {
                        $('.errorCode').css('display', 'block');
                        $('#submitBtn').prop("type", "button");
                    }
                    else if(code == '')
                    {
                        alert("fgj");
                        $('#submitBtn').prop("type", "submit");
                    }
                    else {
                        $('.errorCode').css('display', 'none');
                        $('#submitBtn').prop("type", "submit");
                    }
                }
            });
        }
    }
    function hideError() {
        $('.errorCode').css('display','none');
    }
</script>
<script>
    function calamt(val) {
        // alert(val);
        {{--$.ajax({--}}
            {{--url: '{{url('getpackamt')}}' + '/' + val,--}}
            {{--success: function (data) {--}}
                    {{--console.log(data);--}}
            {{--}--}}
        {{--});--}}
    }
</script>
</body>
</html>
