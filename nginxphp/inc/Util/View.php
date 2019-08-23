<?php
class Util_View
{
    private $_data = array();
    
    private $_template_base;
    
    function __construct($template_base ='')
    {
        $this->_template_base = _ROOT_.'template'.DIRECTORY_SEPARATOR.$template_base.DIRECTORY_SEPARATOR;
    }

	function assign($name, $value)
	{
		$this->_data[$name] = $value;
	}

	function display($template)
	{
	    extract($this->_data, EXTR_PREFIX_SAME, '_');
// 	    print_r($sys);
// 	    ob_start();
// 	    ob_implicit_flush(false);
	    $filePath = $this->_template_base.$template.'.php';
	    require($filePath);
	    
	    exit;
	}
	
	function fetch($template)
	{
	     
	}

	/**
	 * 引入模板局部
	 * @param string $template
	 */
	static function contain($template)
	{
	   $path = _ROOT_.'template'.DIRECTORY_SEPARATOR.$template.'.php';
	   require($path); 
	}
	
	/**
	 * 通用的提示页
	 * @param string $hint 提示语
	 * @param string $class fail or success
	 * @param string $template 模板页文
	 */
	function showHint($hint, $class = 'fail', $template = 'hint.php')
	{
		$this->assign('hint_class', $class);
		$this->assign('hint', $hint);
		$this->display($template);
	}
}