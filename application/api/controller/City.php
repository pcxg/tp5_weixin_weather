<?php
namespace app\api\controller;

use think\Controller;

class City extends Controller
{
    public function read()
    {
        $name = input('id');
      	//dump($name);
        $model = model('City');
        $data = $model->getNews($name);
        if ($data) {
            $code = 200;
        } else {
            $code = 404;
        }
        $data = [
            'code' => $code,
            'data' => $data
        ];
        return json($data);
    }
}