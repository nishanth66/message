@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Paypal Credentials</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('paypalClientCredentials.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body scrollable">
                <table class="table table-responsive" id="paypalDtl-table">
                    <thead>
                    <tr>
                        <th>Client ID</th>
                        <th>Client Secrete</th>
                        <th>Mode</th>
                        <th>Currency</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($paypals as $paypal)
                        <tr>
                            <td>{!! $paypal->client_id !!}</td>
                            <td>{!! $paypal->client_secrete !!}</td>
                            <td>
                                @if($paypal->mode == '0')
                                    {{'SandBox'}}
                                @else
                                    {{'Live'}}
                                @endif
                            </td>
                            <td>{{$paypal->currency}}</td>
                            <td>
                                @if($paypal->status == 1)
                                    <p class="activePaypal">Active</p>
                                @else
                                    <a href="{{url('activateCard').'/'.$paypal->id}}" type="button" class="btn btn-warning">Activate</a>
                                @endif
                            </td>
                            <td>
                                @if($paypal->status == 1)
                                    <div class='btn-group'>
                                        <a href="{!! route('paypalClientCredentials.edit', [$paypal->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                        <button type="button" class="btn btn-danger btn-xs disabledBtn"><i class="glyphicon glyphicon-trash"></i></button>
                                    </div>
                                @else
                                    {!! Form::open(['route' => ['paypalClientCredentials.destroy', $paypal->id], 'method' => 'delete']) !!}
                                    <div class='btn-group'>
                                        <a href="{!! route('paypalClientCredentials.edit', [$paypal->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                    </div>
                                    {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center">
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $('#paypalDtl-table').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, ':visible' ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                ]
            } );
        } );
        // $(document).ready(function() {
        //     $('#paypalCredentials-table').DataTable();
        // } );
    </script>
@endsection

