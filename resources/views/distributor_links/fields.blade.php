<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Package Field -->
<div class="form-group col-sm-12">
    {!! Form::label('package', 'Package:') !!}
    <select name="package" class="form-control" id="package" onchange="getPackage(this.value)">
        <option value="" selected disabled>Select a Package</option>
        @foreach($packages as $package)
            @if(isset($distributorLink))
                <option value="{{$package->id}}" @if($package->id == $distributorLink->package) {{"selected"}} @endif>{{$package->package_name}}</option>
            @else
                <option value="{{$package->id}}">{{$package->package_name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Price Field -->
<div class="form-group col-sm-12">
    {!! Form::label('price', 'Price:') !!}
    @if(isset($distributorLink))
        <input type="text" readonly class="form-control" id="price" value="{{$distributorLink->price}}">
    @else
        <input type="text" readonly class="form-control" id="price">
    @endif
</div>


    <input type="hidden" name="distributor" readonly class="form-control" value="{{Auth::user()->distributor_id}}">



<!-- Commission Field -->
<div class="form-group col-sm-12">
    {!! Form::label('commission', 'Commission:') !!}
    @if(isset($distributorLink))
        <input type="text" readonly class="form-control" id="commission" value="{{$distributorLink->commission}}">
    @else
        <input type="text" readonly class="form-control" id="commission">
    @endif
</div>

<div class="form-group col-sm-12">
    {!! Form::label('link', 'Link:') !!}
    @if(isset($distributorLink))
        <input type="text" name="link" readonly class="form-control" id="link" value="{{$distributorLink->link}}">
    @else
        <input type="text" name="link" readonly class="form-control" id="link">
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('distributorLinks.index') !!}" class="btn btn-default">Cancel</a>
</div>

<script>
    function getPackage(val) {
        $.ajax({
            url: "{{url('getPackageDetails')}}"+"/"+val,
            success: function(result)
            {
                $('#price').val(result['price']);
                $('#commission').val(result['commission']);
                $('#link').val(result['link']);
            }
        });
    }
</script>