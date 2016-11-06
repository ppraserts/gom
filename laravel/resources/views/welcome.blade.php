@extends('layouts.main')
@section('content')
   <!-- Search -->
                <div class="row searchboxs">
                    <form class="form-inline">
                        <div class="form-group">
                            <select class="form-control">
                                <option>{{ trans('messages.menu_product_category') }}</option>
                                @foreach ($productCategoryitem as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->{ "productcategory_title_".Lang::locale()} }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-info">{{ trans('messages.menu_search') }}</button>
                    </form>
                </div>
                <!-- End Search -->
                <!-- Menu3 -->
                <h1 class="one"><span>{{ trans('messages.i_want_to_buy') }}</span></h1>
                <div class="row marketmenuboxs">
                  @foreach ($marketItem as $key => $item)
                          <div class="col-md-4 col-sm-6">
                              <div class="thumbnail">
                                  <img src="{{ $item->marketimage_file }}" alt="">
                                  <div class="caption">
                                      <h3>{{ $item->{ "market_title_".Lang::locale()} }}</h3>
                                      <p>{{ $item->{ "market_description_".Lang::locale()} }}</p>
                                      <p>
                                          <a href="#" class="btn btn-primary">
                                              <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> {{ trans('messages.menu_loginmarket') }}
                                          </a>
                                      </p>
                                  </div>
                              </div>
                          </div>
                    @endforeach
                </div>

	    <h1 class="one"><span>{{ trans('messages.i_want_to_sale') }}</span></h1>
                  <div class="row marketmenuboxs">
                  @foreach ($marketItem as $key => $item)
                          <div class="col-md-4 col-sm-6">
                              <div class="thumbnail">
                                  <img src="{{ $item->marketimage_file }}" alt="">
                                  <div class="caption">
                                      <h3>{{ $item->{ "market_title_".Lang::locale()} }}</h3>
                                      <p>{{ $item->{ "market_description_".Lang::locale()} }}</p>
                                      <p>
                                          <a href="#" class="btn btn-primary">
                                              <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> {{ trans('messages.menu_loginmarket') }}
                                          </a>
                                      </p>
                                  </div>
                              </div>
                          </div>
                    @endforeach
                </div>
                <!-- End Menu3 -->
 @stop
