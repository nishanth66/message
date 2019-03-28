@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Distributor
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($distributor, ['route' => ['distributors.update', $distributor->id], 'method' => 'patch']) !!}

                   <div class="form-group col-sm-12">
                       {!! Form::label('distributor_name', 'Distributor Name:') !!}
                       {!! Form::text('distributor_name', $distributor->name, ['class' => 'form-control']) !!}
                   </div>

                   <div class="form-group col-sm-12">
                       {!! Form::label('code', 'Distributor Code:') !!}
                       <input type="text" value="{{$distributor->code}}" name="code" id="code" class="form-control" onkeyup="checkCode1('{{$distributor->id}}')" onkeydown="checkCode1('{{$distributor->id}}')" placeholder="Distributor Unique Code">
                       <span class="errorCode"><font color="red">This Code has been already used</font></span>
                   </div>

                   <div class="form-group col-sm-12">
                       {!! Form::label('email', 'Email:') !!}
                       {!! Form::email('email', $distributor->email, ['class' => 'form-control']) !!}
                       @if( Session::has( 'error' ))
                           <center><p style="color: red">{{ Session::get( 'error' ) }}</p></center>
                       @endif
                   </div>
                   <div class="form-group col-sm-12">
                       <button type="submit" id="submitBtn" class="btn btn-primary">Save</button>
                       <a href="{!! route('distributors.index') !!}" class="btn btn-default">Cancel</a>
                   </div>
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
<script>
    function checkCode1(id) {
        var code = $('#code').val();
        $.ajax({
            url: '{{url('checkCode1')}}' + '/' + code+'/'+id,
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