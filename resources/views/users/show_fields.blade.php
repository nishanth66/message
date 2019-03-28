
<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $users->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $users->name !!}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $users->email !!}</p>
</div>



<!-- No Of Days Field -->
<div class="form-group">
    {!! Form::label('days_remember_to_login', 'Number of days to remind:') !!}
    <p>{!! $users->days_remember_to_login !!}</p>
</div>

<!-- Subscription Field -->
<div class="form-group">
    {!! Form::label('package', 'Package:') !!}
    <p>{!! $package->package_name !!}</p>
</div>

<div class="form-group">
    {!! Form::label('package_expire', 'Package Expire:') !!}
    <p>{!! date('d/m/Y',$users->package_expire) !!}</p>
</div>

<div class="form-group">
    {!! Form::label('last_login', 'Last Login:') !!}
    <p>{!! date('d/m/Y',strtotime($users->lastLogin)) !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Joined:') !!}
    <p>{!! date('d/m/Y',strtotime($users->created_at)) !!}</p>
</div>


