<?php

defined('MODULE_NAME') || define('MODULE_NAME', 'm');          #module参数名定义
defined('ACTION_NAME') || define('ACTION_NAME', 'do');         #action参数名定义
defined('FILE_EXT')    || define('FILE_EXT',    '.php');       #扩展名
defined('M_DEFAULT')   || define('M_DEFAULT',   'Profile');    #默认模块
defined('ACT_DEFAULT') || define('ACT_DEFAULT', 'Index');      #默认动作

/**
 * 应用程序调度器
 */
class mvc_Dispatcher{
    static private $app   = null;
    static private $views  = null;
    static private $theme = "default";
    static private $exceptionMode = "halt";
    static public  $req	  = null;
    public function __construct(){
        if(isset($this -> app) && is_a($this -> app,'App')) {
//        	Log::w(SSO_LL_ERROR,"Object App exists already");
            throw new Exception('Object App exists already!');
        }
        $this -> app = $this;
        $this -> req = mvc_Request::getInstance();
    }
    /**
     * @desc 设置异常模式
     * @param string $mode
     */
    public function setExceptionMode($mode){
    	self::$exceptionMode = $mode;
    }
    /**
     * @desc 获取当前异常模式
     */
    public function getExceptionMode(){
    	return self::$exceptionMode;
    }
    /**
     * @desc 设置视图文件夹
     * @param string $theme 
     */
    public function setTheme($theme){
        self::$theme = $theme;
    }
    /**
     * 启动应用程序(根椐get参数调用相应的module和动作,参数只支持字母及数字)
     */
    public function run($controller = '',$doAction = ''){
        $controller = $this -> req -> get(MODULE_NAME,  $controller );
        $doAction = $this -> req -> get(ACTION_NAME, $doAction );
        $controller = $controller ? $controller : M_DEFAULT;
        $doAction	= $doAction ? $doAction : ACT_DEFAULT;
        $this->dispatch($controller,$doAction);
        
    }
	/**
	 * @desc 控制器调度器,可以选择执行某个控制器的操作函数
	 * @param $controller 控制器名称
	 * @param $doAction 控制器方法
	 * @param $clearView 是否清理之前加载的视图
	 */
    public function dispatch($controller,$doAction,$clearView = true){
    	if($clearView){
    		self::$views = null;
    	}  	
        if(preg_match('/[^0-9a-z\_]/i',$controller)) {
//        	Log::w(SSO_LL_ERROR,"Wrong request params:{$controller}");
            throw new Exception('Wrong request params!');
        }
        $mFile = UC_APP_PATH . "control/{$controller}".FILE_EXT;
        if(!file_exists($mFile)){
//        	Log::w(SSO_LL_ERROR,sprintf("Control file(%s) not found!", "control/{$controller}".FILE_EXT));
            throw new Exception(sprintf("Control file(%s) not found!", "control/{$controller}".FILE_EXT));
        }
        require_once($mFile);
        $cClassName = $controller;
        if(class_exists($cClassName)) {
           $actObj = new $cClassName;
          
           if(!method_exists($actObj,$doAction)){
//             Log::w(SSO_LL_ERROR,"Control's method($doAction) not found!");
               throw new Exception("Control's method($doAction) not found!");
           }
           else{
				try{
					$actObj -> initController();
					if(!$actObj -> preCall()){
						return false;
					}
					$actObj -> $doAction();
					$actObj -> postCall();
				}catch(Exception $e){
					//交给Controller处理异常
					$isDealException = $actObj -> handleException($e);
					//Controller不处理异常，Manager处理
					if(!$isDealException){
						throw $e;
					}
				}
           }
        }
        else {
//        	Log::w(SSO_LL_ERROR,"Control's class not found($controller)");
            throw new Exception("Control's class not found($controller)");
        }    
    }
    
    /**
     * 载入view
     * @params String $tpl 视图模板文件名
     * @return Object
     */
/*    
    public static function loadView($module,$viewName,$theme = "",$viewType = "simple"){
    	$theme = $theme ? $theme : self::$theme;
    	if(!self::$views[$viewName]){
    		if($viewType == "simple"){
    			$viewName = $viewName.".php";
    			self::$views[$viewName] = mvc_viewImpl_simple::loadView($module, $viewName, $theme);
    		}elseif($viewType == "twig"){
    			$viewName = $viewName.".tpl";
    			self::$views[$viewName] = twig_View::loadView($module, $viewName, $theme);
    		}
    	}

    	return self::$views[$viewName];
    }
    
    
    public static function showViews($tpls = array()){
    	if(!empty($tpls)){
    		foreach($tpls as $tpl){
    			if(self::$views[$tpl]){
    				self::$views[$tpl] -> show();
    			}
    		}
    	}else{
    		foreach(self::$views as $tplObj){
    			$tplObj -> show();
    		}
    	}
    }
*/    
    //fixit 出错异常
    //中止程序执行,并输出错误信息
    public static function halt($msg , $header = '',$tpl = ''){
        if($header){
            foreach($header as $k => $v){
                header("{$k}:{$v}");
            }
        }
        if($tpl){
            $v = self::loadView('halt.php');
            $v -> msg = $msg;
        }
        else{
            echo $msg;
        }
        exit;
    }
    
}
