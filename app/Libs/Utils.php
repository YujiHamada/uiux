<?php
namespace App\Libs;
use Carbon\Carbon;

class Util {
    public static function agoDateWriting($date) {
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

    public static function compressImage($source, $destination, $quality) {

        $info = getimagesize($source);
        $image;
        $e;

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
            $e = '.jpg';
            imagejpeg($image, $destination . $e, $quality);
        }

        elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source);
            $e = '.gif';
            imagegif($image, $destination . $e, $quality);
        }

        elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
            $e = '.png';
            imagepng($image, $destination . $e, $quality);
        }

        return $e;
    }

    public static function postTypeHashTag($type) {
        if (\Config::get('enum.type.GOOD_UX') == $type) {
            return \Config::get('const.GOOD_UX_HASH_TAG');
        } elseif (\Config::get('enum.type.KAIZEN_UX') == $type) {
            return \Config::get('const.KAIZEN_UX_HASH_TAG');
        } elseif (\Config::get('enum.type.OPINION') == $type) {
            return \Config::get('const.OPINION_UX_HASH_TAG');
        }else {
            return \Config::get('const.REQUEST_REVIEW_UX_HASH_TAG');
        }
    }
}