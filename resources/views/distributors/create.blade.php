@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Distributor
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'distributors.store']) !!}
                    @if( Session::has( 'error' ))
                        <center><p style="width:50%;background-color:red;color: white">{{ Session::get( 'error' ) }}</p></center>
                    @endif

                        @include('distributors.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
