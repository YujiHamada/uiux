<?php
namespace App\Libs;
use phpQuery;
use App\Libs\Util;

class Scraping
{
    public static function ogp($url){
        try{
            $html = file_get_contents($url);
            $dom = phpQuery::newDocument(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

            $imageUrl = "";
            $title = "";
            $description = "";
            $fileName = "";
            foreach($dom->find('meta') as $meta){
                if($meta->getAttribute('property') == "og:image"){
                    $imageUrl = $meta->getAttribute('content');
                    $image = file_get_contents($imageUrl);
                    if($image){
                        $d =date("YmdHis");
                        $fileName = $d . '_' . md5($imageUrl);
                        $e = Util::compressImage($imageUrl, \Config::get('const.REVIEW_URL_IMAGES_DIRECTORY') . $fileName, 60);
                        $fileName = $fileName . $e;
                    }
                }

                if($meta->getAttribute('property') == "og:title"){
                    $title = $meta->getAttribute('content');
                }

                if($meta->getAttribute('property') == "og:description"){
                    $description = $meta->getAttribute('content');
                }
            }

            return array("fileName" => $fileName, 'title' => $title, 'description' => $description);
        }catch(\Exception $e){
            // スクレイピング中にエラーが発生したら空の値を返す。スクレイピング自体は重要でないので、念のためこのような処理にしておく。不要なtry catchだったら削除する。
            return array("fileName" => '', 'title' => '', 'description' => '');
        }
    }
}