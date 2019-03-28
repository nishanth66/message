<table class="table table-responsive display" id="packages-table">
    <thead>
        <tr>
            <th>Package Name</th>
            <th>Number of Messages Limit</th>
            <th>Initial Setup</th>
            <th>Yearly Subscription</th>
            <th>Distributor Commission</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($packages as $packages)
        <tr>
            <td>{!! $packages->package_name !!}</td>
            <td>{!! $packages->no_of_limit_messages !!}</td>
            <td>{!! $packages->initial_setup !!}</td>
            <td>{!! $packages->yearly_subscribe !!}</td>
            <td>{!! $packages->commission !!}</td>
            <td>
                {!! Form::open(['route' => ['packages.destroy', $packages->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('packages.show', [$packages->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('packages.edit', [$packages->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

