<?php
/**
 * Web 页
 */
abstract class App_Web_Web extends App_App
{
	public $view;
	function __construct()
	{
 		$this->_checkAuth();
 		$this->view = new Util_View('web');
 		// $this->view->assign('control', self::$control);
 		// $this->view->assign('action', self::$action);
 		// $this->view->assign('language', self::$language);
 		// $langPackage = 'Config_Lang_'.ucfirst(self::$language);
 		// $this->view->assign('lang', $langPackage::$lang);
 		// $this->view->assign('sys', Config_Sys::$sys);
		parent::__construct();
		header('Content-Type:text/html; charset=UTF-8');
	}

	protected function _checkAuth()
	{

	}
	
	
}