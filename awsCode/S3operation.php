<?php
require 'vendor/autoload.php'; // Include the AWS SDK for PHP

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

use Pkerrigan\Xray\Trace;
use Pkerrigan\Xray\RemoteSegment;
use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;

if (!isset($_SESSION)) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// AWS credentials (Access Key and Secret Key)
$credentials = new Aws\Credentials\Credentials(
    'ASIA5WKXJVR5DUOGVQED',
    'igAwC+f+073AIkduEuXkjZdzAKX9KGzkEvrNBWmQ',
    'FwoGZXIvYXdzEKT//////////wEaDIB+pnOgFlJIuSbSdyK8AXgTY6umnT9bPC+zcmMjjrRe53+jshzF5eBd+CMsd6u1qpB1icnCOS64Wsujh3ucH2Z2MPSl29AlOEfYyKk4AowjoCPMfGYdf3lyCng+UlNnl0a3rUscFzwSjLoWOFpqAEGWPq6zQhnN234SDB5DFe0woX4CqyDYEvEL5WiKYHONrkDgOiG/X9JWiR/oQa9/zlVk/wW8WVG5sQrWoSebhYPjxmz5A9LOc8rUS6YC1WDXVmBMQjNMTRZS8TJWKJHutqYGMi0bLhYUYehx9S2ZDvXBVAJvNVoiETY6SjRK1YRuwMTZdTy4exji5cn7rlrPIYI='
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
            'region' => $region
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
