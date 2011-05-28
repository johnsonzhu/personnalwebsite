<?php
/**
 * 
 * @author Guicai Liu<liugc@ucweb.com>
 * @copyright All Rights Reserved 优视动景
 *
 */
class env_Exception extends Exception{
	
	//给用户显示的异常信息
	public $title;
	
	public function __construct($msg, $title, $code = 0){
		parent::__construct($msg, $code);
		$this->title = $title;
	}
	
}