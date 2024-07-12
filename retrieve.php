<?php
// Assuming the S3Client is already included from the upload.php
require 'vendor/autoload.php'; // Include the AWS SDK for PHP

use Aws\S3\S3Client;

// Create an S3 client
$s3 = new S3Client([
    'region' => 'ap-southeast-2', // Replace with your region
    'version' => 'latest',
]);

$bucketName = 'apacheproject1'; // Replace with your S3 bucket name
$imageKey = $_GET['imageKey'];

try {
    $cmd = $s3->getCommand('GetObject', [
        'Bucket' => $bucketName,
        'Key' => $imageKey
    ]);

    $request = $s3->createPresignedRequest($cmd, '+20 minutes'); // URL valid for 20 minutes
    $presignedUrl = (string) $request->getUri();

    echo '<h3>Image retrieved successfully!</h3>';
    echo '<p>Image URL: <a href="' . $presignedUrl . '">' . $presignedUrl . '</a></p>';
} catch (AwsException $e) {
    echo '<h3>Error retrieving image: ' . $e->getMessage() . '</h3>';
}
?>
