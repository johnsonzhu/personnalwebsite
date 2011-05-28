<?php
/**
 * @desc 配置管理对象
 * @author guanzhong<guanzhong@ucweb.com>
 * @copyright All Rights Reserved 优视动景
 *
 */
class env_Config {

	/**
	 * @desc 读取指定模块的某个配置文件
	 * @param string $module 模块名
	 * @param string $confName 配置名
	 * @param $defaultFileName 缺省的文件名
	 * @return mixed
	 */
	public static function getModuleConf($module,$confName,$defaultFileName = null) {
		return self::getConf($module,$confName,$defaultFileName);
	}

	/**
	 * @desc 读取应用的某个配置文件
	 * @param string $confName 配置名
	 * @param $defaultFileName 缺省的文件名
	 * @return mixed
	 */
	public static function getAppConf($confName,$defaultFileName = null) {
		return self::getConf('theapp',$confName,$defaultFileName);	
	}

	/**
	 * @desc 内部加载程序
	 * @param string $module
	 * @param string $confName
	 * @param string $defaultFileName
	 * @return mixed
	 */
	protected static $confs = array();
	protected static function getConf($module,$confName,$defaultFileName) {
		$key = $module.'*'.$confName;
		if(isset(self::$confs[$key])) {
			return self::$confs[$key];
		}
		
		// 判断常量
		$cname = 'CONF_'.$module.'_'.$confName;
		if(defined($cname) && constant($cname)) {
			$pathName = constant($cname);
		} else {
			if($defaultFileName) {
				// 提供的配置文件
				$fileName = $defaultFileName;
			} else {
				// 缺省配置文件
				$fileName = $module.'_'.$confName.'.conf.php';
			}
//			$pathName = ($isApp?UC_APP_PATH:UC_MODULE_PATH).'conf/'.$fileName;
			$pathName = AutoLoader::getInstance()->findFile('conf/'.$fileName,false);
		}
		if($pathName && file_exists($pathName)) {
			require_once $pathName;
			if(!isset($CONF)) {
				$CONF = array();
			}
		} else {	//配置不存在，返回空数组，不抛异常
			$CONF = array();			
		}
		self::$confs[$key] = $CONF;
		return $CONF;		
	}
	
	/**
	 * @desc 在模块和应用中加载所有配置
	 * @param string $module
	 * @param string $confName
	 * @return mixed
	 */
	public static function getAllConf($module,$confName) {
		$fileName = $module.'_'.$confName.'.conf.php';
		$pathNameList = AutoLoader::getInstance()->findAllFile('conf/'.$fileName);
		$r = array();
		foreach($pathNameList as $pathName) {		
			require_once $pathName;
			if(!isset($CONF)) {
				$CONF = array();			
			}
			array_push($r,$CONF);
		}
		return $r;		
	}
	
	/**
	 * 按照路径在一个配置内搜索数据项，工具方法
	 * 定位规则: 
	 * a/c : name
	 * 1. a/c[name]
	 * 2. a/*[name]
	 * 3. *[name]
	 * 4. defValue
	 * 
	 * @param array $conf  配置集合
	 * @param array $paths 定位的路径
	 * @param string $name 数据项名城
	 * @param mixed $defValue 定位失败时候的缺省值
	 * @return mixed
	 */
	public static function getConfPathValue(&$conf,$paths,$name,$defValue = null) {		
		if(count($paths)>0) {
			$v = self::_getConfPathValue($conf,$paths,0,$name);
		} else {
			$v = null;
		}
		if($v===null)return $defValue;
		return $v;
	}
	
	protected static function _getConfPathValue(&$conf,&$paths,$idx,$name) {
		// 是否最后一个配置		
		if($idx>=count($paths)) {			
			return isset($conf[$name])?$conf[$name]:null;
		}
		// 读取下一个的配置数据
		if(isset($conf[$paths[$idx]])) {
			$cconf = $conf[$paths[$idx]];
			$v = self::_getConfPathValue($cconf,$paths,$idx+1,$name);
		} else {
			$v = null;
		}
		if($v===null) {
			// 检查 *
			if(isset($conf['*']) && isset($conf['*'][$name])) {
				return $conf['*'][$name];
			}
		}
		return $v;
	}
}
