@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Add Distributor
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('adddistributors.show_fields')
                    <a href="{!! route('adddistributors.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
