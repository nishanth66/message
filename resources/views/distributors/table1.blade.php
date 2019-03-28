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
        <th>Amount</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($distributors as $distributor)
        <tr>
            <td>{!! $distributor->distributor_name !!}</td>
            <td>{!! $distributor->email !!}</td>
            <td>${!! $distributor->amount !!}</td>
            <?php
            if ($distributor->status == 'paid'){
            ?>
            <td>{!! $distributor->status !!}</td>
            <?php
            }
            else{
            ?>
            <td><input type="button" class="mydonebtn" name="save" value="Done"
                       onclick="paymentmade(<?php echo $distributor->id; ?>)"></td>
            <?php
            }
            ?>
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