<?php
namespace App\Helpers;

class DateFuncs 
{	
      public static function thai_date($date, $lang = 'th', $timezone = null)
      {
          $temp = explode('-', $date);
		  if(isset($temp['2']))
		  {
			  return ($temp['0']+543).'-'. $temp['1'] .'-'. $temp['2'];
		  }
          return '';
      }
}