<?php
/**
 * @desc 应用类型管理对象
 * @author liaozj<liaozj@ucweb.com>
 * @copyright All Rights Reserved 优视动景
 *
 */
class env_App {
	
	const APP_WWW 			= "www";		//www应用
	const APP_MOBI_PROXY 	= "mobiproxy";	//手机中间件应用
	const APP_MOBI_WAP 		= "mobiwap";	//手机直连应用
	const APP_SERVICE 		= "service";	//接口服务
	const APP_SCRIPT 		= "script";		//脚本
	
	/*
	 * @desc 返回当前应用的类型（在当前应用中用常量 APP_TYPE 定义）
	 * @param string $default 默认返回的类型
	 * @return 返回应用类型
	 */
	//[finish]fixit : 把 default 挪后，先判断是否具有 APP_TYPE ，然后判断 $default是否为空
	public static function getAppType($default = ""){	
		if(defined("APP_TYPE")){
			return APP_TYPE;
		}else{
			if($default){
				return $default;
			}else{
				$msg = 'App Type Undefined';
				$e = new env_Exception('getAppType_error',$msg);
				throw env_Runtime::initException(false,false,'getAppType_error',$e);
			}       	
		}
	}
	
}