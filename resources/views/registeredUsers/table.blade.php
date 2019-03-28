<table class="table table-responsive" id="regUsers-table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Package</th>
        <th>Registered Date</th>
        <th>Distributor Code</th>
        <th>Last Logged In</th>
        <th>Acount Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($registered_user as $user)
        <?php
            $time = strtotime($user->created_at);
            $date = date("d-m-Y", $time);
        ?>
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->package}}</td>
            <td>{{$date}}</td>
            <td>{{$user->distributor_code}}</td>
            <td>{{date('d-m-Y',$user->lastUpdated)}}</td>
            @if($user->type == 'active')
                <td><font color="#006400">{{$user->type}}</font></td>
            @elseif($user->type == 'disabled')
                <td><font color="red">{{$user->type}}</font></td>
            @endif
            <td><a href="{{url('view/user').'/'.$user->id}}"><button type="button" class="btn btn-info">View</button></a></td>
        </tr>
    @endforeach
    </tbody>
</table>