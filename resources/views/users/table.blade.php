<table class="table table-responsive" id="users-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Number of days to Reminder</th>
            <th>Package</th>
            <th>Package Expire</th>
            <th>Last Login</th>
            <th>Remaining Reminder</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $users)
    <?php
    $package = \App\Models\packages::whereId($users->package)->first();
    ?>
        <tr>
            <td>{!! $users->name !!}</td>
            <td>{!! $users->email !!}</td>
            <td>{!! $users->days_remember_to_login !!}</td>
            <td>{!! $package->package_name !!}</td>
            <td>{!! date('d/m/Y',$users->package_expire) !!}</td>
            <td>{!! date('d/m/Y',strtotime($users->lastLogin)) !!}</td>
            <td>{!! $users->available_msg !!}</td>
            <td>
                {!! Form::open(['route' => ['users.destroy', $users->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('users.show', [$users->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('users.edit', [$users->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>