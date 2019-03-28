@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Distributor Link
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($distributorLink, ['route' => ['distributorLinks.update', $distributorLink->id], 'method' => 'patch']) !!}

                        @include('distributor_links.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection