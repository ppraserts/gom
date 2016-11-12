<?php
  if($useritem->iwantto == "sale")
      $activemenu = "iwanttosale";
  else
      $activemenu = "iwanttobuy";
?>
@extends('layouts.main')
@section('content')
@include('shared.usermenu', array('setActive'=>$activemenu))
<br/>
@stop