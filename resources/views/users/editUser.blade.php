@extends('layouts.app')
<?php
$id = $user->id;
?>
@section('content')
    <section class="content-header">
        <h1>
            Users
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <form method="post" action="{{url('editUser').'/'.''.$id.''}}">
                        {{csrf_field()}}

                        <div class="form-group col-sm-12">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('days_remember_to_login', 'Number of Days to remember to login:') !!}
                            {!! Form::text('days_remember_to_login', $user->days_remember_to_login, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('package', 'Package:') !!}
                            <select class="form-control" name="package">
                                <option value="" selected disabled>Select a Package</option>
                                @foreach($packages as $package)
                                    <option value="{{$package->id}}" <?php if ($package->id == $user->package) { echo "Selected"; } ?>>{{$package->package_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('paypal_email', 'Paypal Email:') !!}
                            <input type="text" name="paypal_email" value="{{$user->paypal_email}}" class="form-control">
                        </div>

                        <div class="form-group col-sm-12">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{route('users.index')}}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection