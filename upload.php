<?php
require 'vendor/autoload.php'; // Include the AWS SDK for PHP

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Create an S3 client
$s3 = new S3Client([
    'region' => 'ap-southeast-2', // Replace with your region
    'version' => 'latest',
]);

$bucketName = 'apacheproject1'; // Replace with your S3 bucket name

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $fileName = $_FILES['image']['name'];
    $tempFilePath = $_FILES['image']['tmp_name'];

    try {
        $result = $s3->putObject([
            'Bucket' => $bucketName,
            'Key' => $fileName,
            'Body' => fopen($tempFilePath, 'rb'),
        ]);

        echo '<h3>Image uploaded successfully!</h3>';
        echo '<p>Image URL: <a href="' . $result['ObjectURL'] . '">' . $result['ObjectURL'] . '</a></p>';
    } catch (AwsException $e) {
        echo '<h3>Error uploading image: ' . $e->getMessage() . '</h3>';
    }
} else {
    echo '<h3>Error: Please select an image to upload.</h3>';
}
?>
