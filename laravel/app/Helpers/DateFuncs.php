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

    public static function convertDateToMysqlDate($date)
    {
        if ($date != NULL && $date != '') {
            return date('Y-m-d', strtotime($date));
        } else {
            return "";
        }
    }

    public static function convertDateTimeToMysqlDateTime($dateTime)
    {
        if ($dateTime != NULL && $dateTime != '') {
            return date('Y-m-d H:i:s', strtotime($dateTime));
        } else {
            return "";
        }
    }

    public static function convertThaiDateToMysql($thaiDate)
    {
        if ($thaiDate != null && $thaiDate != '') {
            $thaiDate = self::convertYear($thaiDate);
            return self::convertDateToMysqlDate($thaiDate);
        }
        return '';
    }

    public static function convertToThaiDate($date)
    {
        if ($date != null && $date != '') {
            $date_formatted = date("Y-m-d", strtotime($date));
            $thaiDate = self::thai_date($date_formatted);
           // dump(date("Y-m-d", strtotime($date)));
            return $thaiDate;
        }
        return '';
    }
}