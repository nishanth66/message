<head>
    <title>Messenegr | Packages</title>
</head>
@include('frontEnd.header')

<div class="container">
    <div class="section-title text-center">
        <h2>Pricing <span>Plans</span></h2>
    </div>
    <div class="demo">
        <div class="container" >
            <div class="row">
                <?php
                    $i=0;
                ?>
                @foreach($packages as $package)
                    @if($i%2 == 0)
                        <div class="col-md-4 col-sm-4 packageMain">
                            <div class="pricingTable">
                                <div class="pricingTable-header">
                                    <h4 class="packageName">{{$package->package_name}}</h4>
                                    <span class="year">Initial Setup <br>${{$package->initial_setup}}</span>
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
                                <a href="{{url('/register'.'/'.$package->id)}}" class="pricingTable-signup">Sign up</a>
                            </div>
                        </div>
                    @else
                        <div class="col-md-4 col-sm-4 packageMain">
                            <div class="pricingTable purple">
                                <div class="pricingTable-header">
                                    <h4 class="packageName">{{$package->package_name}}</h4>
                                    <span class="year">Initial Setup <br>${{$package->initial_setup}}</span>
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
                                <a href="{{url('/register'.'/'.$package->id)}}" class="pricingTable-signup">Sign up</a>
                            </div>
                        </div>
                    @endif
                    <?php
                    $i++;
                    ?>
                @endforeach
            </div>
            <br/>
        </div>
    </div>

</div>

@include('frontEnd.footer')