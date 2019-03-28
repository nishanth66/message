<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $usermessage->id !!}</p>
</div>

<!-- Message Field -->
<div class="form-group">
    {!! Form::label('message', 'Message:') !!}
    <p>{!! $usermessage->message !!}</p>
</div>
<!-- Message Field -->
<div class="form-group">
    {!! Form::label('message', 'Destination Emails:') !!}
    <?php
        $emails = explode(',',$usermessage->emails);
        $i=1;
    ?>
    @foreach($emails as $email)
    <table class="table table-responsive">
        <tr>
            <td>{{$i}}</td>
            <td>{{$email}}</td>
        </tr>
    </table>
    <?php
        $i++;
    ?>
    @endforeach
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $usermessage->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $usermessage->updated_at !!}</p>
</div>

