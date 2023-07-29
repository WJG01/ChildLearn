<?php
require 'vendor/autoload.php'; // Include the AWS SDK for PHP

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// AWS credentials (Access Key and Secret Key)
$credentials = new Aws\Credentials\Credentials(
    'ASIA5WKXJVR5DOYHZGHC',
    'dHJB1Pwb56U1xXuJvczjqltW3E/a/BY3HWm8wywp',
    'FwoGZXIvYXdzEAEaDNTXdmyCWoPzCBeVFyK8AfZ3gVkSZl4ZR7N2GlOH75ZvRFk/eyqdc9NH207hemW0wGX04Exx3AYN5KeK9aQTM/tSxArKc6vcuaXcSMXsBkXJmAGlk9HCR/RgwWb10dEle1jEq8qpaM0bwqgC4cPhVz1A2Z7+hJe0b/J1hko5bmk135TbOVTA09h8bEvDL57KQmotrygWHl5JiTAnb7q+DQvqxPCAFdw2weyYt4NMMqhfIKUqcTfStaDWrLZRotRhGgL5TJMFQ/UP6+KDKNX/kqYGMi2xUD7EhRdCUi5yxnCDpzwjgFj+toqvfma7kPSqy0Yem1gDtr/SVjBQQ99TrgI='
);

// AWS region where your S3 bucket is located
$region = 'us-east-1';

// S3 bucket name
$bucketName = 'childlearn-bucket';

function uploadToS3($fileType, $file)
{
    global $credentials, $region, $bucketName;

    // Check if a file was uploaded and it has a non-empty temporary path
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK || empty($file['tmp_name'])) {
        die('No file uploaded or file upload error occurred.');
    }

    // Check if the fileType is 'image' or 'video'
    if ($fileType === 'image') {
        $targetFolder = 'Images/';
    } elseif ($fileType === 'video') {
        $targetFolder = 'Videos/';
    } else {
        die('Invalid fileType. Must be "image" or "video".');
    }

    try {
        // Create an S3 client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $region,
            'credentials' => $credentials,
        ]);

        // Upload the file to the specified S3 bucket and folder
        $result = $s3Client->putObject([
            'Bucket' => $bucketName,
            'Key' => $targetFolder . basename($file['name']),
            'Body' => fopen($file['tmp_name'], 'rb'),
            'ACL' => 'public-read', // Optional: Set the ACL to make the uploaded file publicly accessible
            'ContentType' => $file['type'], // Set the content type based on the file type (e.g., image/jpeg, video/mp4)
            'ContentDisposition' => 'inline', // Set the Content-Disposition header to display the file inline
        ]);

        return $result;
    } catch (S3Exception $e) {
        echo 'Error uploading file to S3: ' . $e->getMessage();
    }
}

function getImageFromS3($fileName)
{
    global $credentials, $region, $bucketName;

    // Determine the file extension from the file name
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    // Determine the S3 folder based on the file extension
    $targetFolder = '';
    if (in_array($fileExtension, ['png', 'jpg', 'jpeg'])) {
        $targetFolder = 'Images/';
    } elseif ($fileExtension === 'mp4') {
        $targetFolder = 'Videos/';
    } else {
        die('Invalid file extension.');
    }

    // echo $fileName;
    // echo $targetFolder;

    try {
        // Create an S3 client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $region,
            'credentials' => $credentials,
        ]);

        // Debug statement to check successful connection
        // echo 'S3 client created successfully!';

        // Get the file from the S3 bucket
        $result = $s3Client->getObject([
            'Bucket' => $bucketName,
            'Key' => $targetFolder . $fileName,
        ]);

        // Generate the full URL link for the retrieved file
        $fileUrl = $result['@metadata']['effectiveUri'];
        // echo $fileUrl;

        return $fileUrl;
    } catch (S3Exception $e) {
        echo 'Error getting file ' . $fileName . ' from S3: ' . $e->getMessage();
        return 'Images/defaultcoursecover.jpg';
    }
}

function getImageFromCloudFront($fileName)
{
    $cloudFrontDomain = 'd2hmz1phin01an.cloudfront.net';

    // Determine the file extension from the file name
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    // Determine the CloudFront folder based on the file extension
    $targetFolder = '';
    if (in_array($fileExtension, ['png', 'jpg', 'jpeg'])) {
        $targetFolder = 'Images/';
    } elseif ($fileExtension === 'mp4') {
        $targetFolder = 'Videos/';
    } else {
        die('Invalid file extension.');
    }

    try {
        // Generate the full URL link for the retrieved file from CloudFront
        $fileUrl = 'https://' . $cloudFrontDomain . '/' . $targetFolder . $fileName;

        return $fileUrl;
    } catch (Exception $e) {
        echo 'Error getting file ' . $fileName . ' from CloudFront: ' . $e->getMessage();
        return 'Images/defaultcoursecover.jpg';
    }
}
