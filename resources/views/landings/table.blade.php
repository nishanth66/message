<table class="table table-responsive" id="landings-table">
    <thead>
        <tr>
            <th>Page Text</th>
        <th>Email</th>
        <th>Address</th>
        <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($landings as $landing)
        <tr>
            <td>{!! $landing->page_text !!}</td>
            <td>{!! $landing->email !!}</td>
            <td>{!! $landing->Address !!}</td>
            <td>{!! $landing->Phone !!}</td>
            <td>
                {!! Form::open(['route' => ['landings.destroy', $landing->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('landings.show', [$landing->id]) !!}"><button type="button" class="btn btn-info">View</button> </a>
<!--                    <a href="{!! route('landings.edit', [$landing->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>-->
<!--                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}-->
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>