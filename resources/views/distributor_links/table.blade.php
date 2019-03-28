<table class="table table-responsive" id="distributorLinks-table">
    <thead>
        <tr>
            <th>Name</th>
        <th>Package</th>
        <th>Price</th>
        <th>Commission</th>
        <th>Link</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($distributorLinks as $distributorLink)
        <?php
            $package = \App\Models\packages::whereId($distributorLink->package)->first();
        ?>
        <tr>
            <td>{!! $distributorLink->name !!}</td>
            <td>{!! $package->package_name !!}</td>
            <td>{!! $distributorLink->price !!}</td>
            <td>{!! $distributorLink->commission !!}</td>
            <td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#linkModal{{$distributorLink->id}}">Link</button></td>
            <td>
                {!! Form::open(['route' => ['distributorLinks.destroy', $distributorLink->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('distributorLinks.show', [$distributorLink->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('distributorLinks.edit', [$distributorLink->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    <button type="button" class="btn btn-success btn-xs" title="share the link" data-toggle="modal" data-target="#shareLink{{$distributorLink->id}}"><i class="fa fa-share-alt"></i></button>
                </div>
                {!! Form::close() !!}
            </td>

            <div class="modal fade" id="linkModal{{$distributorLink->id}}" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content link-modal">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <center><h4 class="modal-title">Link</h4></center>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                        <h5>{{$distributorLink->link}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal fade" id="shareLink{{$distributorLink->id}}" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content link-modal">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <center><h4 class="modal-title">Share Link</h4></center>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form method="post" action="{{url('share/link')}}">
                                    {{csrf_field()}}
                                    <div class="form-group col-sm-12">
                                        <label>Name: </label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter the name">
                                        <input type="hidden" class="form-control" name="linkid" value="{{$distributorLink->id}}">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <lable>Email: </lable>
                                        <input type="email" class="form-control" name="email" placeholder="Enter the email address to send">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary">Send</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>

                </div>
            </div>

        </tr>
    @endforeach
    </tbody>
</table>