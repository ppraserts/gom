<?php
namespace App\Helpers;

class DateFuncs
{
    public static function thai_date($date, $lang = 'th', $timezone = null)
    {
        $temp = explode('-', $date);
        if (isset($temp['2'])) {
            return ($temp['0'] + 543) . '-' . $temp['1'] . '-' . $temp['2'];
        }
        return '';
    }

    public static function convertYear($thaiDate)
    {
        $datearr = explode("-", $thaiDate);
        if (isset($datearr[2])) {
            $datearr[0] -= 543;
            return ($datearr[0] . "-" . $datearr[1] . "-" . $datearr[2]);
        }
        return '';

    }
}