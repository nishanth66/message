@extends('layouts.app')
@section('css')
@endsection
@if(Auth::user()->status == 'admin')
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Packages</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('packages.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body scrollable">
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
                    @foreach($data as $packages)
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
            $('#packages-table').DataTable( {
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

