@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Booking
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($reminder, ['route' => ['rememberMessage.update', $reminder->id], 'method' => 'patch']) !!}

                        @include('defaultMsg.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection