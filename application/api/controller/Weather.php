<?php

namespace app\api\controller;

use think\Controller;

class Weather extends Controller
{
    public function read()
    {
        $citycode = input('id');
        $model = model('Weather');
        $data = $model->getNews($citycode);
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
