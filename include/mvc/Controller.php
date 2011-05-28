<?php
/**
 * 控制器基类
 */
class mvc_Controller{
    protected $req;
    
	public function __construct(){
		
	}
	
    /**
     * 是否已用post方式提交过
     * @return boolean
     */
     public function isPost(){
        return $this -> req -> getPost() ? true : false;
     }
     
     /*
      * @desc 控制器方法前置调用
      * @return boolean , false 表示终止程序，true表示继续执行
      */
     public function preCall(){
		return true;
     }
     
     /*
      * @desc 控制器方法后置调用
      * 
      */     
     public function postCall(){
     	
     }
     /**
      * @desc 初始化控制器
      *   * 加载处理请求参数的对象
      */
     public function initController(){
		$this -> req = mvc_Request::getInstance();
     }
     
     /*
      * @desc 异常处理方法
      * 
      */
     public function handleException($e = ''){
     	return false;
     }
     
}