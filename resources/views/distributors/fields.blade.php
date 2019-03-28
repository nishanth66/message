<!-- Distributor Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('distributor_name', 'Distributor Name:') !!}
    {!! Form::text('distributor_name', null, ['class' => 'form-control','placeholder' => 'Distributor Name']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('code', 'Distributor Code:') !!}
    <input type="text" name="code" id="code" class="form-control" onkeyup="checkCode()" onkeydown="checkCode()" placeholder="Distributor Unique Code">
    <span class="errorCode"><font color="red">This Code has been already used</font></span>
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control','placeholder' => 'Email']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::text('password', null, ['class' => 'form-control','placeholder' => 'password']) !!}
</div>

<div class="form-group col-sm-12">
    <button type="submit" id="submitBtn" class="btn btn-primary">Save</button>
    <a href="{!! route('distributors.index') !!}" class="btn btn-default">Cancel</a>
</div>


<script>
    function checkCode() {
        var code = $('#code').val();
        $.ajax({
            url: '{{url('checkCode')}}' + '/' + code,
            success: function (data) {
                if (data == 'exist')
                {
                    $('.errorCode').css('display','block');
                    $('#submitBtn').prop("type", "button");
                }
                else
                {
                    $('.errorCode').css('display','none');
                    $('#submitBtn').prop("type", "submit");
                }
            }
        });
    }
</script>
