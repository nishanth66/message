<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Mail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mail', 'Mail:') !!}
    {!! Form::text('mail', null, ['class' => 'form-control']) !!}
</div>

<!-- Code Field -->
<div class="form-group col-sm-6" style="display: none">
    <?php
    $a= strtotime("now");
    //    echo $a;
    ?>
    {!! Form::label('code', 'Code:') !!}
    {!! Form::hidden('code', $a, ['class' => 'form-control']) !!}
</div>

<!-- Comission Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comission', 'Comission:') !!}
    {!! Form::text('comission', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('adddistributors.index') !!}" class="btn btn-default">Cancel</a>
</div>
