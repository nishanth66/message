
@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Change Package Name
    </h1>
</section>
<div class="content">
    @include('adminlte-templates::common.errors')
    <div class="box box-primary">

        <div class="box-body">
            <div class="row">
                <div class="col-md-3">

                </div>
                <div class="col-md-6">
                    <form method="post" action="{{url('save/change/message')}}">
                        {{csrf_field()}}
                        <center>
                            <div class="col-sm-12 form-group">
                                <br/>
                                <label class="form-group changeMsg">Change Package Message:</label>
                                <textarea name="changeMessage" cols="50" rows="5" class="form-control">{{$msg->message}}</textarea>
                                <br/>
                            </div>
                            <div class="col-sm-12 form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{url('change/pakage/message')}}"><button type="button" class="btn btn-default">Cancel</button></a>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
