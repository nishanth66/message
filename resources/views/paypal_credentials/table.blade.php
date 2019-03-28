<table class="table table-responsive" id="paypalCredentials-table">
    <thead>
        <tr>
            <th>Client Id</th>
        <th>Secret Id</th>
        <th>Mode</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($paypalCredentials as $paypalCredentials)
        <tr>
            <td>{!! $paypalCredentials->client_id !!}</td>
            <td>{!! $paypalCredentials->secret_id !!}</td>
            <td>{!! $paypalCredentials->mode !!}</td>
            <td>
                {!! Form::open(['route' => ['paypalCredentials.destroy', $paypalCredentials->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('paypalCredentials.show', [$paypalCredentials->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('paypalCredentials.edit', [$paypalCredentials->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>