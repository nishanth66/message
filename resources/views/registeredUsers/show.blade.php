@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Registered User
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <div class="col-md-12">
                        <label>Name</label>
                        <p>{{$registered_user->name}}</p>
                    </div>
                    <div class="col-md-12">
                        <label>Email</label>
                        <p>{{$registered_user->email}}</p>
                    </div>
                    <div class="col-md-12">
                        <label>Package</label>
                        <p>{{$registered_user->package}}</p>
                    </div>
                    <a href="{!! url('registered/users') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
