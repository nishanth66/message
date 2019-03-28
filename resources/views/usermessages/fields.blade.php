<!-- Message Field -->
<?php
$userid=Auth::user()->id;
$maxDays = Auth::user()->days_remember_to_login+1;
?>
<input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>">
@if(isset($usermessage))
    <input type="hidden" name="msgid" id="msgid" value="{{$usermessage->msgid}}">
@else
    <input type="hidden" name="msgid" id="msgid" value="{{$msgId}}">
@endif
<div class="col-md-12">
    <div class="form-group col-sm-6">
        {!! Form::label('emails', 'Destination Email:') !!}
        @if(isset($usermessage))
            <textarea name="emails" cols="20" rows="2" class="form-control" placeholder="Seperate Each emails by a Comma" required>{{$usermessage->emails}}</textarea>
        @else
            <textarea name="emails" cols="20" rows="2" class="form-control" placeholder="Seperate Each emails by a Comma" required></textarea>
        @endif
    </div>
</div>

<div class="col-md-12">
    <div class="form-group col-sm-6">
        {!! Form::label('day', 'Days:') !!}
        {!! Form::text('day', null, ['class' => 'form-control','placeholder' => 'should be greater than or equal to '.$maxDays.' days','onkeyup'=>'checkDay('.$maxDays.')','id'=>'day','required']) !!}
        <p class="alert alert-danger help-block" id="errorDays">The Day should be greater than or equal to {{$maxDays}} Days</p>
    </div>
</div>

<div class="col-md-12">
    <div class="form-group col-sm-6">
        {!! Form::label('message', 'Message:') !!}
        {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
    </div>
</div>


<!-- Submit Field -->
<div class="col-md-12">
    <div class="form-group col-sm-12">
        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
        <a href="{!! route('usermessages.index') !!}" class="btn btn-default">Cancel</a>
    </div>
</div>

<script>
    function checkDay(val) {
        var day = $('#day').val();
        if (val > day)
        {
            $('#errorDays').show();
            $('#saveBtn').prop('type','button');
        }
        else
        {
            $('#errorDays').hide();
            $('#saveBtn').prop('type','submit');
        }
    }
</script>
