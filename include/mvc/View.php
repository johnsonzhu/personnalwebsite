<?php

/**
 * 视图输出类
 */
class mvc_View{

	protected  $ctx = array();
	private $_module;
	private $_viewName;
	private $_theme;
	private $_viewType;
	
	public static function loadView($module,$viewName,$theme = "",$viewType = "simple"){
		$r = new mvc_View();
		$r->_module = $module;
		$r->_viewName = $viewName;
		$r->_theme = $theme;
		$r->_viewType = $viewType;
		return $r;
	}
	/**
	 * 设置视图输出的数据
	 * @param array $values
	 * 
	 */
	public function setViewData($values = array()){
		$this->ctx = $values;
	}
	/**
	 * @desc 添加一个数据到视图
	 * @param string $key 变量名
	 * @param string $value 变量值
	 */
	public function addViewData($key,$value){
		$this->ctx[$key] = $value;
	}
	/**
	 * @desc 获取某个视图变量的值
	 * @param 视图变量名
	 * @return 
	 */
	public function getViewData($key){
		return $this->ctx[$key];
	}
	
//	public function discardView(){
//		
//	}
//	
	/**
	 * @desc 视图输出
	 */
	public function show(){
    		$v = mvc_viewImpl_simple::loadView($this->_module, $this->_viewName, $this->_theme);
    	    $v->show($this->ctx);
	}
	

}
