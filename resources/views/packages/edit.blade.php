@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Packages
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($packages, ['route' => ['packages.update', $packages->id], 'method' => 'patch']) !!}
                   <div class="form-group col-sm-12">
                       {!! Form::label('package_name', 'Package Name:') !!}
                       {!! Form::text('package_name', $packages->package_name, ['class' => 'form-control','placeholder' => 'Package Name']) !!}
                   </div>

                   <div class="form-group col-sm-12">
                       {!! Form::label('package_class', 'Package Class:') !!}
                       <select name="package_class" class="form-control">
                           <option value="" selected disabled>Please select a class</option>
                           <option value="standard" <?php if ($packages->package_class == 'standard'){ echo "selected";}?>>STANDARD</option>
                           <option value="business" <?php if ($packages->package_class == 'business'){ echo "selected";} ?>>BUSINESS</option>
                       </select>
                   </div>
                   <!-- Amount Field -->
                   <div class="form-group col-sm-12">
                       {!! Form::label('no_of_limit_messages', 'Number of Messages Limit:') !!}
                       {!! Form::number('no_of_limit_messages', $packages->no_of_limit_messages, ['class' => 'form-control','placeholder' => 'Maximum number of Messages']) !!}
                   </div>

                   <!-- Setup Charges Field -->
                   <div class="form-group col-sm-12">
                       {!! Form::label('initial_setup', 'Initial Setup:') !!}
                       {!! Form::text('initial_setup', $packages->initial_setup, ['class' => 'form-control','placeholder' => 'Monthly Subscription']) !!}
                   </div>

                   <!-- Qty Of Alarms Field -->
                   <div class="form-group col-sm-12">
                       {!! Form::label('yearly_subscribe', 'Yearly Subscription:') !!}
                       {!! Form::number('yearly_subscribe', $packages->yearly_subscribe, ['class' => 'form-control','placeholder' => 'Yearly Subscription']) !!}
                   </div>
                   <div class="form-group col-sm-12">
                       {!! Form::label('commission', "Distributor's Commission:") !!}
                       {!! Form::number('commission', $packages->commission, ['class' => 'form-control','placeholder' => "Distributor's Commission"]) !!}
                   </div>

                   <div class="form-group col-sm-12">
                       {!! Form::label('features', 'Special Features:') !!}
                       <textarea name="features" class="form-control" cols="50" rows="5" placeholder="Please Enter each features seperated by comma">{{$packages->features}}</textarea>
                   </div>

                   <!-- Submit Field -->
                   <div class="form-group col-sm-12">
                       {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                       <a href="{!! route('packages.index') !!}" class="btn btn-default">Cancel</a>
                   </div>
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection