<?php
	$user = auth()->guard('user')->user();
?>
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="{{ url('user/userprofile') }}">{{ trans('messages.userprofile') }}</a></li>
  <li role="presentation"><a href="{{ url('user/changepassword') }}">{{ trans('messages.menu_changepassword') }}</a></li>
  <li role="presentation"><a href="{{ url('user/inboxmessage') }}">
  		{{ trans('messages.inbox_message') }} 
  		<span class="badge">0</span>
  		</a>
  </li>
  @if($user->iwantto == "buy")
  	<li role="presentation"><a href="{{ url('user/iwanttobuy') }}">{{ trans('messages.i_want_to_buy') }}</a></li>
  @endif
  @if($user->iwantto == "sale")
  	<li role="presentation"><a href="{{ url('user/iwanttosale') }}">{{ trans('messages.i_want_to_sale') }}</a></li>
  @endif
</ul>
