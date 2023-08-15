<?php
require 'vendor/autoload.php'; // Include the AWS SDK for PHP

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

if (!isset($_SESSION)) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// AWS credentials (Access Key and Secret Key)
$credentials = new Aws\Credentials\Credentials(
    'ASIA5WKXJVR5FDCNPUOB',
    'JE+JO62ZjUzbNsrwjNXWo3ygvKssUZEdKNRYRZ/9',
    'FwoGZXIvYXdzEJT//////////wEaDCJTKSLylpRnszq91CK8ATFbnBONxojxTnPVF/a4D3rC0X6+OL5PrfyWi/FuBS/rtYU1xwtGpq1tvlCcjhrewS1rsGGpBuDWuAJU37FUcqBFjPD/NJ9/NMSIYVXUcmLHFXjAUu/G+wm2GR+2wh+HOep/PtqRMJq1EnXre2Ud/CSbQqnjejMSbdCsUQqYPEzV7p6NTWUd9Se4ZiwPAyMTiupum6aoNmIDUt5u1jxNe4hPcVwI8hBwA5lqepKwGeEorGobStvWqdzRKBI0KLPC66YGMi3Amnb5P/sh42kgGD5hLsDjM0513kN+u7qwJO893f9sXpI93lnb7Z/6DMtND5g='
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
        ]);

        try {

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
    } catch (Aws\Exception\AwsException $e) {
        echo 'Error creating S3 client: ' . $e->getMessage();
    }
}

function getMediaFromS3($fileName)
{
    global $credentials, $region, $bucketName, $defaultMediaFile;

    // Determine the file extension from the file name
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    // Determine the S3 folder based on the file extension
    $targetFolder = '';
    if (in_array($fileExtension, ['png', 'jpg', 'jpeg'])) {
        $targetFolder = 'Images/';
        $defaultMediaFile = 'defaultcoursecover.jpg';
    } elseif ($fileExtension === 'mp4') {
        $targetFolder = 'Videos/';
        $defaultMediaFile = 'default_video.mp4';
    } else {
        die('Invalid file extension.');
    }

    // Get the base URL of the S3 bucket
    $bucketBaseUrl = "https://childlearn-bucket.s3.amazonaws.com/" . $targetFolder;


    try {
        // Create an S3 client
        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $region
        ]);

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
        //echo 'Error getting file ' . $fileName . ' from S3: ' . $e->getMessage();
        return $bucketBaseUrl . $defaultMediaFile;
    }

    return $bucketBaseUrl . $defaultMediaFile;
}

function getMediaFromCloudFront($fileName)
{
    $cloudFrontDomain = 'd2hmz1phin01an.cloudfront.net';

    // Determine the file extension from the file name
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    // Determine the CloudFront folder based on the file extension
    $targetFolder = '';
    $defaultMediaFile = '';

    if (in_array($fileExtension, ['png', 'jpg', 'jpeg'])) {
        $targetFolder = 'Images/';
        $defaultMediaFile = 'defaultcoursecover.jpg';
    } elseif ($fileExtension === 'mp4') {
        $targetFolder = 'Videos/';
        $defaultMediaFile = 'default_video.mp4';
    } else {
        die('Invalid file extension.');
    }

    try {
        // Generate the full URL link for the retrieved file from CloudFront
        $fileUrl = 'https://' . $cloudFrontDomain . '/' . $targetFolder . $fileName;

        return $fileUrl;
    } catch (Exception $e) {
        // echo 'Error getting file ' . $fileName . ' from CloudFront: ' . $e->getMessage();
        return 'https://' . $cloudFrontDomain . '/' . $targetFolder . $defaultMediaFile;
    }
}
