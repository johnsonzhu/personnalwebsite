<?php

/**
 * 视图输出类
 */
class mvc_viewImpl_simple{

	private $_module;
	private $_viewName;
	private $_theme;
	private $_viewType;
	private $_vFile;
	
	/**
	 * @desc 加载视图
	 * @param unknown_type $module
	 * @param unknown_type $viewName
	 * @param unknown_type $theme
	 */
	public static function loadView($module, $viewName, $theme = 'default') {
		$r = new mvc_viewImpl_simple();
		$r->_module = $module;
		$r->_viewName = $viewName;
		$r->_theme = $theme;
		$r->setView($viewName,$theme,$module);
		return $r;
	}
    /**
     * @desc 获取视图路径
     * @param 视图主题名称 $theme
     * @return string 视图路径
     */
    public static function getThemePath($theme){
    	$themePath = env_Config::getAppConf("themepath");
    	if($themePath[$theme]){
    		return $themePath[$theme];
    	}else{
            throw new Exception("View theme not found($theme)");
    	}
    }
    
	
    /**
     * 设置视图模板文件
     */
    public function setView($viewName,$theme = 'default'){
    	$this -> _vFile = self::getThemePath($theme).$viewName.".php";
        if(!file_exists($this -> _vFile)){
//            Log::w(SSO_LL_ERROR,"Template({$viewFile}) not found in this theme({$theme})({$this -> vFile})");
            throw new Exception("Template({$this -> _vFile}) not found");
        }
    }

    /**
     * @desc 视图输出
     * @param array $__ctx
     */
    public function show($__ctx = array()){
    	$__error_reporting_level = error_reporting();	//当前PHP错误等级
    	error_reporting($__error_reporting_level ^ E_NOTICE);	//去除notice
    	if($__ctx){
			foreach($__ctx as $k=>$v){
				$$k = $v;
			}
    	}
		file_exists($this -> _vFile) && require($this -> _vFile);
		error_reporting($__error_reporting_level);	//恢复原来的PHP错误等级
    }

}
