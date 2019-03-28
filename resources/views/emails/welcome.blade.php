@if (isset($data['id']))
    @if(isset($data['msg']))
        @if($data['msgType'] == 0)
            <body style="width: 100%;line-height: 25px;background-color: #eff0f7">
                <div style="padding-top: 5%;padding-bottom: 5%;">
                    {{$data['msg']}}
                </div>
            </body>
        @else
            <body style="width: 100%;line-height: 25px;background-color: #eff0f7">
                <div style="padding-top: 5%;padding-bottom: 5%;">
                    {{$data['msg']}}<br/>
                    <p>Click Below to Login to Messenger</p>
                    <a href="{{url('login')}}"><button type="button" style="background-color: #ff5722;color: white;border: 1px solid gray;cursor: pointer;height: 30px;">Login</button></a>
                </div>
            </body>
        @endif
    @else
        <body style="width: 100%;line-height: 25px;background-color: #eff0f7">
            <div style="padding-top: 5%;padding-bottom: 5%;">
                <p>Did You Forget To Login?</p>
            </div>
        </body>
    @endif
@endif
@if (isset($input['name']))
    <body style="width: 100%;line-height: 25px;background-color: #eff0f7">
        <div style="padding-top: 5%;padding-bottom: 5%;">
            <?php
               echo 'Hello '.$input['dname'].', A new User ('.$input['name'].') registered using Your code '.$input['dcode'].'. Please Login for the further information'
            ?>
        </div>
    </body>
@endif

