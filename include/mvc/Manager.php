<?php

class mvc_Manager{
	
	private static $_instance;
	public static function getInstance() {
		if ( ! isset(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public static function initDispatcher($conf,$theme = "default",$exceptionMode = "halt"){
		$dis = new mvc_Dispatcher();
		$dis->conf = env_Config::getAppConf($conf);
		if($theme){
			$dis->setTheme($theme);
		}
		if($exceptionMode){
			$dis->setExceptionMode($exceptionMode);
		}	    	   
	    return $dis;
	}
	
	public static function dealException($exceptionMode,$e,$callback = null){
		if($exceptionMode == "halt"){
			env_Runtime::recExcetpion($e);
			env_Runtime::flush();
			//输出异常
			if($callback && function_exists($callback)){
				call_user_func($callback,$e);
			}else{
				echo $e->getMessage();
			}
			exit;
			
		}
		if($exceptionMode == "throw"){
			//向外抛出异常
			throw $e;
		}
		if($exceptionMode == "ignore"){
			//不处理异常
		}
	}	
	
}
