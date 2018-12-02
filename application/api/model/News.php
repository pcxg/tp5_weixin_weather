<?php
namespace app\api\model;

use think\Model;
use think\Db;

class News extends Model
{
	public function getNews($id = 1)
    {
    	$res = Db::name('news')->where('id',$id)->select();
      	return $res;
    }
  
	public function getNewsList()
    {
      	$res = Db::name('news')->select();
      	return $res;
    }
}