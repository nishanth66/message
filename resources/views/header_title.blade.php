@extends('layouts.app')
@if(Auth::user()->status == 'admin')
    <?php

    ?>
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Header Titles</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <table class="table table-responsive" id="header_title">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($header as $menu)
                        <tr>
                            <td>{!! $menu->id !!}</td>
                            <td>{!! $menu->title !!}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit{{$menu->id}}"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                        <div class="modal" id="edit{{$menu->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form method="post" action="{{url('editHeader')}}">
                                    {{csrf_field()}}
                                    <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row">
                                                <center><h3>Edit Header Titles:<br></h3></center>
                                                <div class="col-md-12">
                                                    <label>Title:</label>
                                                    <input type="text" name="title" value="{{$menu->title}}" class="form-control">
                                                    <input type="hidden" name="id" value="{{$menu->id}}">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
            $('#header_title').DataTable( {
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
    </script>
@endsection

