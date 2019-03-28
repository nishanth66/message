<style>
    .mydonebtn {
        border-radius: 3px;
        box-shadow: none;
        background-color: #3c8dbc;
        border-color: #367fa9;
        color: white;
    }

    .mydonebtn:hover {
        background-color: #367fa9;
        border-color: #204d74;
        color: white;
    }
</style>
<table class="table table-responsive" id="distributors-table">
    <thead>
    <tr>
        <th>Distributor Name</th>
        <th>Email</th>
        <th>Paypal Email</th>
        <th>Invited Users</th>
        <th>Amount to be Paid</th>
        <th>Payment</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($distributors as $distributor)
        <?php
                $amount = 0;
        $user=\App\Models\users::where('email',$distributor->email)->first();
        if (isset($user->personalKey))
        $private = $user->personalKey;
        $commission_count = \Illuminate\Support\Facades\DB::table('distributor_users')->where('distributor_id',$distributor->id)->where('commission_paid',0)->count();
        if (\Illuminate\Support\Facades\DB::table('distributor_users')->where('distributor_id',$distributor->id)->exists())
        {
            $commissions = \Illuminate\Support\Facades\DB::table('distributor_users')->where('distributor_id',$distributor->id)->get();
            foreach ($commissions as $commission)
            {
                if ($commission->commission_paid == 0)
                {
                    $user = \App\User::whereId($commission->userid)->first();
                    $package = \App\Models\packages::whereId($commission->package)->first();
                    $amount +=(float)$package->commission;
                }
            }
        }
        else
        {
            $commissions = "";
        }
        ?>
        <tr>
            <td>{!! $distributor->distributor_name !!}</td>
            <td>{!! $distributor->email !!}</td>
            <td>{!! $user->paypal_email !!}</td>
            <td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#allModal{{$distributor->id}}">All</button>
                @if($commission_count>0)
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#newModal{{$distributor->id}}">New</button>
                @endif
                <div class="modal fade" id="allModal{{$distributor->id}}" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <center><h3 class="modal-title">All the Invited Users</h3></center>
                            </div>
                            <div class="modal-body">
                                <center><a href="{{url('exportAll').'/'.$distributor->id}}" class="btn btn-primary">Export PDF</a></center> <br/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table border="1" class="table table-responsive" width="100%">
                                            <thead>
                                            <tr>
                                                <th width="25%">Name</th>
                                                <th width="25%">Package</th>
                                                <th width="25%">Commission</th>
                                                <th width="25%">Paid</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($commissions != "")
                                            @foreach($commissions as $commission)
                                            <?php
                                            $user = \App\Models\users::whereId($commission->userid)->first();
                                            $package = \App\Models\packages::whereId($user->package)->first();
                                            ?>
                                            <tr>
                                                <td width="25%">{{$user->name}}</td>
                                                <td width="25%">{{$package->package_name}}</td>
                                                <td width="25%">&dollar;{{$package->commission}}</td>
                                                <td width="25%">
                                                    @if($commission->commission_paid == 0)
                                                    <i class="fa fa-close redclose"></i>
                                                    @else
                                                    <i class="fa fa-check greencheck"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4"><h4>No Users Found</h4></td>
                                            </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal fade" id="newModal{{$distributor->id}}" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <center><h3 class="modal-title">New Invited Users</h3></center>
                            </div>
                            <div class="modal-body">
                                <center><a href="{{url('exportNew').'/'.$distributor->id}}" class="btn btn-primary">Export PDF</a></center> <br/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table border="1" class="table table-responsive" width="100%">
                                            <thead>
                                            <tr>
                                                <th width="25%">Name</th>
                                                <th width="25%">Package</th>
                                                <th width="25%">Commission</th>
                                                <th width="25%">Paid</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($commissions != "")
                                            @foreach($commissions as $commission)
                                                @if($commission->commission_paid == 0)
                                                    <?php
                                                    $user = \App\Models\users::whereId($commission->userid)->first();
                                                    $package = \App\Models\packages::whereId($user->package)->first();
                                                    ?>
                                                    <tr>
                                                        <td width="25%">{{$user->name}}</td>
                                                        <td width="25%">{{$package->package_name}}</td>
                                                        <td width="25%">{{$package->commission}}</td>
                                                        <td width="25%">
                                                            @if($commission->commission_paid == 0)
                                                            <i class="fa fa-close redclose"></i>
                                                            @else
                                                            <i class="fa fa-check greencheck"></i>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4"><h4>No Users Found</h4></td>
                                            </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>

            </td>
            <td>{!! $amount !!}</td>
            <td>
                @if($commission_count>0)
                    <a href="{{url('distributorPayout').'/'.$distributor->id}}" class="btn btn-primary" onclick="return confirm('You are about to make a Payout through Paypal of Amount {{$amount}} to {{$distributor->distributor_name}}')">Pay</a>
                    <a href="{{url('distributorPayoutDone').'/'.$distributor->id}}" class="btn btn-default" onclick="return confirm('You are about to mark the Pending payment as Done')">Done</a>
                @else
                    <i class="fa fa-check greencheck"></i>
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['distributors.destroy', $distributor->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('distributors.show', [$distributor->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('distributors.edit', [$distributor->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    function paymentmade(id) {
        $.ajax({
            url: '{{url('Updatedistributorpay')}}' + '/' + id,
            success: function (data) {
                console.log(data);
                window.location.reload();
            }
        });

    }
</script>