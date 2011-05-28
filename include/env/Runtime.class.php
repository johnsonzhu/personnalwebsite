<?php
if(!defined('ENV_RUNTIME_VERSION')) {
	define('ENV_RUNTIME_VERSION',UC_APP_PATH.'version.inc.php');
}
if(file_exists(ENV_RUNTIME_VERSION)){
	require_once ENV_RUNTIME_VERSION;
}

/**
 * @desc 运行环境工具对象
 * @author guanzhong<guanzhong@ucweb.com>
 * @copyright All Rights Reserved 优视动景
 *
 */
class env_Runtime {

	/**
	 * @desc 当前是否开发环境模式
	 * @return boolean
	 */
	public static function isDev() {
		if(defined('ENV_RUNTIME_DEV') && ENV_RUNTIME_DEV) {
			return true;
		}
		return false;
	}

	/**
	 * @desc 当前是否测试环境模式
	 * @return boolean
	 */
	public static function isTest() {
		if(defined('ENV_RUNTIME_TEST') && ENV_RUNTIME_TEST) {
			return true;
		}
		return false;
	}
	
	/**
	 * @desc 获得运行环境的启动模式
	 * @return string web|script
	 */
	public static function getMode() {
		// TODO: 未验证的实现
		if(!isset($_SERVER['SHELL'])) {
			return 'web';
		}
		return 'script';
	}

	/**
	 * @desc 运行测试模式
	 * @return boolean
	 */
	public static function isRuntimeDebug() {
		return isset($_REQUEST['envDEbug']);
	}
	/**
	 * @desc 运行预览模式
	 * @return boolean
	 */
	public static function isRuntimePreview() {
		return isset($_REQUEST['envPReview']);
	}
	protected static function parseTime($tm) {
		if(strlen($tm)!=19)return 0;	
		return mktime(substr($tm,11,2),substr($tm,14,2),substr($tm,17,2),substr($tm,5,2),substr($tm,8,2),substr($tm,0,4));
	}
	protected static function runtimeNow($key) {
		$tm = isset($_REQUEST[$key.'_now'])?$_REQUEST[$key.'_now']:'';
		if($tm && strlen($tm)==14) {
			$r=mktime(substr($tm,8,2),substr($tm,10,2),substr($tm,12,2),substr($tm,4,2),substr($tm,6,2),substr($tm,0,4));
			if($r>0)return $r;
		}
		return time();
	}

	/**
	 * @desc 判断开关,支持带时间的开关( $KEY$_START,$KEY$_END )
	 * @param $key string 开关名称
	 * @return boolean
	 */
	public static function isDef($key) {
		$b = isset($_REQUEST[$key]);
		if($b || (defined($key) && constant($key))) {
			if(defined($key.'_START')) {
				$tmv = self::parseTime(constant($key.'_START'));				
				if($tmv>0) {
					$now = self::runtimeNow($key);					
					if($now < $tmv) {
						if(self::isRuntimeDebug()) {
							self::runtimeDebug(date('Y-m-d H:i:s',$now).' < '.date('Y-m-d H:i:s',$tmv));
						}
						return false;
					}					
				}
			}
			if(defined($key.'_END')) {
				$tmv = self::parseTime(constant($key.'_END'));
				if($tmv>0) {
					$now = self::runtimeNow($key);
					if($now > $tmv) {
						if(self::isRuntimeDebug()) {
							self::runtimeDebug(date('Y-m-d H:i:s',$now).' > '.date('Y-m-d H:i:s',$tmv));
						}
						return false;
					}					
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * @desc 运行测试输出
	 * @param $msg string 消息
	 * @return
	 */
	protected static $rtDebugs = array();
	public static function runtimeDebug($msg) {
		array_push(self::$rtDebugs,$msg);
	}
	/**
	 * @desc 获得运行测试输出
	 * @param $clear boolean 是否清除
	 * @return array()
	 */
	public static function listRuntimeDebug($clear = true) {
		$r = self::$rtDebugs;
		if($clear) {
			self::$rtDebugs = array();
		}
		return $r;
	}
	
	/**
	 * @desc 记录功能场景的异常
	 * @param $fatal boolean 是否依赖服务故障
	 * @param $knowed boolean 是否可预测的故障
	 * @param $errCode string 错误代码
	 * @return array()
	 */
	protected static $_error = null;
	public static function recError($fatal,$knowed, $errCode) {
		self::$_error = array(
			'fatal'=>$fatal,
			'knowed'=>$knowed,
			'errCode'=>$errCode
		);
	}
	
	/**
	 * @desc 记录功能场景的可忽略异常
	 * @param $fatal boolean 是否依赖服务故障
	 * @param $errCode string 错误代码
	 * @return array()
	 */
	protected static $_warn = array();
	public static function recWarn($warnCode) {
		array_push(self::$_warn,$warnCode);
	}
	
	/**
	 * @desc 记录功能场景的用户输入错误
	 * @param $fatal boolean 是否依赖服务故障
	 * @param $userCode string 错误代码
	 * @return array()
	 */
	protected static $_userErr = array();
	public static function recUserErr($userCode) {
		array_push(self::$_userErr,$userCode);
	}
	
	/**
	 * @desc 创建异常
	 * @param $fatal boolean 是否依赖服务故障
	 * @param $knowed boolean 是否可预测的故障
	 * @param $errCode string 错误代码
	 * @param $msg string 异常消息
	 * @return exception
	 */
	public static function initException($fatal,$knowed,$errCode,$e) {
		$e->fatal = $fatal;
		$e->knowed = $knowed;
		$e->errCode = $errCode;
		return $e;
	}
	
	/**
	 * @desc 记录功能场景异常
	 * @param $e exception 异常
	 * @return
	 */
	public static function recExcetpion($e) {
		if(isset($e->errCode)) {
			self::recError($e->fatal,$e->knowed,$e->errCode);
		} else {
			self::recError(true,false,'exception');
		}
	}
	
	/**
	 * @desc 功能场景输出
	 * @return
	 */
	public static function flush() {
		if(self::$_error) {
			if(self::$_error['fatal']) {
				header("Status: 500");
				header("sso_err_code: ".self::$_error['errCode']);
			} else {
				if(self::$_error['knowed']) {
					header("sso_exception: ".self::$_error['errCode']);
				} else {
					header("sso_err_code: ".self::$_error['errCode']);
				}
			}
		}
		$ob = '';
		foreach(self::$_warn as $v) {
			if($ob)$ob.=';';
			$ob .= $v;
		}
		if($ob) {
			header("sso_warn_code: ".$ob);
		}
		$ob = '';
		foreach(self::$_userErr as $v) {
			if($ob)$ob.=';';
			$ob .= $v;
		}
		if($ob) {
			header("sso_user_err: ".$ob);
		}
	}
}