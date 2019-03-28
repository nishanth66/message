@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{asset('public/css/singlestyle.css')}}">
    <style>
        .content1
        {
            min-height: 250px;
            padding: 15px;
            margin-right: auto;
            margin-left: auto;
            padding-left: 15px;
            padding-right: 15px;
        }
        .pricingTable .amount
        {
            font-size: 28px !important;
        }

    </style>
@endsection
<?php
$msg = DB::table('changePackage')->whereId(1)->first();
$id = Auth::user()->id;
$details = App\Models\paypalCredentials::where('user_id',$id)->orderby('id','desc')->first();
$packages = App\Models\packages::get();
$packages55 = \App\Models\packages::whereId(Auth::user()->package)->first();
$packagesArray = App\Models\packages::where('id','!=',$packages55->id)->get();
$countries = array("AF" => "Afghanistan",
    "AX" => "Åland Islands",
    "AL" => "Albania",
    "DZ" => "Algeria",
    "AS" => "American Samoa",
    "AD" => "Andorra",
    "AO" => "Angola",
    "AI" => "Anguilla",
    "AQ" => "Antarctica",
    "AG" => "Antigua and Barbuda",
    "AR" => "Argentina",
    "AM" => "Armenia",
    "AW" => "Aruba",
    "AU" => "Australia",
    "AT" => "Austria",
    "AZ" => "Azerbaijan",
    "BS" => "Bahamas",
    "BH" => "Bahrain",
    "BD" => "Bangladesh",
    "BB" => "Barbados",
    "BY" => "Belarus",
    "BE" => "Belgium",
    "BZ" => "Belize",
    "BJ" => "Benin",
    "BM" => "Bermuda",
    "BT" => "Bhutan",
    "BO" => "Bolivia",
    "BA" => "Bosnia and Herzegovina",
    "BW" => "Botswana",
    "BV" => "Bouvet Island",
    "BR" => "Brazil",
    "IO" => "British Indian Ocean Territory",
    "BN" => "Brunei Darussalam",
    "BG" => "Bulgaria",
    "BF" => "Burkina Faso",
    "BI" => "Burundi",
    "KH" => "Cambodia",
    "CM" => "Cameroon",
    "CA" => "Canada",
    "CV" => "Cape Verde",
    "KY" => "Cayman Islands",
    "CF" => "Central African Republic",
    "TD" => "Chad",
    "CL" => "Chile",
    "CN" => "China",
    "CX" => "Christmas Island",
    "CC" => "Cocos (Keeling) Islands",
    "CO" => "Colombia",
    "KM" => "Comoros",
    "CG" => "Congo",
    "CD" => "Congo, The Democratic Republic of The",
    "CK" => "Cook Islands",
    "CR" => "Costa Rica",
    "CI" => "Cote D'ivoire",
    "HR" => "Croatia",
    "CU" => "Cuba",
    "CY" => "Cyprus",
    "CZ" => "Czech Republic",
    "DK" => "Denmark",
    "DJ" => "Djibouti",
    "DM" => "Dominica",
    "DO" => "Dominican Republic",
    "EC" => "Ecuador",
    "EG" => "Egypt",
    "SV" => "El Salvador",
    "GQ" => "Equatorial Guinea",
    "ER" => "Eritrea",
    "EE" => "Estonia",
    "ET" => "Ethiopia",
    "FK" => "Falkland Islands (Malvinas)",
    "FO" => "Faroe Islands",
    "FJ" => "Fiji",
    "FI" => "Finland",
    "FR" => "France",
    "GF" => "French Guiana",
    "PF" => "French Polynesia",
    "TF" => "French Southern Territories",
    "GA" => "Gabon",
    "GM" => "Gambia",
    "GE" => "Georgia",
    "DE" => "Germany",
    "GH" => "Ghana",
    "GI" => "Gibraltar",
    "GR" => "Greece",
    "GL" => "Greenland",
    "GD" => "Grenada",
    "GP" => "Guadeloupe",
    "GU" => "Guam",
    "GT" => "Guatemala",
    "GG" => "Guernsey",
    "GN" => "Guinea",
    "GW" => "Guinea-bissau",
    "GY" => "Guyana",
    "HT" => "Haiti",
    "HM" => "Heard Island and Mcdonald Islands",
    "VA" => "Holy See (Vatican City State)",
    "HN" => "Honduras",
    "HK" => "Hong Kong",
    "HU" => "Hungary",
    "IS" => "Iceland",
    "IN" => "India",
    "ID" => "Indonesia",
    "IR" => "Iran, Islamic Republic of",
    "IQ" => "Iraq",
    "IE" => "Ireland",
    "IM" => "Isle of Man",
    "IL" => "Israel",
    "IT" => "Italy",
    "JM" => "Jamaica",
    "JP" => "Japan",
    "JE" => "Jersey",
    "JO" => "Jordan",
    "KZ" => "Kazakhstan",
    "KE" => "Kenya",
    "KI" => "Kiribati",
    "KP" => "Korea, Democratic People's Republic of",
    "KR" => "Korea, Republic of",
    "KW" => "Kuwait",
    "KG" => "Kyrgyzstan",
    "LA" => "Lao People's Democratic Republic",
    "LV" => "Latvia",
    "LB" => "Lebanon",
    "LS" => "Lesotho",
    "LR" => "Liberia",
    "LY" => "Libyan Arab Jamahiriya",
    "LI" => "Liechtenstein",
    "LT" => "Lithuania",
    "LU" => "Luxembourg",
    "MO" => "Macao",
    "MK" => "Macedonia, The Former Yugoslav Republic of",
    "MG" => "Madagascar",
    "MW" => "Malawi",
    "MY" => "Malaysia",
    "MV" => "Maldives",
    "ML" => "Mali",
    "MT" => "Malta",
    "MH" => "Marshall Islands",
    "MQ" => "Martinique",
    "MR" => "Mauritania",
    "MU" => "Mauritius",
    "YT" => "Mayotte",
    "MX" => "Mexico",
    "FM" => "Micronesia, Federated States of",
    "MD" => "Moldova, Republic of",
    "MC" => "Monaco",
    "MN" => "Mongolia",
    "ME" => "Montenegro",
    "MS" => "Montserrat",
    "MA" => "Morocco",
    "MZ" => "Mozambique",
    "MM" => "Myanmar",
    "NA" => "Namibia",
    "NR" => "Nauru",
    "NP" => "Nepal",
    "NL" => "Netherlands",
    "AN" => "Netherlands Antilles",
    "NC" => "New Caledonia",
    "NZ" => "New Zealand",
    "NI" => "Nicaragua",
    "NE" => "Niger",
    "NG" => "Nigeria",
    "NU" => "Niue",
    "NF" => "Norfolk Island",
    "MP" => "Northern Mariana Islands",
    "NO" => "Norway",
    "OM" => "Oman",
    "PK" => "Pakistan",
    "PW" => "Palau",
    "PS" => "Palestinian Territory, Occupied",
    "PA" => "Panama",
    "PG" => "Papua New Guinea",
    "PY" => "Paraguay",
    "PE" => "Peru",
    "PH" => "Philippines",
    "PN" => "Pitcairn",
    "PL" => "Poland",
    "PT" => "Portugal",
    "PR" => "Puerto Rico",
    "QA" => "Qatar",
    "RE" => "Reunion",
    "RO" => "Romania",
    "RU" => "Russian Federation",
    "RW" => "Rwanda",
    "SH" => "Saint Helena",
    "KN" => "Saint Kitts and Nevis",
    "LC" => "Saint Lucia",
    "PM" => "Saint Pierre and Miquelon",
    "VC" => "Saint Vincent and The Grenadines",
    "WS" => "Samoa",
    "SM" => "San Marino",
    "ST" => "Sao Tome and Principe",
    "SA" => "Saudi Arabia",
    "SN" => "Senegal",
    "RS" => "Serbia",
    "SC" => "Seychelles",
    "SL" => "Sierra Leone",
    "SG" => "Singapore",
    "SK" => "Slovakia",
    "SI" => "Slovenia",
    "SB" => "Solomon Islands",
    "SO" => "Somalia",
    "ZA" => "South Africa",
    "GS" => "South Georgia and The South Sandwich Islands",
    "ES" => "Spain",
    "LK" => "Sri Lanka",
    "SD" => "Sudan",
    "SR" => "Suriname",
    "SJ" => "Svalbard and Jan Mayen",
    "SZ" => "Swaziland",
    "SE" => "Sweden",
    "CH" => "Switzerland",
    "SY" => "Syrian Arab Republic",
    "TW" => "Taiwan, Province of China",
    "TJ" => "Tajikistan",
    "TZ" => "Tanzania, United Republic of",
    "TH" => "Thailand",
    "TL" => "Timor-leste",
    "TG" => "Togo",
    "TK" => "Tokelau",
    "TO" => "Tonga",
    "TT" => "Trinidad and Tobago",
    "TN" => "Tunisia",
    "TR" => "Turkey",
    "TM" => "Turkmenistan",
    "TC" => "Turks and Caicos Islands",
    "TV" => "Tuvalu",
    "UG" => "Uganda",
    "UA" => "Ukraine",
    "AE" => "United Arab Emirates",
    "GB" => "United Kingdom",
    "US" => "United States",
    "UM" => "United States Minor Outlying Islands",
    "UY" => "Uruguay",
    "UZ" => "Uzbekistan",
    "VU" => "Vanuatu",
    "VE" => "Venezuela",
    "VN" => "Viet Nam",
    "VG" => "Virgin Islands, British",
    "VI" => "Virgin Islands, U.S.",
    "WF" => "Wallis and Futuna",
    "EH" => "Western Sahara",
    "YE" => "Yemen",
    "ZM" => "Zambia",
    "ZW" => "Zimbabwe");

