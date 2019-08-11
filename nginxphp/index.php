<?php
use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client;
require 'vendor/autoload.php';

$now = date("Y-m-j, H:i:s");
echo '<h1>Hullo from webdevops/php-nginx.</h1>
<h2>Deployed via CodeDeploy.</h2>
<h4>HOSTNAME= '.$_SERVER['HOSTNAME'].'</h4>
<h4>It is '.$now.' now.</h4>';

echo 'REQUEST_URI='.$_SERVER['REQUEST_URI'];
// Use the default credential provider. This can assume IAM service role on EC2 or ECS Task.
$provider = CredentialProvider::defaultProvider();
$sharedConfig = [
    'region'      => 'us-east-1',
    'version'     => 'latest',
    'credentials' => $provider
];
$s3Client = new S3Client($sharedConfig);
$buckets = $s3Client->listBuckets();
echo "<h4>my S3 buckets</h4><ul>";
foreach ($buckets['Buckets'] as $bucket) {
    echo '<li>'.$bucket['Name'] . "</li>\n";
}
echo "</ul>";
