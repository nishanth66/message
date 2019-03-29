@include('frontEnd.profile_header')
<style>
    td, th {
        padding: 0;
        line-height: 1.5;
        vertical-align: text-bottom;
    }
</style>
<div class="container">
    <div class="row">
        <h1 class="text-center">My Account</h1>
        <div class="col-md-12 col-xs-12 col-sm-12 admin_account-style admin_account">
            <div class="col-md-9 col-xs-12 col-sm-12">
                <form method="post" enctype="multipart/form-data" action="{{url('myProfile').'/'.$company->id}}">
                    {{csrf_field()}}
                    @if ($message = Session::get('success'))
                        <div class="custom-alerts alert alert-success fade in">
                            {!! $message !!}
                        </div>
                        <?php Session::forget('success');?>
                    @endif
                    @if ($message_verification = Session::get('activated'))
                        <div class="custom-alerts alert alert-success fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {!! $message_verification !!}
                        </div>
                        <?php Session::forget('activated');?>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="custom-alerts alert alert-danger fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {!! $message !!}
                        </div>
                        <?php Session::forget('error');?>
                    @endif
                    @include('flash::message')
                    @include('adminlte-templates::common.errors')
                    <div class="col-md-5 col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label>{{trans('myProfile.first_name')}}</label>
                            <input type="text" name="fname" value="{{$company->fname}}" class="form-control"
                                   placeholder="{{trans('myProfile.first_name')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('myProfile.last_name')}}</label>
                            <input type="text" name="lname" value="{{$company->lname}}" class="form-control"
                                   placeholder="{{trans('myProfile.last_name')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('myProfile.email')}}</label>
                            <input type="email" readonly value="{{$company->email}}" class="form-control"
                                   placeholder="{{trans('myProfile.email')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('myProfile.phone')}}</label>
                            <input type="text" name="phno" value="{{$company->phno}}" id="phone_number" class="form-control"
                                   placeholder="{{trans('myProfile.phone')}}" onchange="validatePhone()">
                            <p class="help-block" id="invalidPhone"></p>
                        </div>
                    </div>
                    <div class="col-md-7 col-xs-12 col-sm-12 company-ship-details">
                        <div class="form-group">
                            <label>{{trans('myProfile.address')}}</label>
                            <input type="text" name="address" id="autocomplete" value="{{$company->address}}" class="form-control Account_inputs" placeholder="{{trans('myProfile.address')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('myProfile.address2')}}</label>
                            <input type="text" name="address2" class="form-control Account_inputs" value="{{$company->address2}}" placeholder="{{trans('myProfile.address2')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('myProfile.city')}}</label>
                            <input type="text" name="city" value="{{$company->city}}" class="form-control" id="locality" placeholder="{{trans('myProfile.city')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('myProfile.state')}}</label>
                            <input type="text" name="state" value="{{$company->state}}" id="administrative_area_level_1" class="form-control" placeholder="{{trans('myProfile.state')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('myProfile.zip')}}</label>
                            <input type="text" name="zip" value="{{$company->zip}}" class="form-control" id="postal_code" placeholder="{{trans('myProfile.zip')}}">
                        </div>
                        <div class="form-group">
                            <label>{{trans('myProfile.country')}}</label>
                            <select name="country" id="country" class="form-control Account_inputs">
                                <option value="" selected disabled>{{trans('home.select_country')}}</option>
                                @foreach($countries as $country)
                                    <option value="{{$country}}" <?php if ($company->country == $country) {
                                        echo "selected";
                                    } ?>>{{$country}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br/><br/>
                    <div class="col-md-12 col-sm-12">
                        <hr class="company-details"/>
                        <div class="col-md-5 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label>{{trans('myProfile.company_name')}}</label>
                                <input type="text" id="company-name" name="name" class="form-control"
                                       value="{{$company->name}}" placeholder="{{trans('myProfile.company_name')}}"
                                       onchange="checkcompanyName(this.value)">
                                <p class="help-block" id="error-company-name"></p>
                            </div>
                            <div class="form-group">
                                <label>{{trans('myProfile.company_domain_name')}}</label>
                                <input type="url" id="domain_name" name="domain_name" class="form-control"
                                       value="{{$company->domain_name}}" placeholder="{{trans('myProfile.company_domain_name')}}"
                                       onchange="checkDomain1(this.value,'{{$company->id}}')">
                            </div>
                            <div class="form-group">
                                <label>{{trans('myProfile.domain_name')}}</label>
                                <input type="url" id="actual_domain" name="actual_domain" class="form-control"
                                       value="{{$company->actual_domain}}" placeholder="{{trans('myProfile.domain_name')}}"
                                       onchange="checkDomain(this.value,'{{$company->id}}')">
                                <p class="help-block" id="domain-error"></p>
                            </div>
                            <div class="form-group">
                                <label>{{trans('myProfile.apikey')}}</label>
                                <input type="text" class="form-control" readonly value="{{$company->apikey}}">
                            </div>
                        </div>
                        <div class="col-md-7 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label>{{trans('myProfile.cookie')}}</label>
                                <input type="text" name="cookie_duration" class="form-control"
                                       value="{{$company->cookie_duration}}" placeholder="{{trans('myProfile.cookie')}}">
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div id="image">
                                    <br/>
                                    @if(isset($company->logo))
                                        <img src="{{asset('public/avatars').'/'.$company->logo}}"
                                             class="profile-table-img">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <br/>
                                <div class="form-group">
                                    <label>{{trans('myProfile.logo')}}</label>
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg,image/jpg,image/PNG" class="form-control Account_inputs" name="logo"
                                           onchange="readURL(this)" placeholder="{{trans('myProfile.logo')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group" style="display:flex;justify-content: center;">
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <center><button type="submit" id="btn-save-account" class="btn btn-save-profile">{{trans('myProfile.save')}}</button></center>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12 admin_account">
                        @if(Auth::user()->special_user != 1)
                            <div class="col-md-7 col-xs-12 col-sm-12 zeropadding account_section2">
                                <div class="col-md-4  col-xs-6 col-sm-4 zeropadding">
                                    <h4>{{trans('myProfile.cards_on_file')}}</h4>
                                </div>
                                <div class="col-lg-4 col-md-5 col-xs-6 col-sm-4">
                                    <button type="button" class="admin-account-button" data-toggle="modal"
                                            data-target="#addCard">{{trans('myProfile.add_new')}}
                                    </button>

                                </div>

                                @foreach($savedCards as $card)
                                    <?php
                                    $show_card_name = $card->digits;
                                    ?>
                                    @if($card->status == 1)
                                        <div class="col-md-12  col-sm-12 col-xs-12 zeropadding">
                                            <div class="col-lg-7 col-md-7  col-sm-7 col-xs-12 zeropadding">
                                                <p class="name_heading">{{$card->brand}} <span class="rightalign cardnumbr">{{$show_card_name}}</span></p>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6 trashbtnstyle activeBtn">
                                                <i class="fa fa-trash-o trashicon"></i>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                                <button type="button" class="default_active admin-account-button">{{trans('myProfile.default')}}
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-12 col-xs-12 col-sm-12 zeropadding account_section2">
                                            <div class="col-lg-7 col-md-7  col-sm-7 col-xs-12 zeropadding">
                                                <p class="name_heading">{{$card->brand}} <span class="rightalign cardnumbr">{{$show_card_name}}</span></p>
                                            </div>
                                            <div class="col-lg-1 col-md-1  col-sm-1 col-xs-6 trashbtnstyle">
                                                <a class="trashbtnstyle" href="{{url('deletecard').'/'.$card->id}}"
                                                   onclick="return confirm('{{trans('myProfile.sure')}}')"><i class="fa fa-trash-o trashicon"></i></a>
                                            </div>
                                            <div class="col-lg-4 col-md-4  col-sm-4 col-xs-6">
                                                <button class="admin-account-button" type="button"
                                                        onclick="activateCard('{{$card->id}}')">{{trans('myProfile.make_default')}}
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                            {{--````````````````````````````````  Need to work in future  ```````````````````````````````````--}}
                            <div class="col-md-5 col-xs-12 col-sm-5 zeropadding">
                                <div class="col-md-5 col-xs-6 col-sm-6 zeropadding">
                                    {{--                                    <h4>{{trans('myProfile.next_bill')}}</h4>--}}
                                </div>
                                <div class="col-lg-4 col-md-5 col-xs-6 col-sm-6  zeropadding rightalign">
                                    {{--<button type="button" class="admin-account-button" data-toggle="modal"--}}
                                    {{--data-target="#details">{{trans('myProfile.view_detail')}}--}}
                                    {{--</button>--}}
                                </div>
                            </div>
                            <div class="col-md-9 col-xs-12 col-sm-12 zeropadding">

                                <div class="col-md-12 col-xs-12 col-sm-12 zeropadding">
                                    <h4>{{trans('myProfile.your_plans')}}</h4>
                                </div>
                                <br><br><br>
                                <div class="col-md-12 col-xs-12 col-sm-12 account_section2 zeropadding">
                                    <div class="col-md-2 col-xs-2 col-sm-2 zeropadding">
                                        <p class="name_heading">{{trans('myProfile.samy_bot')}}</p>
                                    </div>
                                    @if(Auth::user()->samy_bot == 1 || !empty($samyBotPlans))
                                        <div class="col-md-7 col-xs-7 col-sm-7 name_discrip zeropadding">
                                            <table style="font-size: small;">
                                                @foreach($samyBotPlans as $samyBotPlan)
                                                    <?php
                                                    $bot_plan = App\Models\SamyBotPlans::whereId($samyBotPlan->plan)->first();
                                                    if($bot_plan->term == 'month')
                                                    {
                                                        $old_date = date('d-m-Y', strtotime($samyBotPlan->date));
                                                        $expiry_date = date('d-m-Y', strtotime($old_date. ' +30 days'));
                                                    }
                                                    else
                                                    {
                                                        $old_date = date('d-m-Y', strtotime($samyBotPlan->date));
                                                        $expiry_date = date('d-m-Y', strtotime($old_date. ' +365 days'));
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td width="35%">{{$bot_plan->name}}</td>
                                                        <td width="30%">Expires on <br> {{$expiry_date}}</td>
                                                        <td width="35%">&dollar;{{number_format($samyBotPlan->price)}} / {{$bot_plan->term}}</td>
                                                        <td width="5%">
                                                            <a href="{{url('stripe/Reactivate').'/'.$samyBotPlan->subscription_id}}">
                                                                <button type="button" title="{{trans('myProfile.de_Activate')}}" class="btn btn-default btn-xs refreshicon1"><i class="fa fa-power-off"></i></button></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <div class="col-md-3 col-xs-6 col-sm-3">
                                            <button type="button" class="admin-account-button" data-toggle="modal" data-target="#bot_history">{{trans('myProfile.billing_history')}}</button>
                                            <br><br>
                                            <a href="{{url('samybot/plans')}}"><button type="button" class="admin-account-button">{{trans('myProfile.purchase_more_bots')}}</button></a>
                                        </div>
                                    @else
                                        <div class="col-md-4 col-xs-4 col-sm-4">
                                            <a href="{{url('samybot/plans')}}">
                                                <button type="button" class="admin-account-button">{{trans('myProfile.sign_up')}}</button>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-xs-6 col-sm-6"></div>
                                    @endif
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12 account_section2 zeropadding">
                                    <div class="col-md-2 col-xs-2 col-sm-2 zeropadding">
                                        <p class="name_heading">{{trans('myProfile.samy_affiliate')}}</p>
                                    </div>
                                    @if(Auth::user()->samy_affiliate == 1 || !empty($AffiliatePlans))
                                        <div class="col-md-7 col-xs-7 col-sm-7 name_discrip zeropadding">
                                            <table style="font-size: small;">
                                                <tr>
                                                    <td width="30%">{{$AffiliatePlans->type}}</td>
                                                    <td width="30%">
                                                        {{trans('myProfile.renews')}} {{date('m/d/Y',strtotime($expirydate))}} <br>
                                                        {{$AffiliatePlans->commission}}% {{trans('myProfile.commission')}}
                                                    </td>
                                                    @if($AffiliatePlans->term == 'month')
                                                        <td width="30%">${{$AffiliatePlans->amount}}/{{trans('myProfile.month')}}
                                                            <a href="{{url('stripe/Reactivate').'/'.$company->stripe_subscription_id}}">
                                                                <button type="button" title="{{trans('myProfile.activate')}}" class="btn btn-default btn-xs refreshicon">
                                                                    <i class="fa fa-power-off"></i>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    @else
                                                        <td width="30%">${{$AffiliatePlans->amount}}/{{trans('myProfile.year')}}</td>
                                                        <td width="5%">
                                                            <a href="{{url('stripe/Reactivate').'/'.$company->stripe_subscription_id}}">
                                                                <button type="button" title="{{trans('myProfile.de_Activate')}}" class="btn btn-default btn-xs refreshicon1">
                                                                    <i class="fa fa-power-off"></i>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <button type="button" class="admin-account-button" data-toggle="modal" data-target="#history">{{trans('myProfile.billing_history')}}</button>
                                        </div>
                                    @else
                                        <div class="col-md-4 col-xs-4 col-sm-4">
                                            <a href="{{url('plans')}}">
                                                <button type="button" class="admin-account-button">{{trans('myProfile.sign_up')}}</button>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-xs-6 col-sm-6"></div>
                                    @endif
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12 zeropadding">
                                    <div class="col-md-4 col-xs-4 col-sm-4 zeropadding">
                                        <p class="name_heading">{{trans('myProfile.samy_linkedin')}}</p>
                                    </div>
                                    @if(Auth::user()->samy_linkedIn == 1 || !empty($LinkedInPlans))
                                        <div class="col-md-4 col-xs-4 col-sm-4 name_discrip zeropadding">
                                            <p>{{$LinkedInPlans->type}}</p>
                                            <p>{{$LinkedInPlans->linkedIn_accounts}} accounts {{trans('myProfile.commission')}}</p>
                                        </div>
                                        <div class="col-md-4 col-xs-4 col-sm-4 name_discrip">
                                            @if($LinkedInPlans->term == "month")
                                                <p>${{$LinkedInPlans->amount}}/{{trans('myProfile.month')}}
                                                    <button type="button" title="{{trans('myProfile.activate')}}" class="btn btn-default btn-xs refreshicon" onclick="autorenew('{{$company->id}}',1)"><i class="fa fa-refresh"></i></button>
                                                </p>
                                            @else
                                                <p>${{$LinkedInPlans->amount}}/{{trans('myProfile.year')}}
                                                    <button type="button" title="{{trans('myProfile.activate')}}" class="btn btn-default btn-xs refreshicon" onclick="autorenew('{{$company->id}}',1)"><i class="fa fa-refresh"></i></button>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="col-md-3 col-xs-3 col-sm-3">
                                            <button type="button" class="admin-account-button" data-toggle="modal" data-target="#linkedIn_history">{{trans('myProfile.billing_history')}}</button>
                                        </div>
                                    @else
                                        <div class="col-md-4 col-xs-4 col-sm-4">
                                            <a href="#">
                                                <button type="button" class="admin-account-button">{{trans('myProfile.sign_up')}}</button>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-xs-6 col-sm-6"></div>
                                    @endif
                                </div>
                                <div class="col-md-12 col-xs-12 zeropadding">
                                    <div class="col-md-4 col-xs-4 col-sm-4 zeropadding">
                                        <p class="name_heading">{{trans('myProfile.samy_myApp')}}</p>
                                    </div>
                                    <div class="col-md-4 col-xs-4 col-sm-4">
                                        <a href="#">
                                            <button type="button" class="admin-account-button">{{trans('myProfile.sign_up')}}</button>
                                        </a>
                                    </div>
                                    <div class="col-md-4 col-xs-4 col-sm-4">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-xs-12 col-sm-12">

                            </div>
                        @endif
                    </div>
                </form>
                <div class="modal fade" id="addCard" role="dialog">
                    <div class="modal-dialog add-level-modal">
                        <div class="modal-content add-level-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <center><h2 class="modal-title">{{trans('myProfile.add_card')}}</h2></center>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{url('SavedCards/Store')}}">
                                    <center>
                                        <p class="help-block" id="card-error"></p>
                                    </center>
                                    {{csrf_field()}}
                                    <div class="form-group col-sm-12">
                                        <label>{{trans('card.card_number')}}: </label>
                                        <input type="text" class="form-control" id="cardnum" name="cardnum" placeholder="{{trans('card.card_number')}}">
                                        <input type="hidden" value="{{Auth::user()->company_id}}" name="company_id">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>{{trans('card.expire_month')}}: </label>
                                        {{--<input type="text" class="form-control" id="ExpireMonth" name="ccExpiryMonth" placeholder="{{trans('card.expire_month')}}">--}}
                                        <select class="form-control" id="ExpireMonth" name="ccExpiryMonth">
                                            <?php
                                            for ($m=1; $m<=12; $m++) {
                                                $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                                if($m < 10){
                                                    echo "<option value=\"0$m\">$month</option>";
                                                }else{
                                                    echo "<option value=\"$m\">$month</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>{{trans('card.expire_year')}}: </label>
                                        {{--<input type="text" class="form-control" id="ExpireYear" name="ccExpiryYear" placeholder="{{trans('card.expire_year')}}">--}}
                                        <select class="form-control" id="ExpireYear" name="ccExpiryYear">
                                            <?php
                                            $date_future = date("Y", strtotime('+12 year'));
                                            $date_year = date("Y");
                                            for($i=$date_year;$i<$date_future;$i++){
                                                if($date_year == $i){
                                                    echo "<option value=\"$i\" selected=\"selected\">$i</option> \n";
                                                } else {
                                                    echo "<option value=\"$i\">$i</option> \n";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>{{trans('card.cvv')}}: </label>
                                        <input type="password" class="form-control" id="cvv" name="cvvNumber" placeholder="{{trans('card.expire_year')}}">
                                    </div>
                                    <!-- Submit Field -->
                                    <div class="form-group col-sm-12">
                                        <center>
                                            <button type="button" class="btn btn-save" id="addCard-btn" onclick="validateCard()">{{trans('myProfile.save')}}</button>
                                        </center>
                                    </div>
                                </form>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal fade" id="history" role="dialog">
                    <div class="modal-dialog modal-lg add-level-modal">
                        <div class="modal-content add-level-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <center><h2 class="modal-title">{{trans('myProfile.billing_history')}}</h2></center>
                            </div>
                            <div class="modal-body table-responsive">
                                <center>
                                    @if($bills != '')
                                        <table class="col-md-12">
                                            <tbody>
                                            @foreach($bills as $bill)
                                                @if($bill->type == '1')
                                                    <?php
                                                    $payPlan = \App\Models\plantable::whereId($bill->planid)->first();
                                                    $payed_date = str_replace('/', '-', $bill->date);
                                                    ?>
                                                    <tr>
                                                        <td class="col-md-1">{{$i}}</td>
                                                        <td class="col-md-2">{{$bill->date}}</td>
                                                        <td class="col-md-2">{{$payPlan->type}}</td>
                                                        <td class="col-md-1">&dollar;{{$bill->amount}}</td>
                                                        <td class="col-md-3"><a href="{{url('invoice').'/'.$bill->id}}" class="btn btn-primaryy">{{trans('myProfile.generate_invoice')}}</a></td>
                                                    </tr>
                                                    <tr class="space-tr">
                                                        <td colspan="7"></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                    ?>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <center>
                                            <b><h4>{{trans('myProfile.no_bill')}}</h4></b>
                                        </center>
                                    @endif
                                </center>
                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal fade" id="bot_history" role="dialog">
                    <div class="modal-dialog add-level-modal">
                        <div class="modal-content add-level-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <center><h2 class="modal-title">{{trans('myProfile.details')}}</h2></center>
                            </div>
                            <div class="modal-body">
                                <center>
                                    <table style="font-size: small;">
                                        <?php
                                        $trans_ids = DB::table('bot_plans')->where('company_id',$company->id)->distinct()->get(['transaction_id']);
                                        $i = 1;
                                        ?>
                                        @foreach($trans_ids as $trans_id)
                                            <?php
                                            $j=1;
                                            $samy_bots = DB::table('bot_plans')->where('transaction_id',$trans_id->transaction_id)->where('payment_status',1)->get();
                                            ?>
                                            @foreach($samy_bots as $samy_bot)
                                                <?php
                                                $bot_plan = App\Models\SamyBotPlans::whereId($samy_bot->plan)->first();
                                                $old_date = date('d-m-Y', strtotime($samy_bot->date));
                                                $expiry_date = date('d-m-Y', strtotime($old_date. ' +30 days'));
                                                ?>
                                                <tr>
                                                    @if($j ==1)
                                                        <td width="5%">{{$i}}</td>
                                                    @else
                                                        <td width="5%"> </td>
                                                    @endif
                                                    <td width="25%">{{$bot_plan->name}}</td>
                                                    <td width="25%">Expires on {{$expiry_date}}</td>
                                                    <td width="25%">{{$samy_bot->price}}&dollar; / {{$bot_plan->term}}</td>
                                                    @if($j ==1)
                                                        <td width="10%">
                                                            <a href="{{url('samybot/invoice').'/'.$trans_id->transaction_id}}" class="btn btn-primaryy" style="vertical-align: middle;">{{trans('myProfile.generate_invoice')}}</a>
                                                    @else
                                                        <td width="10%"> </td>
                                                    @endif
                                                </tr>
                                                <?php $j++; ?>
                                            @endforeach
                                            <?php $i++; ?>
                                        @endforeach
                                    </table>
                                </center>
                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Restricts input for each element in the set of matched elements to the given inputFilter.
    (function($) {
        $.fn.inputFilter = function(inputFilter) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                }
            });
        };
    }(jQuery));

    $("#cardnum").inputFilter(function(value) {
        return /^-?\d*$/.test(value);
    });
    $("#cvv").inputFilter(function(value) {
        return /^-?\d*$/.test(value);
    });
    $("#cardnum").focusin(function() {
        $("input[id=cardnum]").attr("maxlength", "16");
    });
    $("#cvv").focusin(function() {
        $("input[id=cvv]").attr("maxlength", "4");
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var html = '<br/><img class="profile-table-img" src="' + e.target.result + '">';
                $('#image')
                    .html(html);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function validateCard() {
        if ($('#cardnum').val() == '') {
            $('#addCard-btn').prop('type', 'button');
            $('#card-error').text('{{trans('card.card_number_required')}}');
        }
        else if ($('#ExpireMonth').val() == '') {
            $('#addCard-btn').prop('type', 'button');
            $('#card-error').text('{{trans('card.expire_month_required')}}');
        }
        else if ($('#ExpireYear').val() == '') {
            $('#addCard-btn').prop('type', 'button');
            $('#card-error').text('{{trans('card.expire_year_required')}}');
        }
        else if ($('#cvv').val() == '') {
            $('#addCard-btn').prop('type', 'button');
            $('#card-error').text('{{trans('card.cvv_required')}}');
        }
        else {
            $('#addCard-btn').prop('type', 'submit');
        }
    }

    function validatePhone() {
        var phone_number = $('#phone_number').val();
        var phone_number_1 = phone_number.substring(1);
        if (/^\d+$/.test(phone_number_1) && phone_number.length > 10) {
            if (phone_number.charAt(0) == '+')
            {
                $('#invalidPhone').css('display', 'none');
                $.ajax({
                    url: "{{url('validatePhone')}}" + '/' + phone_number,
                    success: function (result) {
                        if (result == "success") {
                            $('#aff-reg-btn').prop('type', 'submit');
                            $('#invalidPhone').css('display', 'none');
                        }
                        else {
                            $('#aff-reg-btn').prop('type', 'button');
                            $('#invalidPhone').text('{{trans('phoneError.phone_exists')}}');
                            $('#invalidPhone').css('display', 'block');
                        }
                    }
                });
            }
            else
            {
                $('#aff-reg-btn').prop('type', 'button');
                $('#invalidPhone').text('{{trans('phoneError.phone_valid')}}');
                $('#invalidPhone').css('display', 'block');
            }
        }
        else {
            $('#aff-reg-btn').prop('type', 'button');
            $('#invalidPhone').text('{{trans('phoneError.phone_valid')}}');
            $('#invalidPhone').css('display', 'block');
        }

    }

    function activateCard(id) {
        if (confirm('{{trans('myProfile.activate_card')}}')) {
            $.ajax({
                url: "{{url('activateCard')}}" + "/" + id,
                success: function (result) {
                    window.location.reload();
                }
            });
        }
    }

    function autorenew(id, val) {
        if (confirm('{{trans('myProfile.sure')}}')) {
            $.ajax({
                url: "{{url('autorenew')}}" + "/" + id + "/" + val,
                success: function (result) {
                    window.location.reload();
                }
            });
        }
    }

    function checkDomain(val, id) {
        var value = val.replace(new RegExp('/', 'g'), 'QWERTY');
        $.ajax({
            url: "{{url('checkDomain')}}" + "/" + value + "/" + id,
            success: function (result) {
                if (result == 'fail') {
                    $('#domain-error').text('{{trans('myProfile.domain_taken')}}');
                    $('#btn-save-account').prop('type', 'button');
                }
                else {
                    var domain = $('#domain_name').val();
                    if (val == domain) {
                        $('#domain-error').text('{{trans('myProfile.domain_same')}}');
                        $('#btn-save-account').prop('type', 'button');
                    }
                    else {
                        $('#btn-save-account').prop('type', 'submit');
                        $('#domain-error').text('');
                    }

                }
            }
        });
    }

    function checkDomain1(val, id) {
        var value = val.replace(new RegExp('/', 'g'), 'QWERTY');
        $.ajax({
            url: "{{url('checkDomain')}}" + "/" + value + "/" + id,
            success: function (result) {
                if (result == 'fail') {
                    $('#domain-error').text('{{trans('myProfile.domain_taken')}}');
                    $('#btn-save-account').prop('type', 'button');
                }
                else {
                    $('#btn-save-account').prop('type', 'submit');
                    $('#domain-error').text('');
                }
            }
        });
    }

    function checkcompanyName(val) {
        $.ajax({
            url: "{{url('checkcompanyName')}}" + "/" + val,
            success: function (result) {
                if (result == 'fail') {
                    $('#error-company-name').text('{{trans('myProfile.name_taken')}}');
                    $('#btn-save-account').prop('type', 'button');
                }
                else {
                    $('#btn-save-account').prop('type', 'submit');
                    $('#error-company-name').text('');
                }
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQ_zcalLsl2Lrma87qgAs9QtM-0NQLmYs&libraries=places&callback=initAutocomplete"
        async defer></script>
<!--Footer section-->
@include('frontEnd.footer')

