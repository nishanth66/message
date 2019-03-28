<table class="table table-responsive" id="adddistributors-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Mail</th>
        <th>Code</th>
        <th>Comission</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($adddistributors as $adddistributor)
        <tr>
            <td>{!! $adddistributor->name !!}</td>
            <td>{!! $adddistributor->mail !!}</td>
            <td>{!! $adddistributor->code !!}</td>
            <td>{!! $adddistributor->comission !!}</td>
            <td>
                {!! Form::open(['route' => ['adddistributors.destroy', $adddistributor->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('adddistributors.show', [$adddistributor->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('adddistributors.edit', [$adddistributor->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>