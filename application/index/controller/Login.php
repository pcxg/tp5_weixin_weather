<?php
namespace app\index\controller;
 
use think\Controller;
use think\Db;
 
class Login extends Controller
{
    public function index()
    {
      	return $this->fetch();
    }
      // 处理登录逻辑
    public function doLogin()
    {
    	$param = input('post.');
    	if(empty($param['user_name'])){
    		
    		$this->error('用户名不能为空');
    	}
    	
    	if(empty($param['user_pwd'])){
    		
    		$this->error('密码不能为空');
    	}
    	
    	// 验证用户名
    	$has = db('users')->where('user_name', $param['user_name'])->find();
    	if(empty($has)){
    		
    		$this->error('用户名密码错误');
    	}
    	
    	// 验证密码
    	if($has['user_pwd'] != md5($param['user_pwd'])){
    		
    		$this->error('用户名密码错误');
    	}
    	
    	// 记录用户登录信息
    	cookie('user_id', $has['id'], 3600);  // 一个小时有效期
    	cookie('user_name', $has['user_name'], 3600);
    	
    	$this->redirect(url('index/index'));
    }
  
      // 退出登录
    public function loginOut()
    {
    	cookie('user_id', null);
    	cookie('user_name', null);
    	
    	$this->redirect(url('login/index'));
    }
  
	//注册用户
  	public function register()
    {
      	return $this->fetch();
    }
  
  	public function doRegister()
    {
      $param = input('post.');
      if(empty($param['user_name'])){
    	$this->error('用户名不能为空');
      }
      if(empty($param['user_pwd'])){
    	$this->error('密码不能为空');
      }
      $has = db('users')->where('user_name', $param['user_name'])->find();
      
      if($has){
      	$this->error('用户名重复');
      }
      
      else{
        Db::execute('insert into users (user_name, user_pwd) values (:name, :pwd)',['name'=>$param['user_name'],'pwd'=>md5($param['user_pwd'])]);
        
      }
      
      // 记录用户登录信息
    	cookie('user_id', $has['id'], 3600);  // 一个小时有效期
		cookie('user_name', $param['user_name'], 3600);
    	
    	$this->redirect(url('index/index'));
    }
}
