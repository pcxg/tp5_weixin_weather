<?php
namespace app\api\controller;

use think\Controller;

class News extends Controller
{
  	public function read()
    {
      	$id = input('id');
      	$model = model('News');
      	$data = $model->getNews($id);
      	if ($data){
        	$code = 200;
        }
      	else{
        	$code = 404;
        }
      	$data = [
        	'code' => $code,
          	'data' => $data
        ];
      
      	return json($data);
    }
}