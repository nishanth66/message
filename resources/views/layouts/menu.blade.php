{{--<li class="{{ Request::is('users*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>Users</span></a>--}}
{{--</li>--}}

@if(Auth::user()->status == 'admin')
<li class="{{ Request::is('packages*')|| Request::is('Userpackages*') ? 'active' : '' }}">
    <a href="{!! url('Userpackages') !!}"><i class="fa fa-gift"></i><span>Packages</span></a>
</li>

<li class="{{ Request::is('distributors*') ? 'active' : '' }}">
    <a href="{!! route('distributors.index') !!}"><i class="fa fa-users"></i><span>Distributors</span></a>
</li>

<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-users"></i><span>Users</span></a>
</li>

<li class="{{ Request::is('paypalClientCredentials*') ? 'active' : '' }}">
    <a href="{!! route('paypalClientCredentials.index') !!}"><i class="fa fa-paypal"></i><span>Paypal Credentials</span></a>
</li>

<li class="{{ Request::is('rememberMessage*') ? 'active' : '' }}">
    <a href="{!! route('rememberMessage.index') !!}"><i class="fa fa-comment-o"></i><span>Remember Message</span></a>
</li>


<li class="{{ Request::is('landings*') ? 'active' : '' }}">
    <a href="{!! route('landings.index') !!}"><i class="fa fa-home"></i><span>Landings</span></a>
</li>

{{--<li class="{{ Request::is('distributors*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('distributors.index') !!}"><i class="fa fa-credit-card"></i><span>Distributor's Payment</span></a>--}}
{{--</li>--}}
<li class="{{ Request::is('Messages*') ? 'active' : '' }}">
    <a href="{!! url('Messages') !!}"><i class="fa fa-comment"></i><span>Messages</span></a>
</li>
<li class="{{ Request::is('Headers*') ? 'active' : '' }}">
    <a href="{!! url('Headers') !!}"><i class="fa fa-header"></i><span>Headers</span></a>
</li>
<li class="{{ Request::is('SocialLink*') ? 'active' : '' }}">
    <a href="{!! url('SocialLink') !!}"><i class="fa fa-external-link"></i><span>SocialLink</span></a>
</li>

<li class="{{ Request::is('set/disable*') || Request::is('edit/disable*')? 'active' : '' }}">
    <a href="{!! url('set/disable/time') !!}"><i class="fa fa-bell"></i><span>Disable Timings</span></a>
</li>
<li class="{{ Request::is('disabled/user*') ? 'active' : '' }}">
    <a href="{!! url('disabled/users') !!}"><i class="fa fa-user"></i><span>Disabled Users</span></a>
</li>
<li class="{{ Request::is('change/pakage*') ? 'active' : '' }}">
    <a href="{!! url('change/pakage/message') !!}"><i class="fa fa-user"></i><span>Package Change Message</span></a>
</li>
@elseif(Auth::user()->status == 'distributor' && Auth::user()->type == 'active')
    <li class="{{ Request::is('registered*') || Request::is('view/user*') ? 'active' : '' }}">
        <a href="{!! url('registered/users') !!}"><i class="fa fa-user"></i><span>Registered Users</span></a>
    </li>
    <li class="{{ Request::is('distributorLinks*') ? 'active' : '' }}">
        <a href="{!! route('distributorLinks.index') !!}"><i class="fa fa-link"></i><span>Invitation Links</span></a>
    </li>
@elseif(Auth::user()->status == 'user' && Auth::user()->type== 'active')
    <li class="{{ Request::is('usermessages*') ? 'active' : '' }}">
        <a href="{!! route('usermessages.index') !!}"><i class="fa fa-comment"></i><span>Scheduled Messages</span></a>
    </li>
@endif

{{--@else--}}
{{--@endif--}}
