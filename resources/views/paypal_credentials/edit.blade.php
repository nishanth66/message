@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Paypal Credentials
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($paypalCredentials, ['route' => ['paypalCredentials.update', $paypalCredentials->id], 'method' => 'patch']) !!}

                        @include('paypal_credentials.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection