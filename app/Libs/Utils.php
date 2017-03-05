<?php
namespace App\Libs;
use Carbon\Carbon;

class Util
{
    public static function agoDateWriting($date)
    {
        switch (true) {
        	case ($date->diffInSeconds(Carbon::now()) < 60):
        		return $date->diffInSeconds(Carbon::now()) . '秒前';
        	case ($date->diffInMinutes(Carbon::now()) < 60):
        		return $date->diffInMinutes(Carbon::now()) . '分前';
        	case ($date->diffInHours(Carbon::now()) < 24):
        		return $date->diffInHours(Carbon::now()) . '時間前';
        	case ($date->diffInDays(Carbon::now()) <  31):
        		return $date->diffInDays(Carbon::now()) . '日前';
        	case ($date->diffInMonths(Carbon::now()) < 12):
        		return $date->diffInMonths(Carbon::now()) . 'ヶ月前';
        	default:
        		return $date;
        }

    }


}