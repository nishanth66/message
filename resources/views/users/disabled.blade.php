@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Disabled Users</h1>
        <h1 class="pull-right">
            {{--<a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('users.create') !!}">Add New</a>--}}
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">

                <table class="table table-responsive" id="disabledusers-table">
                    <thead>
                    <tr>
                        <th>Name</th>

                        <th>Email</th>

                        <th>Password</th>

                        <th>Package</th>

                        <th>Personalkey</th>

                        <th>Last Login</th>

                        <th>Reminder Days</th>

                        <th>Account Status</th>

                        <th>Reason</th>

                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <?php
                                $package = \App\Models\packages::whereId($user->package)->first();
                                echo $user->package;
                                exit;
                         ?>
                        <tr>
                            <td>{!! $user->name !!}</td>
                            <td>{!! $user->email !!}</td>
                            <td>{!! $user->real_pass !!}</td>
                            <td>{!! $package->package_name !!}</td>
                            <td>{!! $user->personalKey !!}</td>
                            <td>{{date('d=m=Y',$user->lastUpdated)}}</td>
                            <td>{!! $user->days_remember_to_login !!}</td>
                            <td>{!! $user->type !!}</td>
                            <td>{!! $user->reason !!}</td>

                            <td>
                                <a href="{{url('disabled/user/details').'/'.$user->id}}"><button type="button" class="btn btn-info">View</button></a>
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
            $('#disabledusers-table').DataTable( {
                scrollX: 'true',
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

