<?php
require 'vendor/autoload.php'; // Include the AWS SDK for PHP

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// AWS credentials (Access Key and Secret Key)
$credentials = new Aws\Credentials\Credentials(
    'ASIA5WKXJVR5LEP2CZMH',
    'Ahgal3uLGkChiZok4J2+1G9lG0T3WOK/cMRL6AbB',
    'FwoGZXIvYXdzEEgaDDuS+cI2JJoKiITXnCK8Ace187GHPuI54vIsV8vbkfbjHDML8tFiG/PuIvhQghG4r9dtcpjQVfVaOciWiwG5qX/F8i9+orNN5W7PpvwfJ+uQDaDz/Vhig/vkzSrqdDg3lEOajQUZva6tdqWLkdMZeQKbgY35xE/HtelLtywfN0JYFst+8jn67vBOJXXzmhtAZfqWNPU8rtkuyKUrW04EfIJbsp0oxWTrnG+f92Pe7Od/XFXYgcRkaYIlxZ8OoSlle062UrP4BttKKkHXKIOr6qUGMi05khICcoQH7Nxf4A4Y7XqRrTiHmWN8bSbuMAgoEZ4H0mzGftDYD/pLO2/P/KA='
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
        ]);

        return $result;
    } catch (S3Exception $e) {
        echo 'Error uploading file to S3: ' . $e->getMessage();
    }
}
?>

<!-- Sample HTML form to upload an image -->
<!-- <form action="uploadToS3.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" value="Upload Image">
</form> -->

<?php
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
//     $fileType = 'image'; // Change this to 'video' for uploading videos
//     $uploadedFile = $_FILES['file'];

//     $uploadResult = uploadToS3($fileType, $uploadedFile);

//     if ($uploadResult) {
//         echo 'File uploaded successfully to S3!';
//     } else {
//         echo 'File upload failed.';
//     }
// }
?>