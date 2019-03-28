<div class="form-group col-sm-12">
    <lable>PayPal Mode</lable>
    <select name="mode" class="form-control">
        <option value="" selected disabled>Select a Mode</option>
        <option value="0" @if(isset($paypal) && $paypal->mode == '0') <?php echo "selected";?> @endif>Sandbox</option>
        <option value="1" @if(isset($paypal) && $paypal->mode == '1') <?php echo "selected";?> @endif>Live</option>
    </select>
</div>
<div class="form-group col-sm-12">
    <lable>Client Id</lable>
    <textarea name="client_id" class="form-control" rows="4" cols="30">@if(isset($paypal)) {{$paypal->client_id}} @endif</textarea>
</div>
<div class="form-group col-sm-12">
    <lable>Client Secrete</lable>
    <textarea name="client_secrete" class="form-control" rows="4" cols="30">@if(isset($paypal)) {{$paypal->client_secrete}} @endif</textarea>
</div>
<div class="form-group col-sm-12">
    <label>Currency</label>
    <select name="currency" class="form-control">
        <option value="" selected disabled>Select a Currency</option>
        @foreach($currencies as $key=>$currency)
            {{$currency}}
            <option value="{{htmlspecialchars($currency)}}" <?php if (isset($paypal) && $paypal->currency == $currency) { echo "selected";} ?>>{{$key}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-sm-12">
    <button type="submit" class="btn btn-primary">Save</button>
    <a class="btn btn-default" href="{{route('paypalClientCredentials.index')}}">Cancel</a>
</div>