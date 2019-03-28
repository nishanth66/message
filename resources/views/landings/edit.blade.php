@extends('layouts.app')
<?php
    use App\Models\landing;
    use App\Models\slideImage;
    $page = landing::whereId(1)->first();
    $image = slideImage::where('parent_id',1)->get();
    ?>
@section('content')
    <section class="content-header">
        <h1>
            Landing
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   <form method="post" enctype="multipart/form-data" action="{{url('landingPage')}}">
                       {{csrf_field()}}
                       <input type="hidden" value="1" name="id">
                       <div class="form-group col-sm-12">
                           {!! Form::label('main_page_text', 'Page Text Main:') !!}
                           <textarea name="main_page_text" id="main_page_text" class="form-control">{{$page->main_page_text}}</textarea>
                       </div>
                       <div class="form-group col-sm-12">
                           {!! Form::label('sub_page_text', 'Page Text Sub:') !!}
                           <textarea name="sub_page_text" id="sub_page_text" class="form-control">{{$page->sub_page_text}}</textarea>
                       </div>

                       <div class="form-group col-sm-6">
                           {!! Form::label('main_image', 'Main Image:') !!}
                           <input type="file" name="main_image" class="form-control">
                           <?php
                           if($page->main_image != '' || (!empty($page->main_image))) {
                           ?>
                           <div class="col-md-2" style="position: relative;">
                               <img src="{{asset('public/avatars').'/'.''.$page->main_image.''}}" class="editImage">
                           </div>
                           <?php
                           }
                           ?>
                       </div>

                       <!-- Image Field -->
                       <div class="form-group col-sm-12" id="InputsWrapper">
                           {!! Form::label('image', 'Image:') !!} <div id="AddMoreFileId"> <br>
                               <a href="#" id="AddMoreFileBox" class="btn btn-success ">+</a><br><br>
                           </div>

                           <input type="file" name="image[]" class="form-control" id="image">

                           <a href="#" class="removeclass"></a>
                       </div>


                       <div id="lineBreak"></div>
                       <div class="col-md-12" id="image_delete" style="display: block;margin-bottom: 5%">
                           <?php
                           if($image != '' || (!empty($image))) {

                           foreach ($image as $item) {
                           ?>
                           <div class="col-md-2" style="position: relative;">
                               <img src="{{asset('public/avatars').'/'.''.$item->image.''}}" class="editImage">
                               <button style="position: absolute;bottom: 0;margin-left: -100px;" type="button" onclick="DeleteImageDir(<?php echo $item->id; ?>)">X</button>
                           </div>
                           <?php
                           }
                           }
                           ?>
                       </div>
                       <!-- Email Field -->
                       <div class="form-group col-sm-6">
                           {!! Form::label('email', 'Email:') !!}
                           {!! Form::text('email', $page->email, ['class' => 'form-control']) !!}
                       </div>
                       <!-- Address Field -->
                       <div class="form-group col-sm-6">
                           {!! Form::label('Address', 'Address:') !!}
                           {!! Form::text('Address', $page->Address, ['class' => 'form-control']) !!}
                       </div>

                       <!-- Phone Field -->
                       <div class="form-group col-sm-6">
                           {!! Form::label('Phone', 'Phone:') !!}
                           {!! Form::number('Phone', $page->Phone, ['class' => 'form-control']) !!}
                       </div>

                       <!-- Submit Field -->
                       <div class="form-group col-sm-12">
                           {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                           <a href="{!! route('landings.index') !!}" class="btn btn-default">Cancel</a>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="{{asset('public/css/editor.css')}}">
    <script src="https://cdn.ckeditor.com/4.10.0/full-all/ckeditor.js"></script>
    <script>
        // CKEDITOR.replace('brf_desc');
        CKEDITOR.replace('main_page_text');
        CKEDITOR.replace('sub_page_text');
    </script>
<script>
    $(document).ready(function() {

        var MaxInputs       = 1000; //maximum extra input boxes allowed
        var InputsWrapper   = $("#InputsWrapper"); //Input boxes wrapper ID
        var AddButton       = $("#AddMoreFileBox"); //Add button ID

        var x = InputsWrapper.length; //initlal text box count
        var FieldCount=1; //to keep track of text box added

//on add input button click
        $(AddButton).click(function (e) {
            //max input box allowed
            if(x <= MaxInputs) {
                FieldCount++; //text box added ncrement
                //add input box
                $(InputsWrapper).append('<div><br><input type="file" class="form-control" name="image[]" id="image'+ FieldCount +'"/> <br> <a href="#" class="removeclass"><button type="button" class="btn btn-danger">-</button></a></div>');
                x++; //text box increment

                $("#AddMoreFileId").show();

                $('AddMoreFileBox').html("Add field");

                // Delete the "add"-link if there is 3 fields.
                if(x == 1000) {
                    $("#AddMoreFileId").hide();
                    $("#lineBreak").html("<br>");
                }
            }
            return false;
        });

        $("body").on("click",".removeclass", function(e){ //user click on remove text
            if( x > 1 ) {
                $(this).parent('div').remove(); //remove text box
                x--; //decrement textbox

                $("#AddMoreFileId").show();

                $("#lineBreak").html("");

                // Adds the "add" link again when a field is removed.
                $('AddMoreFileBox').html("Add field");
            }
            return false;
        })

    });
</script>
<script>
    function DeleteImageDir(imgId) {
        $.ajax({
            url: '{{url('DeleteImg')}}'+'/'+imgId,
            success:function(data){
                $("#image_delete").load(location.href + " #image_delete");
            }
        });
    }
</script>
@endsection