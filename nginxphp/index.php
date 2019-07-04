<?php
require 'vendor/autoload.php';
$now = date("Y-m-j, H:i:s");
echo '<h1>Hullo from webdevops/php-nginx.</h1> <h4>HOSTNAME= '.$_SERVER['HOSTNAME'].'</h4>
<h4>It is '.$now.' now.</h4>';
// print_r($_ENV);
// phpinfo();
use Aws\S3\S3Client;

use Aws\Exception\AwsException;

$sharedConfig = [
    'profile' => 'default',
    'version' => 'latest',
    'region' => 'us-east-1'
];


$s3Client = new Aws\S3\S3Client($sharedConfig);
$buckets = $s3Client->listBuckets();
echo "<h4>my S3 buckets</h4><ul>";
foreach ($buckets['Buckets'] as $bucket) {
    echo '<li>'.$bucket['Name'] . "</li>\n";
}
echo "</ul>";