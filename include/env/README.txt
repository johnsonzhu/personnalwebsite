env模块说明：

env_Runtime
× 提供当前运行环境的相关功能方法
	isDev —— 开发环境模式
	isTest —— 测试环境模式
	isRuntimeDebug —— 运行测试模式
	isRuntimePreview —— 运行预览模式
	isDef —— 判断开关,支持带时间的开关( $KEY$_START,$KEY$_END )
	getMode —— 获得运行环境的启动模式，web|script
	runtimeDebug —— 运行测试输出
		
	
* 提供功能场景相关的方法，在C层使用	
	recError —— 记录功能场景的异常
	recWarn —— 记录功能场景的可忽略异常
	recUserErr —— 记录功能场景的用户输入错误
	recException —— 记录异常
	throwException —— 构造固定格式的错误并抛出(可在任意层次使用)
	output —— 输出	

env_Runtime配置	
	ENV_RUNTIME_VERSION 常量定义开关的包含文件
		缺省为 $UC_APP_PATH$/version.inc.php
	ENV_RUNTIME_DEV 	常量定义开发模式
	ENV_RUNTIME_TEST 	常量定义测试模式
	
	
env_Runtime使用
测试用例 testcase/env/runtime_tc.php

功能在"开发环境模式"和"测试环境模式"下的区别
* 
	
##############################################################################
env_Config
* 提供配置相关的功能，用于规范配置文件的组织和读取配置的方式
	getModuleConf($module,$confName,$defaultFileName) : array;
		读取指定模块的某个配置文件
	getAppConf($confName,$defaultFileName) : array
		读取应用的某个配置文件 (模块名字为theapp)
		
配置定位
	判断是否加载（key=$module*$confName），已经加载返回加载数据
	判断常量 CONF_$model_$confName (如： CONF_peer_mysqlcm) 是否存在，如果存在作为配置文件
	不存在
		如果$defaultFileName为空，则使用 $module_$confName.conf.php (如：peer_mysqlcm.conf.php)
		模块使用  $ucmodule$/conf/$defaultFileName
		应用使用  $app$/conf/$defaultFileName
				
	配置文件里定义$CONF变量，范例如下：
<?php
$CONF = array(
	....
);
	
	
	
	
	
	
	