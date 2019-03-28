@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Disabled Users
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <div class="col-md-12">
                        <label>Name</label>
                        <p>{{$users->name}}</p>
                    </div>
                    <div class="col-md-12">
                        <label>Email</label>
                        <p>{{$users->email}}</p>
                    </div>
                    <div class="col-md-12">
                        <label>Password</label>
                        <p>{{$users->real_pass}}</p>
                    </div>
                    <div class="col-md-12">
                        <label>Package</label>
                        <?php
                            $package = \App\Models\packages::whereId($users->package)->first();
                        ?>
                        <p>{{$package->package_name}}</p>
                    </div>
                    <div class="col-md-12">
                        <label>Last Login</label>
                        <p>{{date('d-m-Y',$users->lastUpdated)}}</p>
                    </div>
                    <div class="col-md-12">
                        <label>Reminder Days</label>
                        <p>{{$users->days_remember_to_login}}</p>
                    </div>


                    <a href="{!! url('disabled/users') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