$mil1 = time();
$d1 = date("d-m-Y", $mil1);
$mil2 = Auth::user()->package_expire;
$d2= date("d-m-Y", $mil2);
$date1=date_create($d1);
$date2=date_create($d2);
$diff=date_diff($date1,$date2);
$day = $diff->format("%a");
if ($day > 365)
{
    $day = 365;
}
?>
@section('content')
    <div class="content1">
    @include('adminlte-templates::common.errors')
    <div class="box box-primary">
    <div class="box-body">
    @if ($message = Session::get('error'))
        <div class="custom-alerts alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {!! $message !!}
        </div>
        <?php
        Session::forget('error');
        ?>
    @endif
    <div class="row">



        <div id="test3">
            <div class="content1">
                <center>
                    <h3>Current Package Details</h3>
                    <table width="75%">
                        <thead>
                            <tr class="package-change-header-tr">
                                <th class="change-package-header-th" width="20%">Current Package</th>
                                <th class="change-package-header-th" width="20%">Amount Paid</th>
                                <th class="change-package-header-th" width="20%">Initail Charge</th>
                                <th class="change-package-header-th" width="20%">Reminders</th>
                                <th class="change-package-header-th" width="20%">Days left</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="package-change-body-tr">
                                <td class="change-package-body-td">{{$packages55->package_name}}</td>
                                <td class="change-package-body-td">{{number_format($packages55->yearly_subscribe)}}</td>
                                <td class="change-package-body-td">{{number_format($packages55->initial_setup)}}</td>
                                <td class="change-package-body-td">{{$packages55->no_of_limit_messages}}</td>
                                <td class="change-package-body-td">{{$day}}</td>
                            </tr>
                        </tbody>
                    </table>
                </center>
                <center>
                    <input type="hidden" id="package88" name="package88">
                    <h3 class="change-package-table">Select a Package to Change</h3>
                    <table width="90%">
                        <thead>
                            <tr class="package-change-header-tr">
                                <th class="change-package-header-th" width="20%">Package</th>
                                <th class="change-package-header-th" width="18%">Amount</th>
                                <th class="change-package-header-th" width="15%">Reminders</th>
                                <th class="change-package-header-th" width="15%">Initial Charge</th>
                                <th class="change-package-header-th" width="20%">Total Amount to Pay</th>
                                <th class="change-package-header-th" width="17%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($packagesArray as $package)
                            <?php
                            if ($day > 0) {
                                $diff = ($day * (float)$package->yearly_subscribe) / 365;
                                $amt = number_format($diff,'2');
                            }
                            elseif ($day <= 0)
                            {
                                $day = 0;
                                $amt = $packages55->yearly_subscribe;
                            }
                            if ($packages55->yearly_subscribe >= $package->yearly_subscribe)
                            {
                                $amt=0;
                            }
                            ?>
                            <tr class="package-change-body-tr">
                                <td class="change-package-body-td">{{$package->package_name}}</td>
                                <td class="change-package-body-td">{{number_format($package->yearly_subscribe)}}</td>
                                <td class="change-package-body-td">{{$package->no_of_limit_messages}}</td>
                                <td class="change-package-body-td">{{number_format($package->initial_setup)}}</td>
                                <td class="change-package-body-td">{{$amt}}</td>
                                <td class="change-package-body-td"><button type="button" class="pricingTable-signup123 type-none-admin-home" id="btnMg{{$package->id}}" data-pkg-id="{{$package->id}}">Select</button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </center>
                <div class="row">
                    <center>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="changeBtn" onclick="changePackage({{$id}})">Proceed</button>
                            <a href="{{url('CancelChange').'/'.$id}}"><button type="button" class="btn btn-default">Cancel</button></a>
                        </div>
                    </center>
                </div>
            </div>
        </div>












        <div id="test4">
            <form method="post" action="{{url('paypal')}}">
                {{csrf_field()}}
                <div class="form-group col-sm-6 required">
                    <label>Name:</label>
                    <input type="text" name="name" value="{{$users->name}}" autofocus class="form-control" required>
                </div>
                <div class="form-group col-sm-6 required">
                    <label>Email:</label>
                    <input type="text" name="email" value="{{$users->email}}" autofocus class="form-control" required>
                </div>
                <div class="form-group col-sm-6 required">
                    <label>Phone:</label>
                    <input type="text" name="phone" value="{{$details->phone}}" autofocus class="form-control" required>
                </div>
                <div class="form-group col-sm-6 required">
                    <label>Street and house number:</label>
                    <input type="text" name="street" value="{{$details->street}}" autofocus class="form-control" required>
                </div>
                <div class="form-group col-sm-6 required">
                    <label>Country:</label>
                    <select id="country" type="text" class="form-control" name="country" autofocus required>
                        <option value="" selected disabled>Select a Country
                        </option>
                        @foreach($countries as $key => $value)
                            <option value="{{$value}}" <?php if ($details->country == $value) { echo "selected"; } ?>>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-6 required">
                    <label>City:</label>
                    <input type="text" name="city" value="{{$details->city}}" autofocus class="form-control" required>
                </div>
                <div class="form-group col-sm-6 required">
                    <label>Zip Code:</label>
                    <input type="text" name="post" value="{{$details->zipcode}}" autofocus class="form-control" required>
                </div>
                <div class="form-group col-sm-6 required">
                    <label>Package:</label>
                    <input type="text" readonly id="package4" name="package4" class="form-control" value="">
                    <input type="hidden" readonly id="package" name="package" class="form-control" value="">
                </div>
                <div class="form-group col-sm-6 required paymentDiv">
                    <label>Initial Setup:</label>
                    <input type="text" readonly id="initial" name="initial" value="" autofocus class="form-control" required>
                </div>
                <input type="hidden" name="type" value="new">
                <input type="hidden" name="reason" value="change">
                <div class="form-group col-sm-6 required">
                    <label>Yearly Subscription:</label>
                    <input type="text" readonly id="amount" name="amount" value="" autofocus class="form-control" required>
                    <input type="hidden" readonly id="pending" name="pending" value="0" autofocus class="form-control" required>
                    <input type="hidden" readonly id="advance" name="advance" value="0" autofocus class="form-control" required>
                </div>
                <div class="form-group col-sm-6 required">
                    <label>Total Amount:</label>
                    <input type="text" readonly id="total" name="total" value="" autofocus class="form-control" required>
                </div>
                <div class="form-group col-sm-12">
                    <button type="button" data-toggle="modal" data-target="#myModal" value="" id="changeBtns" class="btn btn-primary"></button>
                    <a href="{{url('CancelChange').'/'.$id}}"><button type="button" class="btn btn-default">Cancel</button></a>
                </div>
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Change Package</h4>
                            </div>
                            <div class="modal-body">
                                <p>{{$msg->message}}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="submit" value="" id="changeBtns1">I Agree</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
