<?php

header("Content-Type: text/html; charset=utf-8");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
#error_reporting(0);#线上改为0
session_start();
require_once dirname(__FILE__) . '/bootstrap.php';
try{
    $dis = mvc_Manager::initDispatcher("common");
    if(defined("__M") && defined("__DO")){
		//预定义控制器、控制方法
		$dis->run(__M,__DO);    	
    }else{
    	//参数控制器、控制方法
    	$dis->run();
    }
} catch(Exception $e){
    var_dump($e);#上线后注释改行
}

