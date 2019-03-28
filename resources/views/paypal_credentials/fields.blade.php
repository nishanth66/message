<!-- Client Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_id', 'Client Id:') !!}
    {!! Form::text('client_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Secret Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('secret_id', 'Secret Id:') !!}
    {!! Form::text('secret_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Mode Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mode', 'Mode:') !!}
    <select class="form-control" name="mode">
        <option value="" selected disabled>Select one Mode</option>
        <option value="live">Live</option>
        <option value="sandbox">Sandbox</option>
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('paypalCredentials.index') !!}" class="btn btn-default">Cancel</a>
</div>