//        $(function () {
          $('button.type-none-admin-home').on('click',function () {
                var val = $(this).attr('id');
                var pkg_id = $(this).attr('data-pkg-id');
//                console.log(val);
                if($('#'+val).hasClass('active-package')){
                    $(this).removeClass('active-package');
                    $(this).text('select');
                    $('#package88').val("");
                }
                else{
                    $('.type-none-admin-home').removeClass('active-package')
                    $('.type-none-admin-home').text('select')
                    $(this).addClass('active-package');
                    $(this).text('selected');
                    $('#package88').val(pkg_id);
                }
            });
//        });
        function changePackage(val) {
            var package = $('#package88').val();
            if (package == '')
            {
                alert("Please Select a Package to Proceed");
            }
            else
            {
                $.ajax({
                    url: '{{url('changeData')}}' + '/' + val+'/'+package,
                    success: function (result) {
                        $('#package4').val(result[1]);
                        $('#package').val(result[0]);
                        $('#initial').val(result[2]);
                        $('#amount').val(result[3]);
                        $('#total').val('$'+result[4]);
                        $('#changeBtns').text(result[5]);
                        if (result[5] == 'Change the Subscription')
                        {
                            $('#changeBtns').val("no payment");
                            $('#changeBtns1').val("no payment");
                        }
                        else
                        {
                            $('#changeBtns').val("payment");
                            $('#changeBtns1').val("payment");
                        }
                        $('#test3').hide();
                        $('#test4').show();
                    }
                });
            }

        }
    </script>
@endsection