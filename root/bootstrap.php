<?php
/**
 *  应用引导程序
 *
 */
$bootDir = dirname(__FILE__);
define('UC_APP_PATH', $bootDir.'/');
define('UC_INCLUDE_PATH', $bootDir.'/../include/');
define('UC_MODULE_PATH', $bootDir.'/modules/');

require_once UC_INCLUDE_PATH.'bscore.php';

// autoload
AutoLoader::install(
	// class mapper
	array(
	),
	// search path 
	array(
		UC_MODULE_PATH,
		UC_INCLUDE_PATH,
		UC_APP_PATH		
	),	
	// search class file name
	array('%s.class.php','%s.php')			
);
// autoload end
