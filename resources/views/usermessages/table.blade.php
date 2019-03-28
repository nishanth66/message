<?php
$userquery=\App\Models\usermessage::whereUserid(Auth::user()->id)->get();
$i =1;
?>
<table class="table table-responsive" id="usermessages-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Message</th>
            <th>Days</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($userquery as $usermessage)
        <?php
        $msg = $usermessage->message;
        $encrypted=hex2bin($msg);
        openssl_private_decrypt($encrypted, $decrypted, $private_key);
        ?>
        @if($usermessage->disabled == 1)
            <tr class="msgDisabled" title="Message Got Disabled as its been Already Used">
                {{--@if(isset($usermessage->message))--}}
                <td>{{$i}}</td>
                <td>{!! $decrypted !!}</td>
                <td>
                    {!! Form::open(['route' => ['usermessages.destroy', $usermessage->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <button type="button" class='btn btn-default btn-xs msgDisabled'><i class="glyphicon glyphicon-eye-open"></i></button>
                        <button type="button" class='btn btn-default btn-xs msgDisabled'><i class="glyphicon glyphicon-edit"></i></button>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'button', 'class' => 'btn btn-danger btn-xs msgDisabled']) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
                {{--@endif--}}
            </tr>
        @else
            <tr>
                {{--@if(isset($usermessage->message))--}}
                <td>{{$i}}</td>
                <td>{!! $decrypted !!}</td>
                <td>{!! $usermessage->day !!} Days</td>
                <td>
                    {!! Form::open(['route' => ['usermessages.destroy', $usermessage->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('usermessages.show', [$usermessage->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('usermessages.edit', [$usermessage->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
                {{--@endif--}}
            </tr>
        @endif
        <?php
            $i++;
        ?>
    @endforeach
    </tbody>
</table>