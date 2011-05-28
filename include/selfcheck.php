<?php
function sc_info($m,$msg) {
	echo $m.':'.$msg."<br/>\n";
}
function sc_warn($m,$msg) {
	echo $m.':'.'<font color="blue">'.$msg."</font><br/>\n";
}
function sc_error($m,$msg) {
	echo $m.':'.'<font color="red">'.$msg."</font><br/>\n";
}
function sc_run($m,$cb) {
	global $_SELF_CHECK;
	if($_SELF_CHECK && isset($_SELF_CHECK[$m])) {
		// already run
		return $_SELF_CHECK[$m];
	}
	sc_info($m,'start');
	$r = call_user_func($cb);
	sc_info($m,'end');
	if(!$_SELF_CHECK) {
		$_SELF_CHECK = array();
	}
	$_SELF_CHECK[$m] = $r;
	return $r;
}
function sc_class($cls) {
	sc_run($cls,array($cls,'moduleSelfCheck'));
}