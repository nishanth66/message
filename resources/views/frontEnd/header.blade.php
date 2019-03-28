<?php
use App\Models\logo;
$landing = \App\Models\landing::first();
$logoimg = $users = DB::select('select * from logo LIMIT 1');
foreach ($logoimg as $logoImg)
{
    $logo = $logoImg->image;
}
$header = DB::select('select * from header');
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>land page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="{{asset('public/css/singlestyle.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/style2.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
{{--<body>--}}
<div id="preloader"></div>
<!--top bar-->
<div id="home" class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 homeLogin">
                <center class="mob">
                <div class="col-md-6 col-sm-6">
                    <div class="col-md-12 col-sm-12">
                    <a class="homePhone" href="tel:{{$landing->Phone}}">Phone:&ensp;{{$landing->Phone}}</a>
                    </div>
                    <div class="col-md-12 col-sm-12">
                    <a class="homePhone" href="mailto:{{$landing->email}}">Email:&ensp;{{$landing->email}}</a>
                    </div>
                </div>
                </center>
                <div class="col-md-6 col-sm-6 desktop">
                    <div class="col-md-12 col-sm-12">
                    <a class="homePhone" href="tel:{{$landing->Phone}}">Phone:&ensp;{{$landing->Phone}}</a>
                    </div>
                    <div class="col-md-12 col-sm-12">
                    <a class="homePhone" href="mailto:{{$landing->email}}">Email:&ensp;{{$landing->email}}</a>
                    </div>
                </div>
                <center class="mob">
                    <br/>
                <div>
                    <div class="copyright1-text">
                        @if(Auth::user())
                            <a href="{{url('/dashboard')}}"><button type="button" class="btn btn-danger">DASHBOARD</button></a>
                            <a href="{!! url('logout') !!}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <button type="button" class="btn btn-warning">SIGN OUT</button>
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="logoutClass">
                                {{ csrf_field() }}
                            </form>

                        @else
                        <a href="{{url('/login')}}"><button type="button" class="btn btn-danger">LOGIN</button></a>
                        <a href="{{url('/register')}}"><button type="button" class="btn btn-warning">REGISTER</button></a>
                        @endif
                    </div>
                    </div>
                </center>
                <div class="desktop">
                    <div class="copyright1-text pull-right">
                        @if(Auth::user())
                            <a href="{{url('/dashboard')}}"><button type="button" class="btn btn-danger">DASHBOARD</button></a>
                            <a href="{!! url('logout') !!}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <button type="button" class="btn btn-warning">SIGN OUT</button>
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="logoutClass">
                                {{ csrf_field() }}
                            </form>

                        @else
                        <a href="{{url('/login')}}"><button type="button" class="btn btn-danger">LOGIN</button></a>
                        <a href="{{url('/register')}}"><button type="button" class="btn btn-warning">REGISTER</button></a>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--top bar end-->
<!--menu bar-->
<div class="menu-area sticky-menu">
    <div class="container">

        <div class="row">
            <div class="col-ms-12">
            <div class="col-md-2 col-sm-2 col-xs-12">
                <a href="{{url('/')}}"><img class="homeLogo" src="{{asset('public/avatars').'/'.''.$logo.''}}"></a>
            </div>
            <!-- Navigation starts -->
            <div class="col-md-10 col-sm-10">
                <div class="mainmenu">
                    <div class="navbar navbar-nobg">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                    data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="navbar-collapse collapse pull-right">
                            <nav>
                                <ul class="nav navbar-nav">
                                    @if(Request::is('view/packages'))
                                        <li class="navItem"><a href="{{url('/')}}"><b>{{$header[0]->title}}</b></a></li>
                                        <li class="navItem"><a href="{{url('/#about')}}"><b>{{$header[1]->title}}</b></a></li>
                                        <li class="active navItem"><a href="#"><b>{{$header[2]->title}}</b></a></li>
                                        <li class="navItem"><a href="{{url('/#contact')}}"><b>{{$header[3]->title}}</b></a></li>
                                    @elseif(Request::is('login') || Request::is('register') || Request::is('Register/Distributor') || Request::is('paywithpaypal') )
                                        <li class="navItem"><a href="{{url('/')}}"><b>{{$header[0]->title}}</b></a></li>
                                        <li class="navItem"><a href="{{url('/#about')}}"><b>{{$header[1]->title}}</b></a></li>
                                        <li class="navItem"><a href="{{url('view/packages')}}"><b>{{$header[2]->title}}</b></a></li>
                                        <li class="navItem"><a href="{{url('/#contact')}}"><b>{{$header[3]->title}}</b></a></li>
                                    @else
                                        <li class="active navItem"><a class="smooth_scroll" href="#"><b>{{$header[0]->title}}</b></a></li>
                                        <li class="navItem"><a class="smooth_scroll" href="#about"><b>{{$header[1]->title}}</b></a></li>
                                        <li class="navItem"><a class="smooth_scroll" href="#packages"><b>{{$header[2]->title}}</b></a></li>
                                        <li class="navItem"><a class="smooth_scroll" href="#contact"><b>{{$header[3]->title}}</b></a></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Navigation ends -->
        </div>
    </div>
    </div>
</div>