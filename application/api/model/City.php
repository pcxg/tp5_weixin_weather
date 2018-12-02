<?php
namespace app\api\model;

use think\Model;
use think\Db;

class City extends Model
{
	public function getNews($name = "北京")
    {
    	$res = Db::name('ins_county')->where('county_name',$name)->column('weather_code');
      	return $res;
    }
  
}