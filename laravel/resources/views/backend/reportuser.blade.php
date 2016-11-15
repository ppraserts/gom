<?php
$pagetitle = trans('messages.menu_report');
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-stats"></i>')
@section('section')
<a class="btn btn-default" href="#" role="button" onclick="window.print();">
  <span class="glyphicon glyphicon-print"></span> {{ trans('messages.reportuser_print') }}
</a>
<h3>{{ trans('messages.reportuser_head') }}{{ Lang::get('validation.attributes.users_province') }}</h3>
<table class="table table-bordered table-striped">
  <colgroup>
    <col class="col-xs-4">
    <col class="col-xs-8">
  </colgroup>
  <thead>
    <tr>
      <th>{{ Lang::get('validation.attributes.users_province') }}</th>
      <th>{{ trans('messages.tablehead_amount') }}</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach((array)$resultsG1 as $div_item)
    {
    ?>
    <tr>
      <th scope="row">
        {{ $div_item->users_province }}
      </th>
      <td>{{ $div_item->countuser }}</td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<h3>{{ trans('messages.reportuser_head') }}{{ trans('messages.reportuser_member') }}</h3>
<table class="table table-bordered table-striped">
  <colgroup>
    <col class="col-xs-4">
    <col class="col-xs-8">
  </colgroup>
  <thead>
    <tr>
      <th>{{ trans('messages.reportuser_member') }}</th>
      <th>{{ trans('messages.tablehead_amount') }}</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach((array)$resultsG2 as $div_item)
    {
    ?>
    <tr>
      <th scope="row">
        {{ $div_item->users_membertype }}
      </th>
      <td>{{ $div_item->countuser }}</td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<h3>{{ trans('messages.reportuser_head') }}{{ trans('messages.reportuser_buysale') }}</h3>
<table class="table table-bordered table-striped">
  <colgroup>
    <col class="col-xs-4">
    <col class="col-xs-8">
  </colgroup>
  <thead>
    <tr>
      <th>{{ trans('messages.reportuser_buysale') }}</th>
      <th>{{ trans('messages.tablehead_amount') }}</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach((array)$resultsG3 as $div_item)
    {
    ?>
    <tr>
      <th scope="row">
        {{ $div_item->iwantto }}
      </th>
      <td>{{ $div_item->countuser }}</td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<h3>{{ trans('messages.reportuser_matching') }}</h3>
<table class="table table-bordered table-striped">
  <colgroup>
    <col class="col-xs-4">
    <col class="col-xs-8">
  </colgroup>
  <thead>
    <tr>
      <th>{{ trans('messages.reportuser_buysale') }}</th>
      <th>{{ trans('messages.tablehead_amount') }}</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">
        Sale
      </th>
      <td>{{ count($itemssale) }}</td>
    </tr>
    <tr>
      <th scope="row">
        Buy
      </th>
      <td>{{ count($itemsbuy) }}</td>
    </tr>
  </tbody>
</table>
@endsection
