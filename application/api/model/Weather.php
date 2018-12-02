<?php
namespace app\api\model;

use think\Db;
use think\Model;

class Weather extends Model{
	protected $table = "weather_info";
  
  	public function getNews($citycode = "北京")
    {
    	$res = Db::name('weather_info')->where('citycode',$citycode)->column('weainfo');
      	return $res;
    }
}