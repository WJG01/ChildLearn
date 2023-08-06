<?php

use Aws\Sns\SnsClient; // Use Simple Notification Service
use Aws\Exception\AwsException;

require_once 'vendor/autoload.php'; // Point to composer
require_once 'constant.php';


use Pkerrigan\Xray\Trace;
use Pkerrigan\Xray\RemoteSegment;
use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;


if (!isset($_SESSION)) {
    session_start();
}

include('config.php');

// Get the trace ID and parent ID from the session
// $traceId = $_SESSION['trace_id'];
// $parentId = $_SESSION['parent_id'];


// echo 'SESSION obtained' . $traceId . $parentId;


function sendPasswordResetLink($userEmail, $token)
{
    try {

        // // Set the trace ID and parent ID on the Trace object
        // Trace::getInstance()
        //     ->setTraceId($_SESSION['trace_id'])
        //     ->setParentId($_SESSION['parent_id']);

        // // Start a new X-Ray trace
        // Trace::getInstance()
        //     ->begin(100);

        // // Add a remote segment for the SNS call
        // Trace::getInstance()->getCurrentSegment()->addSubsegment(
        //     (new RemoteSegment())
        //         ->setName('SNSSubscription')
        //         ->begin()
        // );

        // echo 'HELLO';
        // // Print the Trace ID
        // print_r(Trace::getInstance());


        $sns = new SnsClient([
            'version' => 'latest',
            'region' => 'us-east-1',
        ]);
        // Email body of password reset
        $body = '
            Hello there, 

            Please click on the link below to reset your password.
          
            http://childlearn-env-1.eba-49nd49e2.us-east-1.elasticbeanstalk.com/ChildLearn-sns/verification.php?password-token=' . $token . '
            ';


        // Publish the email to the topic
        $result = $sns->publish([
            'TopicArn' => 'arn:aws:sns:us-east-1:941317794938:ChildLearnEmailTopic',
            'Message' => $body,
            'Subject' => 'Reset your password',
            'MessageAttributes' => [
                'email' => [
                    'DataType' => 'String',
                    'StringValue' => $userEmail,
                ],
                'password-token' => [
                    'DataType' => 'String',
                    'StringValue' => $token,
                ],
            ],
        ]);
        // Trace::getInstance()
        //     ->getCurrentSegment()
        //     ->end();

        // End X-Ray for sending email using SNS
        // Trace::getInstance()
        //     ->end()
        //     ->setResponseCode(http_response_code())
        //     ->submit(new DaemonSegmentSubmitter());
    } catch (AwsException $e) {
        // Catch any AWS-related exceptions and log the error message
        $errorMessage = 'AWS Exception: ' . $e->getMessage();
        error_log($errorMessage);
    } catch (Exception $e) {
        // Catch any other exceptions (non-AWS related) and log the error message
        $errorMessage = 'Exception: ' . $e->getMessage();
        error_log($errorMessage);
    }
}

// Subscription filter policy for specific endpoints
function subscribeEmail($userEmail, $token)
{
    $filterPolicy = [
        'email' => [$userEmail],
        'password-token' => [$token]
    ];

    $sns = new SnsClient([
        'version' => 'latest',
        'region' => 'us-east-1',
    ]);
    try {
        // Subscribe the endpoint to the topic
        $result = $sns->subscribe([
            'TopicArn' => 'arn:aws:sns:us-east-1:941317794938:ChildLearnEmailTopic',
            'Protocol' => 'email', // Use 'email' for email subscription
            'Endpoint' => $userEmail,
            'FilterPolicy' => json_encode($filterPolicy),
        ]);

        $subscriptionArn = $result->get('SubscriptionArn');
    } catch (\Aws\Exception\AwsException $e) {
        // Handle the exception, log, or display the error message
        echo "Error: " . $e->getMessage() . "\n";
    }
}
