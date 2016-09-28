<?php
$url = "admin/contactusform";
$pagetitle = trans('messages.menu_contactus');
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-edit"></i>')
@section('section')

<div class="col-sm-12">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <ul class="nav nav-tabs">
          <li ><a href="{{ url ('admin/contactus') }}" >{{ trans('messages.menu_contactusinfo') }}</a>
          </li>
          <li class="active"><a href="{{ url ('admin/contactusform') }}" >{{ trans('messages.menu_contactusform') }}</a>
          </li>
      </ul>
    </div>
  </div>
  <div class="row" style="margin-top:10px;">
  	<div class="col-sm-12">
      @if ($message = Session::get('success'))
          <div class="alert alert-success">
              <p>{{ $message }}</p>
          </div>
      @endif
      <div class="panel panel-default">
        <div class="panel-body">
              {!! Form::open(['method'=>'GET','url'=>$url,'class'=>'','role'=>'search'])  !!}
              <div class="input-group custom-search-form">
                  <input type="text" id="search" name="search" class="form-control" placeholder="{{ trans('messages.search') }}
...">
                  <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">
                          <i class="fa fa-search"></i>
                      </button>
                  </span>
              </div>
              {!! Form::close() !!}
              <p></p>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                          <th>{{ trans('messages.no') }}</th>
                          <th>{{ Lang::get('validation.attributes.created_at') }}</th>
                          <th>{{ Lang::get('validation.attributes.contactusform_subject') }}</th>
                          <th>{{ Lang::get('validation.attributes.contactusform_messagebox') }}</th>
                          <th>{{ Lang::get('validation.attributes.contactusform_name') }} - {{ Lang::get('validation.attributes.contactusform_surname') }}</th>
                          <th>{{ Lang::get('validation.attributes.contactusform_email') }}</th>
                          <th>{{ Lang::get('validation.attributes.contactusform_phone') }}</th>
                          <th width="130px" style="text-align:center;">
                          </th>
                      </tr>
                    </thead>
                    <tbody>
                @foreach ($items as $key => $item)
                      <tr>
                          <td>{{ ++$i }}</td>
                          <td>{{ $item->created_at }}</td>
                          <td>{{ $item->contactusform_subject }}</td>
                          <td>{{ $item->contactusform_messagebox }}</td>
                          <td>{{ $item->contactusform_name }} {{ $item->contactusform_surname }}</td>
                          <td>{{ $item->contactusform_email }}</td>
                          <td>{{ $item->contactusform_phone }}</td>
                          <td style="text-align:center;">
                              <?php
                              if($item->contactusform_file != "")
                              {
                              ?>
                                <a target="_bank" class="btn btn-info" href="{{ URL::asset($item->contactusform_file) }}">
                                  <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                                </a>
                              <?php
                              }
                              ?>
                              <?php
                                $confirmdelete = trans('messages.confirm_delete', ['attribute' => $item->productcategory_title_th]);
                              ?>
                              {!! Form::open(['method' => 'DELETE','route' => ['contactusform.destroy', $item->id],'style'=>'display:inline']) !!}

                              <button onclick="return confirm('{{$confirmdelete}}');"  class="btn btn-danger" type="submit">
                                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                              </button>

                              {!! Form::close() !!}
                          </td>
                      </tr>
                @endforeach
                    </tbody>
                </table>
              </div>

              {!! $items->render() !!}
        </div>
		  </div>
    </div>
  </div>
</div>
@endsection
