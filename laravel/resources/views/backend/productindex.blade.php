<?php
use App\ProductCategory;
$url = "admin/product";
$productcategoryItem = ProductCategory::find($_REQUEST["productcategory"]);
$pagetitle = trans('messages.menu_product')." ($productcategoryItem->productcategory_title_th)"
?>
@extends('layouts.dashboard')
@section('page_heading',$pagetitle)
@section('page_heading_image','<i class="glyphicon glyphicon-apple"></i>')
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
                  <input type="hidden" id="productcategory" name="productcategory" value="<?php echo $_REQUEST["productcategory"]; ?>" />
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
                          <th>{{ Lang::get('validation.attributes.product_name_th') }}</th>
                          <th>{{ Lang::get('validation.attributes.product_name_en') }}</th>
                          <th>{{ Lang::get('validation.attributes.sequence') }}</th>
                          <th width="130px" style="text-align:center;">
                            <a class="btn btn-success" href="{{ url ('admin/product/create?productcategory='.$_REQUEST['productcategory']) }}">
                              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a>
                          </th>
                      </tr>
                    </thead>
                    <tbody>
                @foreach ($items as $key => $item)
                      <tr>
                          <td>{{ ++$i }}</td>
                          <td>{{ $item->product_name_th }}</td>
                          <td>{{ $item->product_name_en }}</td>
                          <td>{{ $item->sequence }}</td>
                          <td style="text-align:center;">
                              <a class="btn btn-primary" href="{{ url ('admin/product/'.$item->id.'/edit?productcategory='.$_REQUEST['productcategory']) }}">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                              </a>
                              <?php
                                $confirmdelete = trans('messages.confirm_delete', ['attribute' => $item->product_question_th]);
                              ?>
                              {!! Form::open(['method' => 'DELETE','route' => ['product.destroy', $item->id],'style'=>'display:inline']) !!}
                              <input type="hidden" id="productcategory" name="productcategory" value="<?php echo $_REQUEST["productcategory"]; ?>" />
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

              {!! $items->appends(['productcategory' => Request::input('productcategory')])->render() !!}
        </div>
		  </div>
    </div>
  </div>
</div>
@endsection
