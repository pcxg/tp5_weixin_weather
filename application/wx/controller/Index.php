<?php
namespace app\wx\controller;

class Index
{
    public function index()
    {
        $this->createmenu();
    }



    function getToken(){
        return $this->checkAccessToken("wx3b8926fde68a4907","00d504c382ba26b9ea4d20e49e1b3b3f");
    }



    function checkAccessToken($appid,$appsecret){
        $condition = array('appid'=>$appid,'appsecret'=>$appsecret);
        $access_token_set=DB('wxtoken')->where($condition)->find();//获取数据

        if($access_token_set){
            //检查是否超时，超时了重新获取
            if($access_token_set['AccessExpires']>time()){
                //未超时，直接返回access_token
                return $access_token_set['access_token'];
            }else{
                //已超时，重新获取
                $url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
                $json= $this->https_request($url_get);
                var_dump($json);
                $access_token=$json['access_token'];
                $AccessExpires=time()+intval($json['expires_in']);
                $data['access_token']=$access_token;
                $data['AccessExpires']=$AccessExpires;
                $result = DB('wxtoken')->where($condition)->update($data);//更新数据
                if($result){
                    return $access_token;
                }else{
                    return $access_token;
                }
            }
        }else{
          	echo "appid或appsecret不正确";
            return false;
        }
    }


    function https_request ($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $out = curl_exec($ch);
        curl_close($ch);
        return  json_decode($out,true);
    }
  
  
  	public function createmenu(){
      	$data='{
        "button":[
       {
            "type":"click",
            "name":"今日天气",
            "key":"V1001_TODAY_MUSIC"
        },
        {
             "name":"菜单",
             "sub_button":[
             {
                 "type":"view",
                 "name":"天气界面",
                 "url":"http://188.131.154.107/wx/loc_wea.php"
              },
              {
                 "type":"click",
                 "name":"赞一下我们",
                 "key":"V1001_GOOD"
              }]
         }]
      }';
        $access_token=$this->getToken();
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
        var_dump($url);
        var_dump($data);
        $result= $this->postcurl($url,$data);
        var_dump($result);
    }


    function postcurl($url,$data = null){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return 	$output=json_decode($output,true);
    }
  	
    public function getuser(){
    	 $access_token=$this->getToken();
   		 $url_get='https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$access_token;
         $user_json= $this->https_request($url_get);
         //var_dump($json);
    	 $url_get='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$user_json['data']['openid'][0].'&lang=zh_CN';
    	 $user_info= $this->https_request($url_get);
         var_dump("<img src=".$user_info['headimgurl'].">");
  	}
}