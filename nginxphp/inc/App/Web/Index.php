<?php
class App_Web_Index extends App_Web_Web
{
	/**
	 * 网站首页
	 */
	public function indexAction()
	{
	    
		echo __METHOD__;
		$now = date("Y-m-j, H:i:s");
        echo '<h1>Hullo from webdevops/php-nginx.</h1> <h4>HOSTNAME= '.$_SERVER['HOSTNAME'].'</h4>
        <h4>It is '.$now.' now.</h4>';
        
        echo 'REQUEST_URI='.$_SERVER['REQUEST_URI'];
        // Use the default credential provider. This can assume IAM service role on EC2 or ECS Task.
        $provider = Aws\Credentials\CredentialProvider::defaultProvider();
        $sharedConfig = [
            'region'      => 'us-east-1',
            'version'     => 'latest',
            'credentials' => $provider
        ];
        $s3Client = new Aws\S3\S3Client($sharedConfig);
        $buckets = $s3Client->listBuckets();
        echo "<h4>my S3 buckets</h4><ul>";
        foreach ($buckets['Buckets'] as $bucket) {
            echo '<li>'.$bucket['Name'] . "</li>\n";
        }
        echo "</ul>";
// 		exit;
        // $this->view->display('index');
	}
	
	public function gatewayAction()
	{
	    echo __METHOD__;
	    $url = 'http://myapplication.tutorial';
	    $content = file_get_contents($url);
	    echo $content;
	}
}