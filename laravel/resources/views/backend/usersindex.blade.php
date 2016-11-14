<?php
$url = "admin/users";
$pagetitle = trans('messages.menu_user');
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="fa fa-user fa-fw"></i>')
@section('section')

<div class="col-sm-12">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <ul class="nav nav-tabs">
          <li class="active">
                  <a href="{{ url ('admin/users') }}" >
                        {{ trans('messages.membertype_individual') }}
                        <span class="badge">{{ $countinactiveusers }}</span>
                  </a>
          </li>
          <li >
                  <a href="{{ url ('admin/companys') }}" >
                      {{ trans('messages.membertype_company') }}
                      <span class="badge">{{ $countinactivecompanyusers }}</span>
                    </a>
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
                          <th>{{ Lang::get('validation.attributes.iwantto') }}</th>
                          <th>{{ Lang::get('validation.attributes.users_firstname_th') }} - {{ Lang::get('validation.attributes.users_lastname_th') }}</th>
                          <th>{{ Lang::get('validation.attributes.users_firstname_en') }} - {{ Lang::get('validation.attributes.users_lastname_en') }}</th>
                          <th>{{ Lang::get('validation.attributes.email') }}</th>
                          <th width="130px" style="text-align:center;">
                          </th>
                      </tr>
                    </thead>
                    <tbody>
                @foreach ($items as $key => $item)
                      <tr class="{{ $item->is_active == 0? 'danger' : '' }}">
                          <td>{{ ++$i }}</td>
                          <td>{{ $item->iwanttosale }} {{ $item->iwanttobuy }}</td>
                          <td>{{ $item->users_firstname_th }} {{ $item->users_lastname_th }}</td>
                          <td>{{ $item->users_firstname_en }} {{ $item->users_lastname_en }}</td>
                          <td>{{ $item->email }}</td>
                          <td style="text-align:center;">
                              <a class="btn btn-primary" href="{{ route('users.edit',$item->id) }}">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                              </a>
                              <?php
                                $confirmdelete = trans('messages.confirm_delete', ['attribute' => $item->users_firstname_th]);
                              ?>
                              {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $item->id],'style'=>'display:inline']) !!}

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
