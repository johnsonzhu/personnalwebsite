<?php
/**
 *  模块整合调用的功能实现
 *
 */

/**
 * 命名调用
 * @param $name 名称
 * @param $defCallback 缺省回调
 * @param $defReqFile 
 * @return unknown_type
 */
function m_call($name,$defMCallback=null) {
	global $_M_DATA_OBJECT;
	$pack = null;
	if($_M_DATA_OBJECT && isset($_M_DATA_OBJECT[$name])) {
		// 已注册
		$pack = $_M_DATA_OBJECT[$name];
	} else {		
		if(defined($name)) {
			// 使用常量定义回调
			$pack = m_make_callback(constant($name));
			if($pack) {
				m_register($name,$pack);
			}
		}
		if(!$pack && $defMCallback) {			
			// 使用缺省值			
			if(is_string($defMCallback)) {
				$pack = m_make_callback($defMCallback);
			} else if (is_array($defMCallback)) {
				$pack = $defMCallback;	
			}			
		}
	}
	if(!$pack)return null;
	$rf = isset($pack[1])?$pack[1]:null;
	if($rf) {
		require_once $rf;
	}
	$cb = $pack[0];	
	return call_user_func($cb);
}

/**
 * 注册一个命名调用
 * 
 * @param string $name
 * @param callback $callback
 * @param string $reqFile
 * @return array 调用结构
 */
function m_register($name,$mcallback) {
	global $_M_DATA_OBJECT;
	if(!$_M_DATA_OBJECT)$_M_DATA_OBJECT = array();	
	$_M_DATA_OBJECT[$name] = $mcallback;
}

/**
 * 使用一个字符串构造M调用
 * 格式：[class:]function[@require_file]
 * 
 * @param string $str
 * @return mcallback
 */
function m_make_callback($str) {
	if(!$str)return null;
	$ps = explode('@',$str,2);
	$cb = $ps[0];
	$p = null;
	if(count($ps)==2) {
		$p = $ps[1];
	}
	$cs = explode(':',$cb,2);
	if(count($cs)==2) {
		$cls = $cs[0];
		$fn = $cs[1];
	} else {
		$cls = null;
		$fn = $cs[0];
	}
	
	$r = array();
	if($cls) {
		array_push($r,array($cls,$fn));
	} else {
		array_push($r,$fn);
	}
	if($p) {
		array_push($r,$p);
	}
	return $r;
}