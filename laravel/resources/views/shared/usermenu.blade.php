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
  @if($user->iwantto == "buy")
  	<li role="presentation" {{ ($setActive == "iwanttobuy")? 'class=active' : ''  }}><a href="{{ url('user/iwanttobuy') }}"> {{ trans('messages.i_want_to_buy') }}</a></li>
  @endif
  @if($user->iwantto == "sale")
  	<li role="presentation" {{ ($setActive == "iwanttosale")? 'class=active' : ''  }}><a href="{{ url('user/iwanttosale') }}"> {{ trans('messages.i_want_to_sale') }}</a></li>
  @endif
	<li role="presentation" {{ ($setActive == "matchings")? 'class=active' : ''  }} >
			<a href="{{ url('user/matchings') }}">
				{{ trans('messages.menu_matching') }}
				<span class="badge">
                           @if($user->iwantto == "buy")
                                  {{ count($Iwanttoobj->GetSaleMatchingWithBuy($user->id)) }}
                          @endif
                          @if($user->iwantto == "sale")
                                  {{ count($Iwanttoobj->GetBuyMatchingWithSale($user->id)) }}
                          @endif
                           </span>
			</a>
	</li>
</ul>
