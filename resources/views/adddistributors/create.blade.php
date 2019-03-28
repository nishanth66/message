@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Add Distributor
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'adddistributors.store']) !!}

                        @include('adddistributors.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
