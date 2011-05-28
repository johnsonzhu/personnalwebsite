<?php

function db_info($m,$msg) {
	echo $m.':'.$msg."<br/>\n";
}

function db_error($m,$msg) {
	echo $m.':'.'<font color="red">'.$msg."</font><br/>\n";
}

function db_run($m,$cb) {
	global $_SELF_CON;
	if($_SELF_CON && isset($_SELF_CON[$m])) {
		// already run
		return $_SELF_CON[$m];
	}
	db_info($m,'start');
	$r = call_user_func($cb);
	db_info($m,'end');
	if(!$_SELF_CON) {
		$_SELF_CON = array();
	}
	$_SELF_CON[$m] = $r;
	return $r;
}

function db_class($cls) {
	db_run($cls,array($cls,'dbSelfCreate'));
}

function db_init($cls){
	db_run($cls,array($cls,'dbSelfInit'));
}

function db_addIndex($cls){
	db_run($cls,array($cls,'dbaddIndex'));
}