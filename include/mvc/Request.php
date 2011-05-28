<?php
/**
 * 处理请求参数
 */
class mvc_Request{
    private $post,$get;
    private static $req;
    /**
     * 构造函数(单实例),如果开启了魔术引用,先去掉,并注销全局变量,防止被误用
     */
    private function __construct(){
        set_magic_quotes_runtime(0);
        if(get_magic_quotes_gpc()){
            throw new Exception('please turn off "magic_quotes_gpc" in php.ini');
        }
//        $this -> post   = strip_xss_all($_POST);
//        $this -> get    = strip_xss_all($_GET);
		$this -> post   = $_POST;
        $this -> get    = $_GET;
        #$_SERVER = strip_xss_all($_SERVER);
        #$_COOKIE = strip_xss_all($_COOKIE);
        unset($_POST,$_GET,$_REQUEST);
        //注销其它全局变量(保留$_SERVER,$_SESSION,$_FILE,$_COOKIE)
        //unset($GLOBALS,$_ENV,$HTTP_GET_VARS,$HTTP_SERVER_VARS,$HTTP_POST_VARS,$HTTP_COOKIE_VARS,$HTTP_POST_FILES,$HTTP_ENV_VARS,$HTTP_SESSION_VARS);
        self::$req = $this;
    }
    /**
     * 生成一个Request对象
     * @return Object
     */
    static function getInstance(){
        if(false == self::$req){
            self::$req = new self();
        }
        return self::$req;
    }
    /**
     * 取得get参数
     * @params String $key      参数名,为空时,返回整个$_GET数组,
     * @params String $default  默认值 当指定的参数的值为假(false,null,空值,0)时,使用此值作为返回
     * @params String $callback 回调函数,对返回值进行处理
     * @return Mixed
     */
    function get($key = '',$default = '',$callback=''){
        if(!$key) {
            return $this -> get;
        }
        $re = isset($this -> get[$key]) ? $this -> get[$key] : '';
        if(!$re && $default){
            $re = $default;
        }
        if($re && !is_array($re) && $callback && function_exists($callback)){ //只对非数组值进行回调处理
            return call_user_func($callback,$re);
        }
        else return $re;
    }
    /**
     * 取得post参数
     * @params String $key      参数名,为空时,返回整个$_GET数组,
     * @params String $default     默认值 当指定的参数为假(false,null,空值,0)时,使用此值作为返回
     * @params String $callback 回调函数,对返回值进行处理
     * @return Mixed
     */
    function getPost($key = '',$default = '', $callback=''){
        if(!$key){
            return $this -> post;
        }
        $re = isset($this -> post[$key]) ? $this -> post[$key] : '';
        if(!$re && $default){
            $re = $default;
        }
        if($re && !is_array($re) && $callback && function_exists($callback)){ //只对非数组值进行回调处理
            return call_user_func($callback,$re);
        }
        else return $re;
    }
    //get or post,不建议使用
    function getRequest($key = '',$default='',$callback = ''){
        $re = $this -> get($key,$default,$callback);
        if(!$re){
            $re = $this -> getPost($key,$default,$callback);
        }
        return $re;
    }
}

//过滤xss危险字符
function strip_xss_all($data){
    if(!$data) return null;
    return is_array($data) ? array_map('strip_xss_all', $data) : strip_xss($data);
}
function strip_xss($data){
    $data = strip_tags(trim($data));
    $data = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19,\'\"\ \<\>])/', '', $data);
    return $data;
}
