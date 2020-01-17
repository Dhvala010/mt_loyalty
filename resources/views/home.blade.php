@extends('adminlte::page')

@section('title', 'Loyalt | Home')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
        @can('admin module')
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fas fa-fw fa-user "></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Users</span>
              <span class="info-box-number">{{totaluser()}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        @endcan
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fas fa-store"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Stores</span>
              <span class="info-box-number">{{totalstore()}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>


        <!-- /.col -->
      </div>
@stop
