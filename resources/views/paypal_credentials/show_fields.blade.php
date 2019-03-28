<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $paypalCredentials->id !!}</p>
</div>

<!-- Client Id Field -->
<div class="form-group">
    {!! Form::label('client_id', 'Client Id:') !!}
    <p>{!! $paypalCredentials->client_id !!}</p>
</div>

<!-- Secret Id Field -->
<div class="form-group">
    {!! Form::label('secret_id', 'Secret Id:') !!}
    <p>{!! $paypalCredentials->secret_id !!}</p>
</div>

<!-- Mode Field -->
<div class="form-group">
    {!! Form::label('mode', 'Mode:') !!}
    <p>{!! $paypalCredentials->mode !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $paypalCredentials->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $paypalCredentials->updated_at !!}</p>
</div>

