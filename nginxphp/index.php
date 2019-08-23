<?php
/**
 * 统一入口
 */
require_once('inc/inc.php');
try
{
	App_App::dispatch();
}
catch(Exception $e)
{
	echo ($e->getMessage());
}