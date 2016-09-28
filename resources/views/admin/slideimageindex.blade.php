<?php
$url = "admin/productcategory";
$pagetitle = trans('messages.menu_slide_image');
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-picture"></i>')
@section('section')
<div class="col-sm-12">
  <div class="row">
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
                          <th>{{ Lang::get('validation.attributes.slideimage_type') }}</th>
                          <th>{{ Lang::get('validation.attributes.slideimage_name') }}</th>
                          <th>{{ Lang::get('validation.attributes.sequence') }}</th>
                          <th width="150px" style="text-align:center;">
                            <a class="btn btn-success" href="{{ route('slideimage.create') }}">
                              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a>
                          </th>
                      </tr>
                    </thead>
                    <tbody>
                @foreach ($items as $key => $item)
                      <tr>
                          <td>{{ ++$i }}</td>
                          <td><?php
                                  if($item->slideimage_type == "AS")
                                    echo "Activity Slide";
                                  else
                                    echo "Banner Slide"; 
                              ?></td>
                          <td>{{ $item->slideimage_name }}</td>
                          <td>{{ $item->sequence }}</td>
                          <td style="text-align:center;">
                              <a target="_bank" class="btn btn-info" href="{{ URL::asset($item->slideimage_file) }}">
                                <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                              </a>
                              <a class="btn btn-primary" href="{{ route('slideimage.edit',$item->id) }}">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                              </a>
                              <?php
                                $confirmdelete = trans('messages.confirm_delete', ['attribute' => $item->slideimage_name]);
                              ?>
                              {!! Form::open(['method' => 'DELETE','route' => ['slideimage.destroy', $item->id],'style'=>'display:inline']) !!}

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
