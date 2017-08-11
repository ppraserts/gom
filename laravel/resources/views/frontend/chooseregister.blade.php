@extends('layouts.main')

@section('content')
<div class="row marketmenuboxs">
  <div class="col-md-6 col-sm-6">
      <div class="thumbnail">
          <div class="caption">
              <h3>{{ trans('messages.membertype_individual') }}</h3>
              <p>
                  <a href="{{ url('/user/register') }}" class="btn btn-primary">
                      <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{ trans('messages.menu_register') }}
                  </a>
              </p>
          </div>
      </div>
  </div>
  <div class="col-md-6 col-sm-6">
      <div class="thumbnail">
          <div class="caption">
              <h3>{{ trans('messages.membertype_company') }}</h3>
              <p>
                  <a href="{{ url('/user/companyregister') }}" class="btn btn-primary">
                      <span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{ trans('messages.menu_register') }}
                  </a>
              </p>
          </div>
      </div>
  </div>
</div>
@endsection
