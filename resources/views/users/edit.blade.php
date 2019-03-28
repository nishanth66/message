@extends('layouts.app')
<?php
$id = Auth::user()->id;
$user = \App\Models\users::whereId($id)->first();
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
                    <form method="post" action="{{url('editProfile').'/'.''.$id.''}}">
                        {{csrf_field()}}
                        <div class="form-group col-sm-6">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
                        </div>


                        <div class="form-group col-sm-6">
                            {!! Form::label('private_key', 'Private Key:') !!}
                            <input type="text" name="personalKey" value="{{$user->personalKey}}" class="form-control">
                        </div>


                        @if(Auth::user()->status == 'user')
                            <div class="form-group col-sm-6">
                                {!! Form::label('days_remember_to_login', 'Days Remember to Login:') !!}
                                {!! Form::number('days_remember_to_login', $user->days_remember_to_login, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('package', 'Package:') !!}
                                    <?php
                                    $pack=\App\Models\packages::whereId($user->package)->first();
                                    ?>
                                    <input type="text" readonly class="form-control" value="{{$pack->package_name}}">
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('distributor_code', 'Destributor Code:') !!}
                                <input type="text" value="{{$user->distributor_code}}" class="form-control" readonly>
                            </div>
                        @elseif(Auth::user()->status == 'distributor')
                            <?php
                                $dist = \App\Models\distributor::whereId(Auth::user()->distributor_id)->first();
                             ?>
                            <div class="form-group col-sm-6">
                                {!! Form::label('code', 'Unique Code:') !!}
                                <input type="text"  value="{{$dist->code}}" class="form-control" readonly>
                                <input type="hidden"  value="{{$user->distributor_id}}" class="form-control" readonly>
                            </div>
                            <div class="form-group col-sm-6">
                                {!! Form::label('paypal_email', 'Paypal Email:') !!}
                                <input type="text" name="paypal_email" value="{{$user->paypal_email}}" class="form-control">
                            </div>
                        @endif

                        <input type="hidden" value="{{$user->status}}" class="form-control" readonly>
                        <div class="form-group col-sm-12">
                            <div class="col-md-4 col-sm-4">
                                <input type="submit" class="btn btn-primary" name="save" value="Save">
                                <a href="{!! url('/home') !!}" class="btn btn-default">Cancel</a>
                            </div>
                            @if(Auth::user()->status != 'admin')
                                <div class="col-md-1 col-sm-1"></div>
                            @if(Auth::user()->status != 'distributor')
                            <div class="col-md-4 col-sm-4">
                                <a href="{{url('changePackage').'/'.$user->id}}"><button type="button" class="btn btn-warning packageChange">Change Package Subscription</button></a>
                            </div>
                            @endif
                            <button type="button" class="btn btn-danger pull-right" onclick="terminatePack('{{Auth::user()->id}}')">Terminate Subscription</button>
                            @endif
                        </div>
                    </form>
               </div>
           </div>
       </div>
   </div>
@endsection
<script>
    function terminatePack(id) {
        if(confirm("Terminating the Subscription will delete your account and entire details. Are you Sure?")) {
            $.ajax({
                url: '{{url('terminate/profile')}}' + '/' + id,
                success: function (data) {
                    window.location = '{{ url("/home") }}';
                }
            });
        }
    }
</script>