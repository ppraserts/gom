<?php
       use App\Iwantto;
	$user = auth()->guard('user')->user();

       $Iwanttoobj = new Iwantto();
?>
<ul class="nav nav-tabs">
  <li role="presentation" {{ ($setActive == "userprofiles")? 'class=active' : ''  }} ><a href="{{ url('user/userprofiles') }}">{{ trans('messages.userprofile') }}</a></li>
  <li role="presentation" {{ ($setActive == "changepasswords")? 'class=active' : ''  }} ><a href="{{ url('user/changepasswords') }}">{{ trans('messages.menu_changepassword') }}</a></li>
  <li role="presentation" {{ ($setActive == "inboxmessage")? 'class=active' : ''  }}><a href="{{ url('user/inboxmessage') }}">
  		{{ trans('messages.inbox_message') }}
  		<span class="badge">0</span>
  		</a>
  </li>
  @if($user->iwanttobuy == "buy")
  	<li role="presentation" {{ ($setActive == "iwanttobuy")? 'class=active' : ''  }}><a href="{{ url('user/iwanttobuy') }}"> {{ trans('messages.i_want_to_buy') }}</a></li>
  @endif
  @if($user->iwanttosale == "sale")
  	<li role="presentation" {{ ($setActive == "iwanttosale")? 'class=active' : ''  }}><a href="{{ url('user/iwanttosale') }}"> {{ trans('messages.i_want_to_sale') }}</a></li>
  @endif
	<li role="presentation" {{ ($setActive == "matchings")? 'class=active' : ''  }} >
			<a href="{{ url('user/matchings') }}">
				{{ trans('messages.menu_matching') }}
				<span class="badge">
                           @if(($user->iwanttobuy == "buy")&&($user->iwanttosale == "sale"))
                                  {{ count($Iwanttoobj->GetSaleMatchingWithBuy($user->id,Request::input('orderby'))) + count($Iwanttoobj->GetBuyMatchingWithSale($user->id,Request::input('orderby'))) }}
                          @endif
                          @if(($user->iwanttobuy == "buy")&&($user->iwanttosale == ""))
                                  {{ count($Iwanttoobj->GetSaleMatchingWithBuy($user->id,Request::input('orderby'))) }}
                          @endif
                          @if(($user->iwanttobuy == "")&&($user->iwanttosale == "sale"))
                                  {{ count($Iwanttoobj->GetBuyMatchingWithSale($user->id,Request::input('orderby'))) }}
                          @endif
                           </span>
			</a>
	</li>
    <li role="presentation" {{ ($setActive == "shopsetting")? 'class=active' : ''  }}><a href="{{ url('user/shopsetting') }}"> {{ trans('messages.shop_setting') }}</a></li>
</ul>
