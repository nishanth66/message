<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $packages->id !!}</p>
</div>

<div class="form-group">
    {!! Form::label('package_name', 'Package Name:') !!}
    <p>{!! $packages->package_name !!}</p>
</div>

<div class="form-group">
    {!! Form::label('package_class', 'Package Class:') !!}
    <p>{!! $packages->package_class !!}</p>
</div>

<div class="form-group">
    {!! Form::label('no_of_limit_messages', 'Number of Messages Limit:') !!}
    <p>{!! $packages->no_of_limit_messages !!}</p>
</div>

<div class="form-group">
    {!! Form::label('initial_setup', 'Initial Setup:') !!}
    <p>{!! $packages->initial_setup !!}</p>
</div>

<div class="form-group">
    {!! Form::label('yearly_subscribe', 'Yearly Subscription:') !!}
    <p>{!! $packages->yearly_subscribe !!}</p>
</div>

<div class="form-group">
    {!! Form::label('features', 'Special Features:') !!}
    <p>{!! $packages->features !!}</p>
</div>



