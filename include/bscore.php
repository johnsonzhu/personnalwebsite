<?php
/**
 *  应用启动的核心功能
 *
 */

class AutoLoader {
	
    protected $classMapper = array();   	//自动加载类集合
    protected $directories = array();   	//默认搜索路径
    protected $fileNameFormats = array();   //默认搜索文件名格式
    
    /**
	 * @desc 初始化配置
	 * @param string $varClassMapper	//类主动索引
	 * @param string $varDirectories	//类索引路径
	 * @param string $varFileNameFormats	//类文件格式
	 * 
	 */
    public function conf($varClassMapper,$varDirectories,$varFileNameFormats) {
		if($varClassMapper) {
    		$this->classMapper = $varClassMapper;
    	}
    	if($varDirectories) {    		    		
    		$this->directories = $varDirectories;
    	}
    	if($varFileNameFormats) {
    		$this->fileNameFormats = $varFileNameFormats;
    	}
    }
    
    /**
	 * @desc 在directories中查找指定文件
	 * @param string $name	//文件名
	 * @param boolean $isClass	//是否查找类文件
	 * @return mixed
	 */
    public function findFile($name,$isClass=true) {
		// 搜索
		if($isClass){
			if (isset($this->classMapper[$name])) {  // 配置该类
				return $this->classMapper[$name];
			}
			$fPath = str_ireplace('_', '/', $name);
			foreach($this->directories as $directory){
				foreach($this->fileNameFormats as $fileNameFormat){
				    $path = $directory.sprintf($fileNameFormat, $fPath);
				    if(file_exists($path)) {
				    	return $path;
					}
				}
		    }
		}else {
			$fPath = $name;		    
			foreach($this->directories as $directory){
				$path = $directory.$fPath;
			    if(file_exists($path)) {
			    	return $path;
				}
		    }
		}    
	    
	    return false;
    }
    
    /**
	 * @desc 在directories中查找指定的所有文件
	 * @param string $name	//文件名
	 * @return mixed
	 */
	public function findAllFile($name) {
		// 搜索
		$r = array();
		$fPath = $name;		    
		foreach($this->directories as $directory){
			$path = $directory.$fPath;
		    if(file_exists($path)) {
		    	array_push($r,$path);
			}
	    }
	    return $r;
    }
	
    public function autoLoader($className=false) {
    	if(!$className)return false;
    	$fileName = $this->findFile($className);
        if($fileName) {
        	require_once $fileName;
        	return true;
        }
        return false;
    }

    protected static $_instance;
    
	public static function getInstance() {
		if ( ! isset(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    
	/**
	 * @desc 加载autoLoader
	 * @param string $varClassMapper	//类主动索引
	 * @param string $varDirectories	//类索引路径
	 * @param string $varFileNameFormats	//类文件格式
	 * @return mixed
	 */
    public static function install($varClassMapper,$varDirectories,$varFileNameFormats) {
    	$al = self::getInstance();
    	$al->conf($varClassMapper,$varDirectories,$varFileNameFormats);
    	spl_autoload_register(array($al,'autoLoader'));
    }
}

require_once 'mccore.php';