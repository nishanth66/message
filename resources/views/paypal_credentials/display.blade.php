@extends('layouts.app')
@section('css')
@endsection
@if(Auth::user()->status == 'admin')
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Paypal Credentials</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('paypalCredentials.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
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
                    @foreach($credit as $paypalCredentials)
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
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection
@endif
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#paypalCredentials-table').DataTable( {
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

