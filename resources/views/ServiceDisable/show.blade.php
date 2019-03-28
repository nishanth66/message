@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Disable Timings
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                        <div class="form-group col-sm-3">
                            {!! Form::label('tile', 'Title') !!}
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Disable/Finish time after the last Reminder Sent</label>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Disable/Finish time after expire of previous plan</label>
                        </div>
                        <div class="form-group col-sm-3">
                            {!! Form::label('Time', 'Time (Day)') !!}
                        </div>
                        <div class="col-md-4 form-group">
                            <input type="text" name="finish" class="form-control" value="{{$time->finish}}" readonly>
                        </div>
                        <div class="col-md-4 form-group">
                            <input type="text" name="expire" class="form-control" value="{{$time->expire}}" readonly>
                        </div>

                        <center><div class="col-sm-12">
                                <a href="{{url('set/disable/day')}}"><button type="button" class="btn btn-primary">Edit</button></a>
                            </div></center>
                </div>
            </div>
        </div>
    </div>
@endsection