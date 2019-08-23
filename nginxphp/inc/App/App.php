<?php
/**
 * 应用层基类,所有应用接口的基础方法,无验证.
 */
abstract class App_App
{
	public static $request_uri;

	public static $uri_parsed;

	public static $control;

	public static $action;

	public static $api_name;

	public static $language;

	function __construct()
	{}

	function __destruct()
	{}

	public function __get($name)
	{
		if (__DEBUG_MODE__)
		{
			echo __CLASS__ . " __get:" . $name . "<br>";
		}
		if ('model' == substr($name, 0, 5))
		{
			$className = 'Model_' . ucfirst(substr($name, 5));
		}
		if (! empty($className))
		{
			$this->$name = new $className();
			return $this->$name;
		}
		return false;
	}

	function assign($name, $value)
	{
		$this->view->assign($name, $value);
	}

	function error($msg)
	{
		$this->view->assign('pagetitle', array(
			array(
				'hint' => '错误提示',
				'url' => ''
			)
		));
		$this->view->assign('msg', $msg);
		$this->view->display('error');
	}

	/**
	 * 以模板组织，输出组装好的内容。
	 */
	function display($template)
	{
		$this->view->display($template);
	}

	/**
	 * 经过模板组织，不输出而是返回组装好的内容。
	 */
	function fetch($template)
	{}
	
	/**
	 * 模板组织输出统一的错误或消息提示。
	 */
	function hint($msg)
	{}

	/**
	 * 不经过模板，直接输出数据。
	 * @param array $data 输出的数据
	 */
	function out($data)
	{
// 		header('Content-Type:application/json; charset=UTF-8');
		echo json_encode($data);
		exit;
	}

	/**
	 * 以 JSONP 输出 JS 代码
	 * @param string $str
	 */
	function jsonp($str)
	{
		header('Content-Type:application/json; charset=UTF-8');
		echo $str;
		exit;
	}

	function redirect($url)
	{
		header('location: ' . $url);
	}

    /**
     * 设置响应结果
     * @param $result
     * @param string $msg
     * @param string $code
     */
    public function setResponse($result, $msg = '', $code = '20000')
    {
        $data = array(
            'code' => (string)$code,
            'msg' => (string)$msg,
            'data' => (array)$result,
        );

        header('Content-Type:application/json; charset=UTF-8');
        echo json_encode($data);
        exit;
    }

    static function dispatch()
	{
		$appMapArray = array('api'=>'Api', 'cn'=>'Web', 'en'=>'Web', 'wap_cn'=>'Wap', 'wap_en'=>'Wap');
		$uriArray    = parse_url($_SERVER['REQUEST_URI']);
		self::$request_uri = trim($uriArray['path'], '/');
		self::$uri_parsed = $parseArray = explode('/', self::$request_uri, 4);
		// 如果出现无效的 第 1 节, 则跳转到根目录去.
		// if (count($parseArray)>1 && !isset($appMapArray[$parseArray[0]]))
		// {
		// 	header('Location: /', true, 301);
		// }
		// 看 URI 地址是否带有 cn 或 en 字样
		self::$language = (false !== strpos($parseArray[0], 'n')) ? substr($parseArray[0], strpos($parseArray[0], 'n')-1) :'cn';
		$appVersion = isset($appMapArray[$parseArray[0]]) ? $parseArray[0] : 'cn';
		self::$control = (isset($parseArray[1]) && $parseArray[1]) ? strtolower($parseArray[1]) : 'index';
		self::$action = (isset($parseArray[2]) && $parseArray[2]) ? strtolower($parseArray[2]) : 'index';
		$className = 'App_'.$appMapArray[$appVersion].'_'.ucfirst(self::$control);
		// 用于URI中包含control 和 action的情景，如 /api/share/get
		self::$api_name = '/'.self::$control.'/' . self::$action . '/';
		if (class_exists($className))
		{
            try {
                $application = new $className;
                $action = self::$action . 'Action';
                if (__DEBUG_MODE__) {
                    echo "Class Instance:" . $className . "<BR>";
                }
                if (method_exists($application, $action)) {
                    if (__DEBUG_MODE__) {
                        echo "Excute Action:" . $className . "->" . $action . "()<BR>";
                    }
                    $application->$action();

                } else {
                    throw new Exception('Action not found!', -3);
                }
            } catch (Util_Exception $ex) {
                $exception = array(
                    'code' => (string)$ex->getExtCode(),
                    'msg' => (string)$ex->getMessage(),
                    'data' => (array)$ex->getExtData(),
                );
                echo json_encode($exception);
                exit;
            }
        }
		else
		{
			throw new Exception('Controller not found!', -2);
		}
	}
}