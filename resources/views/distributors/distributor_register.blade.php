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
<div class="register-box register-box1">

    <div class="register-box-body">
        <p class="login-box-msg"><b>Register a new membership</b></p>

        <form method="post" action="{{ url('/Distributor/Register') }}">


            {!! csrf_field() !!}

            <div class="form-group has-feedback{{ $errors->has('distributor_name') ? ' has-error' : '' }}">
                <input type="text" class="form-control" name="distributor_name" value="{{ old('distributor_name') }}" placeholder="Full Name" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>

                @if ($errors->has('distributor_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('distributor_name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('code') ? ' has-error' : '' }}">
                <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" placeholder="Unique Code" required onkeyup="checkCode()" onkeydown="checkCode()">
                <span class="glyphicon glyphicon-cog form-control-feedback"></span>

                @if ($errors->has('code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('code') }}</strong>
                    </span>
                @endif
                <span class="errorCode"><font color="red">This Code has been already used</font></span>
            </div>

            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                @if( Session::has( 'error' ))
                    <center><p style="color: red">{{ Session::get( 'error' ) }}</p></center>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" id="pass" name="password" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input type="password" name="password_confirmation" id="confirm" class="form-control" placeholder="Confirm password" required onkeyup="checkPass()">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
                <span class="errorPass"><font color="red">Confirm Password must match the password</font></span>
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
        <a href="{{ url('/register') }}" class="text-center loginLink">Sign Up as User</a>
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
<script>
    function checkCode() {
        $('.errorCode').css('display','none');
        var code = $('#code').val();
        $.ajax({
            url: '{{url('checkCode')}}' + '/' + code,
            success: function (data) {
                if (data == 'exist')
                {
                    $('.errorCode').css('display','block');
                    $('#submitBtn').prop("type", "button");
                }
                else
                {
                    $('.errorCode').css('display','none');
                    $('#submitBtn').prop("type", "submit");
                }
            }
        });
    }
    function checkPass() {
        $('.errorPass').css('display','none');
        var pass=$('#pass').val();
        var confirmPass=$('#confirm').val();
        if (pass == confirmPass)
        {
            $('.errorPass').css('display','none');
            $('#submitBtn').prop("type", "submit");
        }
        else
        {
            $('.errorPass').css('display','block');
            $('#submitBtn').prop("type", "button");
        }
    }
</script>
</body>
</html>
