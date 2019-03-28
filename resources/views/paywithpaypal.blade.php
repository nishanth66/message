
@include('frontEnd.header')
<style>    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }
</style>
@if ($message = Session::get('success'))
<div class="custom-alerts alert alert-success fade in">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    {!! $message !!}
</div>
<?php
Session::forget('success');
?>
@endif
@if ($message = Session::get('error'))
    <div class="custom-alerts alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        {!! $message !!}
    </div>
    <?php
    Session::forget('error');
    ?>
@endif
<div class="demo" id="test1">
    <center>
        <div class="title"><h1>Continue With Selected Package</h1></div>
    </center>
    <br/>
    <div class="container" >
        <div class="row">
            <div class="col-md-4 col-sm-4"></div>
            <div class="col-md-4 col-sm-4">
                <div class="pricingTable">
                    <div class="pricingTable-header">
                        <h4 class="packageName">{{$package->package_name}}</h4>
                        <span class="year">Initial charge<br>${{$package->initial_setup}}</span>
                    </div>
                    <div class="price-value">
                        <div class="value">
                            <span class="currency">$</span>
                            <span class="amount">{{$package->yearly_subscribe}}</span>
                            <span class="month">/year</span>
                        </div>
                    </div>
                    <ul class="pricing-content">
                        <?php
                        $features = explode(',', $package->features);
                        ?>
                        @foreach($features as $feature)
                            <li><i class="fa fa-check" aria-hidden="true"></i>{{$feature}}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="pricingTable-signup proceedBtn" onclick="changeType(2)">Proceed
                    </button>
                </div>
            </div>
            </center>
        </div>
    </div>
</div><input type="hidden" id="userid" value="{{Auth::user()->id}}">
<div class="container" id="test2">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="payment-body">
                <center>
                    <div class="panel-heading"><b>Paywith Paypal</b></div>
                </center>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" autocomplete="off" id="payment-form" role="form"
                          action="{!! url('paypal') !!}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} required">
                            <label for="amount" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$user->name}}" autofocus required>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} required">
                            <label for="amount" class="col-md-4 control-label">Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}" autofocus required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-4 control-label">Phone&ensp;</label>
                            <div class="col-md-6">
                                <input id="phone" type="number" class="form-control" name="phone" value="{{$user->phone}}" autofocus> @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }} required">
                            <label for="amount" class="col-md-4 control-label">Street and house number</label>
                            <div class="col-md-6">
                                <input id="street" type="text" class="form-control" name="street" autofocus required>
                                @if ($errors->has('street'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('street') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }} required">
                            <label for="amount" class="col-md-4 control-label">country</label>
                            <div class="col-md-6">
                                <select id="country" type="text" class="form-control" name="country" autofocus required>
                                    <option value="" selected disabled>Select a Country</option>
                                    @foreach($countries as $key => $value)
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }} required">
                            <label for="amount" class="col-md-4 control-label">City</label>
                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control" name="city" autofocus required>
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('post') ? ' has-error' : '' }} required">
                            <label for="amount" class="col-md-4 control-label">Zip Code</label>
                            <div class="col-md-6">
                                <input id="post" type="text" class="form-control" name="post" autofocus required>
                                @if ($errors->has('post'))<span class="help-block">
                                    <strong>{{ $errors->first('post') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="reason" value="new">
                        <div class="form-group{{ $errors->has('package') ? ' has-error' : '' }} required">
                            <label for="amount" class="col-md-4 control-label">Package</label>
                            <div class="col-md-6">
                                <input id="packages" type="text" class="form-control" name="packages" value="{{$package->package_name}}" readonly autofocus required>
                                <input id="package" type="hidden" class="form-control" name="package" value="{{$package->id}}" readonly autofocus required>
                                @if ($errors->has('package'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('package') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if(Auth::user()->user_type == 'new')
                            <input type="hidden" name="type" value="new">
                            <input type="hidden" name="reason" value="new">
                        <div class="form-group{{ $errors->has('initial') ? ' has-error' : '' }} required">
                            <label for="initial" class="col-md-4 control-label">Initial Setup</label>
                            <div class="col-md-6">
                                <input id="initial" type="text" class="form-control" readonly name="initial" autofocus>
                                @if ($errors->has('initial'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('initial') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            @else
                            <input type="hidden" name="type" value="reneval">
                            <input type="hidden" name="reason" value="reneval">
                        @endif
                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }} required">
                            <label for="amount" class="col-md-4 control-label">Yearly Subscription:</label>
                            <div class="col-md-6">
                                <input id="amount" type="text" class="form-control" readonly name="amount" autofocus>
                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('total') ? ' has-error' : '' }} required">
                            <label for="total" class="col-md-4 control-label">Total Amount To Pay:</label>
                            <div class="col-md-6">
                                <input id="total" type="text" class="form-control" readonly name="total" autofocus>
                                @if ($errors->has('total'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('total') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <center>
                                    <button type="submit" class="btn btn-success btn-paypal-pay"> Paywith Paypal</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><br/>@include('frontEnd.footer')
<script>
    function changeType(val) {
        $('#test1').hide();
        $('#test2').fadeToggle();
        $.ajax({
            url: '{{url('changeType')}}'+'/'+val,
            success: function (result) {
                $("#amount").val(result);
                if (result[0] == 1)
                {
                   $('#initial').val(result[1]);
                   $('#amount').val(result[2]);
                   $('#total').val(result[3])
                }
                else
                {
                    $('#amount').val(result[2]);
                    $('#total').val(result[3])
                }
            }
        });
    }</script>