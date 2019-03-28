<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $distributor->id !!}</p>
</div>

<!-- Distributor Name Field -->
<div class="form-group">
    {!! Form::label('distributor_name', 'Distributor Name:') !!}
    <p>{!! $distributor->distributor_name !!}</p>
</div>

<div class="form-group">
    {!! Form::label('code', 'Distributor Code:') !!}
    <p>{!! $distributor->code !!}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $distributor->email !!}</p>
</div>

<div class="form-group">
    {!! Form::label('private_key', 'Private Key:') !!}
    <p>{!! $distributor->private_key !!}</p>
</div>

<!-- Amount Field -->
{{--<div class="form-group">--}}
    {{--{!! Form::label('amount', 'Amount:') !!}--}}
    {{--<p>{!! $distributor->amount !!}</p>--}}
{{--</div>--}}

<!-- Status Field -->
{{--<div class="form-group">--}}
    {{--{!! Form::label('status', 'Status:') !!}--}}
    {{--<p>{!! $distributor->status !!}</p>--}}
{{--</div>--}}

<!-- Created At Field -->

