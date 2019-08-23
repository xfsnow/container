<?php
//在 PHP 里明确设定时区，统一时间
date_default_timezone_set('Etc/GMT-8');
!defined('_ROOT_') && define('_ROOT_', substr(dirname(__FILE__), 0, -3));
ini_set('default-charset','UTF-8');
// 本地开发
define('ENV_DEV', 0);
// 测试
define('ENV_QA', 1);
//外网正式
define('ENV_ON', 2);
// 外网正式
if (false !== strpos(_ROOT_, '/www/'))
{
	define('ENV', ENV_ON);
	error_reporting(0);
}
// 测试
elseif (false !== strpos(_ROOT_, '/test/'))
{
	define('ENV', ENV_QA);
	error_reporting(E_ALL);
}
// 本地开发
else
{
	define('ENV', ENV_DEV);
	error_reporting(E_ALL);
}


// 是否开启 debug 模式,调整以下行的注释来配置。
// 通过参数控制
define('__DEBUG_MODE__', isset($_REQUEST['__DEBUG_MODE__']));
// 全部禁用
// define('__DEBUG_MODE__', false);
// 全部启用
// define('__DEBUG_MODE__', true);

function autoload($classname)
{
	$classname_path = str_replace('_', DIRECTORY_SEPARATOR, $classname);
	//autoload our class definitions.
	$filepath = _ROOT_.'inc'.DIRECTORY_SEPARATOR.$classname_path.'.php';
// 	echo $classname.'=>'.$filepath."\n";
	//require quicker than require_once, include quicker than include_once. require will halt when file not found, but include will go on, so use include.
	class_exists($classname) || (is_file($filepath) && include($filepath));
	if(__DEBUG_MODE__)
	{
		echo 'Autoload '.$classname.', from '.$filepath.'<br>';
	}
}
spl_autoload_register('autoload');
require _ROOT_.'vendor/autoload.php';
//启用带压缩的输出控制。
ini_set("zlib.output_compression", 'On');
ini_set('zlib.output_compression_level', 9);
error_reporting(E_ALL);